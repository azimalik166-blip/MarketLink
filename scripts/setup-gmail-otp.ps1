$ErrorActionPreference = 'Stop'

# This script lives in MarketLink\scripts, so its parent is the project root.
$project = Split-Path -Parent $PSScriptRoot
$envFile = Join-Path $project '.env'

if (-not (Test-Path $envFile)) {
    Write-Host "Could not find .env at $envFile" -ForegroundColor Red
    Write-Host "Make sure this script is inside C:\\xampp\\htdocs\\MarketLink\\scripts\\" -ForegroundColor Yellow
    exit 1
}

Write-Host "MarketLink Gmail OTP setup" -ForegroundColor Cyan
Write-Host "Only MAIL_* settings in .env will be changed." -ForegroundColor Gray
Write-Host "Your App Password is read securely and is not displayed." -ForegroundColor Yellow
Write-Host ""

$sender = Read-Host "Enter the Gmail address that will send MarketLink OTPs"
$sender = $sender.Trim()

if ($sender -notmatch '^[^\s@]+@gmail\.com$') {
    Write-Host "Please enter a valid Gmail address ending in @gmail.com." -ForegroundColor Red
    exit 1
}

$secure = Read-Host "Enter that Gmail account's 16-character Google App Password" -AsSecureString
$ptr = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($secure)
try {
    $appPassword = [Runtime.InteropServices.Marshal]::PtrToStringBSTR($ptr)
} finally {
    [Runtime.InteropServices.Marshal]::ZeroFreeBSTR($ptr)
}
$appPassword = ($appPassword -replace '\s','')

if ($appPassword.Length -ne 16) {
    Write-Host "The App Password should contain 16 characters after spaces are removed." -ForegroundColor Red
    exit 1
}

$content = Get-Content -Raw -Path $envFile

function Set-EnvValue([string]$text, [string]$key, [string]$value) {
    $escaped = [regex]::Escape($key)
    $pattern = "(?m)^$escaped=.*$"
    $line = "$key=$value"

    if ([regex]::IsMatch($text, $pattern)) {
        return [regex]::Replace(
            $text,
            $pattern,
            [System.Text.RegularExpressions.MatchEvaluator]{ param($m) $line }
        )
    }

    if (-not $text.EndsWith("`n")) {
        $text += "`r`n"
    }

    return $text + $line + "`r`n"
}

# Backup the existing .env before changing mail settings.
$backup = Join-Path $project '.env.before-gmail-otp.bak'
Copy-Item $envFile $backup -Force

$content = Set-EnvValue $content 'MAIL_MAILER' 'smtp'
$content = Set-EnvValue $content 'MAIL_HOST' 'smtp.gmail.com'
$content = Set-EnvValue $content 'MAIL_PORT' '587'
$content = Set-EnvValue $content 'MAIL_USERNAME' $sender
$content = Set-EnvValue $content 'MAIL_PASSWORD' $appPassword
$content = Set-EnvValue $content 'MAIL_ENCRYPTION' 'tls'
$content = Set-EnvValue $content 'MAIL_FROM_ADDRESS' $sender
$content = Set-EnvValue $content 'MAIL_FROM_NAME' 'MarketLink'

# Write UTF-8 without BOM so the .env remains clean.
$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
[System.IO.File]::WriteAllText($envFile, $content, $utf8NoBom)

Write-Host "SMTP settings saved." -ForegroundColor Green
Write-Host "Backup created: $backup" -ForegroundColor DarkGray
Write-Host ""
Write-Host "Clearing Laravel configuration cache..." -ForegroundColor Cyan

Push-Location $project
try {
    php artisan config:clear
    if ($LASTEXITCODE -ne 0) { throw "php artisan config:clear failed." }

    php artisan cache:clear
    if ($LASTEXITCODE -ne 0) { throw "php artisan cache:clear failed." }

    php artisan migrate --force
    if ($LASTEXITCODE -ne 0) { throw "php artisan migrate failed." }

    php artisan optimize:clear
    if ($LASTEXITCODE -ne 0) { throw "php artisan optimize:clear failed." }

    Write-Host ""
    Write-Host "Sending a test email is optional." -ForegroundColor Cyan
    $recipient = Read-Host "Enter an email address for a test message (Enter to skip)"
    $recipient = $recipient.Trim()

    if ($recipient) {
        php artisan marketlink:test-mail $recipient
        if ($LASTEXITCODE -ne 0) { throw "Test email command failed." }
    }

    Write-Host ""
    Write-Host "DONE: Forgot Password will send each customer's OTP to the email entered on the form." -ForegroundColor Green
} finally {
    Pop-Location
}

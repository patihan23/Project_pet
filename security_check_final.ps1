# Security Check Script for Pet Management System
Write-Host "Pet Management System - Security Check" -ForegroundColor Green
Write-Host "=======================================" -ForegroundColor Green
Write-Host ""

$passed = @()
$warnings = @()
$issues = @()

# Check important files
Write-Host "1. Checking Important Files..." -ForegroundColor Yellow

$importantFiles = @(
    ".env",
    ".env.example", 
    "config.php",
    "security_check.php",
    "README.md",
    ".gitignore",
    "app_config.php",
    "line_notify.php"
)

foreach ($file in $importantFiles) {
    if (Test-Path $file) {
        $passed += "[OK] Found $file"
    } else {
        $warnings += "[WARN] Missing $file"
    }
}

# Check .env file
Write-Host "2. Checking Environment File..." -ForegroundColor Yellow

if (Test-Path ".env") {
    $envContent = Get-Content ".env" -Raw
    
    $requiredVars = @("DB_HOST", "DB_USERNAME", "DB_PASSWORD", "DB_NAME", "LINE_NOTIFY_TOKEN")
    foreach ($var in $requiredVars) {
        if ($envContent -match "$var=") {
            $passed += "[OK] Found $var in .env"
        } else {
            $issues += "[ERROR] Missing $var in .env"
        }
    }
    
    if ($envContent -match "LINE_NOTIFY_TOKEN=your_line_notify_token_here") {
        $issues += "[ERROR] LINE_NOTIFY_TOKEN is still default value"
    } elseif ($envContent -match "LINE_NOTIFY_TOKEN=.+") {
        $passed += "[OK] LINE_NOTIFY_TOKEN is configured"
    }
} else {
    $issues += "[ERROR] .env file not found"
}

# Check .gitignore
Write-Host "3. Checking Git ignore..." -ForegroundColor Yellow

if (Test-Path ".gitignore") {
    $gitignoreContent = Get-Content ".gitignore" -Raw
    if ($gitignoreContent -match "\.env") {
        $passed += "[OK] .env is in .gitignore"
    } else {
        $issues += "[ERROR] .env is NOT in .gitignore (DANGEROUS!)"
    }
} else {
    $warnings += "[WARN] .gitignore file not found"
}

# Check for old hardcoded token
Write-Host "4. Checking for Old Hardcoded Token..." -ForegroundColor Yellow

$phpFiles = Get-ChildItem -Path "." -Filter "*.php" -Recurse
$oldTokenFound = $false

foreach ($file in $phpFiles) {
    try {
        $content = Get-Content $file.FullName -Raw
        if ($content -match "0V6X2lx2DUEMyFrHjmttdHIybPcHJrWAjjHkIkUBKaL") {
            $relativePath = $file.Name
            $issues += "[ERROR] Old hardcoded LINE token found in $relativePath"
            $oldTokenFound = $true
        }
    } catch {
        continue
    }
}

if (-not $oldTokenFound) {
    $passed += "[OK] No old hardcoded LINE token found"
}

# Check PHP
Write-Host "5. Checking PHP..." -ForegroundColor Yellow

try {
    $null = Get-Command php -ErrorAction Stop
    $passed += "[OK] PHP is available"
} catch {
    $warnings += "[WARN] PHP is not installed"
}

# Summary
Write-Host ""
Write-Host "Security Check Summary" -ForegroundColor Cyan
Write-Host "======================" -ForegroundColor Cyan
Write-Host ""

if ($passed.Count -gt 0) {
    Write-Host "PASSED ($($passed.Count) items):" -ForegroundColor Green
    foreach ($item in $passed) {
        Write-Host "   $item" -ForegroundColor Green
    }
    Write-Host ""
}

if ($warnings.Count -gt 0) {
    Write-Host "WARNINGS ($($warnings.Count) items):" -ForegroundColor Yellow
    foreach ($item in $warnings) {
        Write-Host "   $item" -ForegroundColor Yellow
    }
    Write-Host ""
}

if ($issues.Count -gt 0) {
    Write-Host "CRITICAL ISSUES ($($issues.Count) items):" -ForegroundColor Red
    foreach ($item in $issues) {
        Write-Host "   $item" -ForegroundColor Red
    }
    Write-Host ""
}

# Calculate score
$total = $passed.Count + $warnings.Count + $issues.Count
if ($total -gt 0) {
    $score = [math]::Round(($passed.Count / $total) * 100, 1)
    Write-Host "Security Score: $score%" -ForegroundColor Cyan
    
    if ($score -ge 90) {
        Write-Host "Security Level: Excellent" -ForegroundColor Green
    } elseif ($score -ge 75) {
        Write-Host "Security Level: Good" -ForegroundColor Yellow
    } elseif ($score -ge 60) {
        Write-Host "Security Level: Fair" -ForegroundColor Magenta
    } else {
        Write-Host "Security Level: Needs Improvement" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Cyan
Write-Host "- Open security_check.html in browser" -ForegroundColor White
Write-Host "- Install PHP to run full checks" -ForegroundColor White
Write-Host "- Read ENV_SECURITY_GUIDE.md" -ForegroundColor White

Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

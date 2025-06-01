# Pet Management System - Setup Guide

## Quick Setup

### 1. Environment Configuration
Copy `.env.example` to `.env` and update values:
```bash
# Database
DB_HOST=your_database_host
DB_USERNAME=your_username  
DB_PASSWORD=your_password
DB_NAME=your_database_name

# LINE Notify (optional)
LINE_NOTIFY_TOKEN=your_line_notify_token_here
```

### 2. Security Check
Run security validation:
```bash
# PowerShell
.\security_check_final.ps1

# Web Browser  
# Open security_check.html

# PHP (if installed)
php security_check.php
```

### 3. Important Security Notes
- ✅ `.env` file is in `.gitignore` (never commit secrets)
- ✅ Old hardcoded tokens removed from code
- ✅ Environment variables properly configured
- ⚠️ Update LINE_NOTIFY_TOKEN with real value when needed

### 4. File Structure
```
Project_pet/
├── .env                 # Environment variables (SECRET)
├── .env.example         # Template for environment variables
├── config.php           # Main configuration loader
├── app_config.php       # App configuration class
├── line_notify.php      # LINE notification service
├── DotEnv.php          # Environment variable loader
├── people/             # Main application folder
└── security_check.*    # Security validation tools
```

### 5. Deployment Checklist
- [ ] Copy `.env.example` to `.env`
- [ ] Update database credentials in `.env`
- [ ] Update LINE Notify token (if using notifications)
- [ ] Run security check
- [ ] Verify `.env` is not committed to git
- [ ] Test database connection

That's it! Your pet management system is ready to use.

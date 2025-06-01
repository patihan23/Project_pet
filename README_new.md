# Pet Management System

A web-based pet management system for tracking pet information, vaccinations, and health records.

## Quick Start

1. **Setup Environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

2. **Database Setup**
   - Import SQL files from `Database/` folder
   - Update database credentials in `.env`

3. **Security Check**
   ```bash
   .\security_check_final.ps1
   ```

4. **Access Application**
   - Open `index.php` in web browser
   - Login with your credentials

## Features
- Pet registration and management
- Vaccination tracking and history
- Health record management
- LINE notifications (optional)
- Statistical reports and charts
- Map integration for location tracking

## Security
- Environment variables for sensitive data
- Secure session management
- Input validation and sanitization
- No hardcoded credentials

## Documentation
See `SETUP.md` for detailed setup instructions.

## Structure
- `people/` - Main application files
- `Database/` - SQL database files
- `assets/`, `css/`, `js/` - Frontend resources
- `config.php` - Configuration loader
- `.env` - Environment variables (not in git)

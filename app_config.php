<?php
/**
 * Application Configuration Helper
 * ตัวช่วยจัดการ configuration ของแอปพลิเคชัน
 */

class AppConfig {
    
    /**
     * Get LINE Notify configuration
     */
    public static function getLineNotifyConfig() {
        return [
            'token' => DotEnv::get('LINE_NOTIFY_TOKEN'),
            'api_url' => DotEnv::get('LINE_NOTIFY_API_URL', 'https://notify-api.line.me/api/notify')
        ];
    }
    
    /**
     * Get file upload configuration
     */
    public static function getFileUploadConfig() {
        return [
            'max_size' => (int) DotEnv::get('MAX_UPLOAD_SIZE', 5242880), // 5MB default
            'allowed_extensions' => explode(',', DotEnv::get('ALLOWED_IMAGE_EXTENSIONS', 'jpg,jpeg,png,gif')),
            'upload_path' => DotEnv::get('UPLOAD_PATH', '../profile/')
        ];
    }
    
    /**
     * Get pagination configuration
     */
    public static function getPaginationConfig() {
        return [
            'default_page_size' => (int) DotEnv::get('DEFAULT_PAGE_SIZE', 10),
            'max_page_size' => (int) DotEnv::get('MAX_PAGE_SIZE', 100)
        ];
    }
    
    /**
     * Get session configuration
     */
    public static function getSessionConfig() {
        return [
            'timeout' => (int) DotEnv::get('SESSION_TIMEOUT', 1800), // 30 minutes
            'secure' => DotEnv::get('SESSION_SECURE', 'false') === 'true',
            'httponly' => DotEnv::get('SESSION_HTTPONLY', 'true') === 'true',
            'csrf_token_length' => (int) DotEnv::get('CSRF_TOKEN_LENGTH', 32)
        ];
    }
    
    /**
     * Check if application is in debug mode
     */
    public static function isDebugMode() {
        return DotEnv::get('APP_DEBUG', 'false') === 'true';
    }
    
    /**
     * Get application environment
     */
    public static function getEnvironment() {
        return DotEnv::get('APP_ENV', 'development');
    }
    
    /**
     * Validate required environment variables
     */
    public static function validateEnvironment() {
        $required = [
            'DB_HOST',
            'DB_USERNAME', 
            'DB_PASSWORD',
            'DB_NAME'
        ];
        
        $missing = [];
        foreach ($required as $var) {
            if (!DotEnv::get($var)) {
                $missing[] = $var;
            }
        }
        
        if (!empty($missing)) {
            throw new Exception('Missing required environment variables: ' . implode(', ', $missing));
        }
        
        return true;
    }
}

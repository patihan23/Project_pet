<?php
/**
 * Security Check Script
 * สคริปต์สำหรับตรวจสอบความปลอดภัยของระบบ
 */

require_once __DIR__ . '/config.php';

class SecurityChecker {
    
    private $issues = [];
    private $warnings = [];
    private $passed = [];
    
    public function runAllChecks() {
        echo "🔍 กำลังตรวจสอบความปลอดภัยของระบบ...\n\n";
        
        $this->checkEnvironmentVariables();
        $this->checkFilePermissions();
        $this->checkSensitiveFiles();
        $this->checkSessionSecurity();
        $this->checkDatabaseConnection();
        $this->checkLineNotifyService();
        
        $this->printResults();
    }
    
    private function checkEnvironmentVariables() {
        echo "📋 ตรวจสอบ Environment Variables...\n";
        
        try {
            AppConfig::validateEnvironment();
            $this->passed[] = "✅ Environment variables ครบถ้วน";
        } catch (Exception $e) {
            $this->issues[] = "❌ Environment variables ไม่ครบถ้วน: " . $e->getMessage();
        }
        
        // ตรวจสอบ LINE Notify token
        $lineToken = DotEnv::get('LINE_NOTIFY_TOKEN');
        if (empty($lineToken)) {
            $this->warnings[] = "⚠️ LINE_NOTIFY_TOKEN ไม่ได้ตั้งค่า";
        } else if ($lineToken === 'your_line_notify_token_here') {
            $this->issues[] = "❌ LINE_NOTIFY_TOKEN ยังเป็นค่า default";
        } else {
            $this->passed[] = "✅ LINE_NOTIFY_TOKEN ตั้งค่าแล้ว";
        }
        
        // ตรวจสอบ production settings
        if (AppConfig::getEnvironment() === 'production') {
            if (AppConfig::isDebugMode()) {
                $this->warnings[] = "⚠️ Debug mode เปิดอยู่ใน production";
            }
            
            $sessionConfig = AppConfig::getSessionConfig();
            if (!$sessionConfig['secure']) {
                $this->warnings[] = "⚠️ Session secure ปิดอยู่ใน production";
            }
        }
    }
    
    private function checkFilePermissions() {
        echo "📂 ตรวจสอบสิทธิ์ไฟล์...\n";
        
        $sensitiveFiles = ['.env', 'config.php', 'DotEnv.php'];
        
        foreach ($sensitiveFiles as $file) {
            $fullPath = __DIR__ . '/' . $file;
            if (file_exists($fullPath)) {
                $perms = fileperms($fullPath);
                $octal = substr(sprintf('%o', $perms), -4);
                
                if ($octal !== '0600' && $octal !== '0644') {
                    $this->warnings[] = "⚠️ ไฟล์ {$file} มีสิทธิ์ {$octal} (แนะนำ 0600)";
                } else {
                    $this->passed[] = "✅ ไฟล์ {$file} มีสิทธิ์เหมาะสม";
                }
            }
        }
    }
    
    private function checkSensitiveFiles() {
        echo "🔒 ตรวจสอบไฟล์ sensitive...\n";
        
        // ตรวจสอบว่ามี .env.example
        if (!file_exists(__DIR__ . '/.env.example')) {
            $this->warnings[] = "⚠️ ไม่มีไฟล์ .env.example";
        } else {
            $this->passed[] = "✅ มีไฟล์ .env.example";
        }
        
        // ตรวจสอบ .gitignore
        if (file_exists(__DIR__ . '/.gitignore')) {
            $gitignoreContent = file_get_contents(__DIR__ . '/.gitignore');
            if (strpos($gitignoreContent, '.env') !== false) {
                $this->passed[] = "✅ .env อยู่ใน .gitignore";
            } else {
                $this->issues[] = "❌ .env ไม่อยู่ใน .gitignore";
            }
        } else {
            $this->warnings[] = "⚠️ ไม่มีไฟล์ .gitignore";
        }
        
        // ตรวจสอบ hardcoded credentials
        $this->checkForHardcodedCredentials();
    }
    
    private function checkForHardcodedCredentials() {
        $phpFiles = glob(__DIR__ . '/**/*.php');
        $suspiciousPatterns = [
            '/password\s*=\s*["\'][^"\']{3,}["\']/',
            '/token\s*=\s*["\'][A-Za-z0-9]{20,}["\']/',
            '/api_key\s*=\s*["\'][^"\']{10,}["\']/',
        ];
        
        foreach ($phpFiles as $file) {
            if (strpos($file, 'vendor/') !== false) continue;
            
            $content = file_get_contents($file);
            foreach ($suspiciousPatterns as $pattern) {
                if (preg_match($pattern, $content)) {
                    $relativePath = str_replace(__DIR__ . '/', '', $file);
                    $this->warnings[] = "⚠️ พบ hardcoded credentials ที่น่าสงสัยใน {$relativePath}";
                    break;
                }
            }
        }
    }
    
    private function checkSessionSecurity() {
        echo "🔐 ตรวจสอบความปลอดภัย Session...\n";
        
        $sessionConfig = AppConfig::getSessionConfig();
        
        if ($sessionConfig['httponly']) {
            $this->passed[] = "✅ Session httponly เปิดอยู่";
        } else {
            $this->warnings[] = "⚠️ Session httponly ปิดอยู่";
        }
        
        if ($sessionConfig['timeout'] < 3600) {
            $this->passed[] = "✅ Session timeout เหมาะสม ({$sessionConfig['timeout']} วินาที)";
        } else {
            $this->warnings[] = "⚠️ Session timeout ยาวเกินไป ({$sessionConfig['timeout']} วินาที)";
        }
    }
    
    private function checkDatabaseConnection() {
        echo "🗄️ ตรวจสอบการเชื่อมต่อฐานข้อมูล...\n";
        
        global $conn;
        if ($conn && !mysqli_connect_error()) {
            $this->passed[] = "✅ เชื่อมต่อฐานข้อมูลสำเร็จ";
            
            // ตรวจสอบ SQL injection protection
            if (class_exists('DatabaseUtils')) {
                $this->passed[] = "✅ มี DatabaseUtils สำหรับป้องกัน SQL injection";
            } else {
                $this->warnings[] = "⚠️ ไม่มี DatabaseUtils class";
            }
        } else {
            $this->issues[] = "❌ ไม่สามารถเชื่อมต่อฐานข้อมูล: " . mysqli_connect_error();
        }
    }
    
    private function checkLineNotifyService() {
        echo "📱 ตรวจสอบ LINE Notify Service...\n";
        
        try {
            $lineService = new LineNotifyService();
            $this->passed[] = "✅ LINE Notify Service พร้อมใช้งาน";
        } catch (Exception $e) {
            $this->issues[] = "❌ LINE Notify Service ไม่พร้อมใช้งาน: " . $e->getMessage();
        }
    }
    
    private function printResults() {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📊 สรุปผลการตรวจสอบความปลอดภัย\n";
        echo str_repeat("=", 60) . "\n\n";
        
        if (!empty($this->passed)) {
            echo "✅ PASSED (" . count($this->passed) . " รายการ):\n";
            foreach ($this->passed as $item) {
                echo "   {$item}\n";
            }
            echo "\n";
        }
        
        if (!empty($this->warnings)) {
            echo "⚠️ WARNINGS (" . count($this->warnings) . " รายการ):\n";
            foreach ($this->warnings as $item) {
                echo "   {$item}\n";
            }
            echo "\n";
        }
        
        if (!empty($this->issues)) {
            echo "❌ CRITICAL ISSUES (" . count($this->issues) . " รายการ):\n";
            foreach ($this->issues as $item) {
                echo "   {$item}\n";
            }
            echo "\n";
        }
        
        // สรุปภาพรวม
        $total = count($this->passed) + count($this->warnings) + count($this->issues);
        $score = count($this->passed) / $total * 100;
        
        echo "🎯 คะแนนความปลอดภัย: " . number_format($score, 1) . "%\n";
        
        if ($score >= 90) {
            echo "🟢 ระดับความปลอดภัย: ดีเยี่ยม\n";
        } elseif ($score >= 75) {
            echo "🟡 ระดับความปลอดภัย: ดี\n";
        } elseif ($score >= 60) {
            echo "🟠 ระดับความปลอดภัย: ปานกลาง\n";
        } else {
            echo "🔴 ระดับความปลอดภัย: ต้องปรับปรุง\n";
        }
        
        if (!empty($this->issues)) {
            echo "\n⚠️ กรุณาแก้ไขปัญหาเร่งด่วนก่อนใช้งานจริง!\n";
        }
    }
}

// รันการตรวจสอบเมื่อไฟล์ถูกเรียกโดยตรง
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $checker = new SecurityChecker();
    $checker->runAllChecks();
}

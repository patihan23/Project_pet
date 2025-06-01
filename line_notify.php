<?php
/**
 * LINE Notify Utility Functions
 * ฟังก์ชันสำหรับส่งการแจ้งเตือนผ่าน LINE Notify
 */

class LineNotifyService {
    
    private $token;
    private $apiUrl;
    
    public function __construct() {
        $config = AppConfig::getLineNotifyConfig();
        $this->token = $config['token'];
        $this->apiUrl = $config['api_url'];
        
        if (empty($this->token)) {
            throw new Exception('LINE Notify token is not configured');
        }
    }
    
    /**
     * Send notification message
     */
    public function sendMessage($message) {
        try {
            $data = array('message' => $message);
            $headers = array(
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/x-www-form-urlencoded'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                throw new Exception('cURL Error: ' . $error);
            }

            if ($httpCode !== 200) {
                throw new Exception('LINE Notify API returned HTTP ' . $httpCode . ': ' . $response);
            }

            // Log successful notification if in debug mode
            if (AppConfig::isDebugMode()) {
                error_log('LINE Notify sent successfully: ' . $message);
            }

            return json_decode($response, true);
            
        } catch (Exception $e) {
            // Log error but don't expose sensitive information
            logError('LINE Notify failed to send message', [
                'error' => $e->getMessage(),
                'message_length' => strlen($message)
            ]);
            
            // Return false to indicate failure
            return false;
        }
    }
    
    /**
     * Send vaccine expiration notification
     */
    public function sendVaccineExpirationNotification($petName, $vaccineId, $expirationDate) {
        $formattedDate = convertDateToThai($expirationDate);
        $message = "🐾 แจ้งเตือน: ฉีดวัคซีนสัตว์เลี้ยง '{$petName}' (ID: {$vaccineId}) เกินกำหนดฉีดวัคซีนแล้ว วันครบกำหนดคือ {$formattedDate}";
        
        return $this->sendMessage($message);
    }
    
    /**
     * Send general pet health notification
     */
    public function sendPetHealthNotification($message) {
        $formattedMessage = "🏥 ระบบดูแลสัตว์เลี้ยง: " . $message;
        
        return $this->sendMessage($formattedMessage);
    }
}

/**
 * Helper function for backward compatibility
 */
function sendLineNotify($message) {
    try {
        $lineService = new LineNotifyService();
        return $lineService->sendMessage($message);
    } catch (Exception $e) {
        logError('Failed to initialize LINE Notify service', ['error' => $e->getMessage()]);
        return false;
    }
}

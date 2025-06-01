<?php
/**
 * Example: Secure form processing with CSRF protection and validation
 * ตัวอย่างการประมวลผลฟอร์มที่ปลอดภัยพร้อม CSRF protection
 */

// Include config (which includes all necessary files)
require_once '../config.php';

// Check if user is logged in
requireLogin();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'], $_SESSION['csrf_token'])) {
        redirectWithMessage('history_vaccine.php', 'Invalid request. Please try again.', 'error');
    }
    
    // Process delete history vaccine
    if (isset($_POST['btnDeleteHistory_v'])) {
        try {
            // Sanitize and validate input
            $id_hv = sanitizeInput($_POST['ID_HV']);
            
            if (empty($id_hv)) {
                throw new Exception('ID ประวัติการฉีดวัคซีนไม่ถูกต้อง');
            }
            
            // Check if record exists and belongs to current user (if needed)
            $checkStmt = $conn->prepare("SELECT ID_HV FROM history_vaccine WHERE ID_HV = ?");
            $checkStmt->bind_param("s", $id_hv);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception('ไม่พบข้อมูลที่ต้องการลบ');
            }
            
            // Perform delete operation
            $deleteStmt = $conn->prepare("DELETE FROM history_vaccine WHERE ID_HV = ?");
            $deleteStmt->bind_param("s", $id_hv);
            
            if ($deleteStmt->execute()) {
                redirectWithMessage('history_vaccine.php', 'ลบข้อมูลสำเร็จ', 'success');
            } else {
                throw new Exception('เกิดข้อผิดพลาดในการลบข้อมูล');
            }
            
        } catch (Exception $e) {
            logError('Delete history vaccine failed', [
                'error' => $e->getMessage(),
                'user_id' => $_SESSION['user_id'] ?? 'unknown',
                'id_hv' => $id_hv ?? 'unknown'
            ]);
            redirectWithMessage('history_vaccine.php', $e->getMessage(), 'error');
        }
    }
}

// If no POST request, redirect back
redirectWithMessage('history_vaccine.php', 'ไม่พบการร้องขอ', 'warning');
?>

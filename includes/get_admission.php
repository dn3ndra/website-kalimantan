<?php
require_once '../config/database.php';

function getAdmission() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM admission WHERE is_active = TRUE ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch();
        if ($result) {
            $result['requirements'] = json_decode($result['requirements']);
            $result['procedure'] = json_decode($result['procedure']);
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching admission content: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch admission content']);
    }
}

getAdmission();
?> 
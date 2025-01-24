<?php
require_once '../config/database.php';

function getProgramKerja() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM program_kerja WHERE is_active = TRUE ORDER BY created_at DESC");
        $result = $stmt->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching program kerja: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch program kerja']);
    }
}

getProgramKerja();
?> 
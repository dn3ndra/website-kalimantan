<?php
require_once '../config/database.php';

function getDivisions() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM divisions WHERE is_active = TRUE ORDER BY name ASC");
        $result = $stmt->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching divisions: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch divisions']);
    }
}

getDivisions();
?> 
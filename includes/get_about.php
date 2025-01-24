<?php
require_once '../config/database.php';

function getAbout() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM about_organization WHERE is_active = TRUE ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching about content: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch about content']);
    }
}

getAbout();
?> 
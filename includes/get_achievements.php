<?php
require_once '../config/database.php';

function getAchievements() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM achievements WHERE is_active = TRUE ORDER BY achievement_date DESC");
        $result = $stmt->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching achievements: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch achievements']);
    }
}

getAchievements();
?> 
<?php
require_once '../config/database.php';

function getNews() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM news WHERE is_published = TRUE ORDER BY event_date DESC");
        $result = $stmt->fetchAll();
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching news: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch news']);
    }
}

getNews();
?> 
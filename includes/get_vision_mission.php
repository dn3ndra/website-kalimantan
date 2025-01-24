<?php
require_once '../config/database.php';

function getVisionMission() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM vision_mission WHERE is_active = TRUE ORDER BY id DESC LIMIT 1");
        $result = $stmt->fetch();
        if ($result) {
            // Convert mission points from JSON string to array
            $result['mission_points'] = json_decode($result['mission_points']);
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch(PDOException $e) {
        error_log("Error fetching vision & mission: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch vision & mission']);
    }
}

getVisionMission();
?> 
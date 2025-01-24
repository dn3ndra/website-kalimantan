<?php
require_once '../config/database.php';

function getActivities() {
    $activities = [];
    $baseDir = dirname(__DIR__) . '/dokumentasi';
    
    // Get all category folders
    $categoryFolders = array_filter(glob($baseDir . '/*'), 'is_dir');
    
    foreach ($categoryFolders as $categoryPath) {
        $category = basename($categoryPath);
        
        // Get all event folders within each category
        $eventFolders = array_filter(glob($categoryPath . '/*'), 'is_dir');
        
        foreach ($eventFolders as $eventPath) {
            $eventName = basename($eventPath);
            
            // Get all images in the event folder
            $images = glob($eventPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            
            if (!empty($images)) {
                // Create activity entry
                $activity = [
                    'title' => str_replace('-', ' ', $eventName),
                    'category' => str_replace('-', ' ', $category),
                    'description' => '', // You can add description.txt file in folder if needed
                    'activity_date' => '', // Can be extracted from folder name if following a date format
                    'image_path' => str_replace(dirname(__DIR__) . '/', '', $images[0]), // First image as main image
                    'gallery_images' => array_map(function($img) {
                        return str_replace(dirname(__DIR__) . '/', '', $img);
                    }, $images)
                ];
                
                // Check for description.txt
                if (file_exists($eventPath . '/description.txt')) {
                    $activity['description'] = file_get_contents($eventPath . '/description.txt');
                }
                
                // Try to extract date from folder name if it starts with date (format: YYYY-MM-DD-Event-Name)
                if (preg_match('/^(\d{4}-\d{2}-\d{2})-/', $eventName, $matches)) {
                    $activity['activity_date'] = $matches[1];
                    $activity['title'] = trim(str_replace('-', ' ', substr($eventName, 11)));
                }
                
                $activities[] = $activity;
            }
        }
    }
    
    // Sort by date descending (newest first)
    usort($activities, function($a, $b) {
        return strcmp($b['activity_date'], $a['activity_date']);
    });
    
    header('Content-Type: application/json');
    echo json_encode($activities);
}

getActivities();
?> 
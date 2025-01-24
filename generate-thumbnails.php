<?php
// Simpler version without image resizing
function createThumbnail($sourcePath, $targetPath) {
    // Create target directory if it doesn't exist
    $targetDir = dirname($targetPath);
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Simply copy the file if GD is not available
    return copy($sourcePath, $targetPath);
}

// Process all images
$baseDir = 'images';
$thumbDir = 'thumbnails';

$categories = array_filter(glob($baseDir . '/*'), 'is_dir');

foreach ($categories as $categoryPath) {
    $category = basename($categoryPath);
    $images = glob($categoryPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    
    foreach ($images as $image) {
        $thumbPath = str_replace('images/', 'thumbnails/', $image);
        if (createThumbnail($image, $thumbPath)) {
            echo "Created thumbnail for: " . basename($image) . "<br>";
        } else {
            echo "Failed to create thumbnail for: " . basename($image) . "<br>";
        }
    }
}

echo "Process completed!";
?> 
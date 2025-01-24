<?php
// Get the image path from query parameter
$imagePath = isset($_GET['path']) ? $_GET['path'] : '';

if (empty($imagePath) || !file_exists($imagePath)) {
    header('HTTP/1.1 404 Not Found');
    echo "Image not found";
    exit;
}

// Get file information
$fileInfo = pathinfo($imagePath);
$fileName = $fileInfo['basename'];

// Set headers for file download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . filesize($imagePath));
header('Pragma: public');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

// Clear output buffer
ob_clean();
flush();

// Output file
readfile($imagePath);
exit;
?>
<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getImages() {
    $baseDir = 'images';
    $thumbDir = 'thumbnails';
    
    // Check if directories exist
    if (!is_dir($baseDir) || !is_dir($thumbDir)) {
        error_log("Error: Required directories not found");
        return ['error' => 'Required directories not found'];
    }

    $gallery = [];
    
    $categories = array_filter(glob($baseDir . '/*'), 'is_dir');
    
    foreach ($categories as $categoryPath) {
        $category = basename($categoryPath);
        $images = glob($categoryPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        
        foreach ($images as $image) {
            if (!is_readable($image)) {
                continue;
            }

            // Get thumbnail path
            $thumbPath = str_replace('images/', 'thumbnails/', $image);
            
            // If thumbnail doesn't exist, use original image
            if (!file_exists($thumbPath)) {
                $thumbPath = $image;
            }

            $gallery[] = [
                'category' => $category,
                'path' => str_replace('\\', '/', $image),
                'thumbnail' => str_replace('\\', '/', $thumbPath),
                'alt' => pathinfo($image, PATHINFO_FILENAME)
            ];
        }
    }
    
    return $gallery;
}

function getTeamMembers() {
    // This would typically come from a database
    return [
        [
            'name' => 'John Doe',
            'position' => 'President',
            'image' => 'images/team/member1.jpg',
            'social' => [
                'linkedin' => '#',
                'twitter' => '#',
                'instagram' => '#'
            ]
        ],
        // Add more team members here
    ];
}

function getNewsItems() {
    // This would typically come from a database
    return [
        [
            'title' => 'Annual Leadership Conference',
            'date' => '2024-03-15',
            'image' => 'images/news/event1.jpg',
            'excerpt' => 'Join us for our annual leadership conference...',
            'link' => '#'
        ],
        // Add more news items here
    ];
}

$result = getImages();
echo json_encode($result, JSON_PRETTY_PRINT);

// Return the data as JSON
echo json_encode([
    'team' => getTeamMembers(),
    'news' => getNewsItems()
]);

$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$title = isset($_GET['title']) ? $_GET['title'] : '';

// Security check to prevent directory traversal
$folder = str_replace('..', '', $folder);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gallery-container {
            padding: 80px 20px 20px;
            background: #0a0a0a;
            min-height: 100vh;
        }
        .gallery-header {
            max-width: 1200px;
            margin: 0 auto 2rem;
            color: #fff;
        }
        .gallery-header h1 {
            color: #00ff2a;
            margin-bottom: 0.5rem;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .gallery-item {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 8px;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }
        .back-button:hover {
            color: #00ff2a;
        }
        .back-button i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="gallery-container">
        <div class="gallery-header">
            <a href="activities.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Activities
            </a>
            <h1><?php echo htmlspecialchars($title); ?></h1>
            <div class="gallery-meta">
                <?php
                if ($folder) {
                    $images = glob("dokumentasi/$folder/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                    $count = count($images);
                    echo "<span>{$count} photos</span>";
                }
                ?>
            </div>
        </div>

        <div class="gallery-grid">
            <?php
            if ($folder) {
                foreach ($images as $image) {
                    echo "<div class='gallery-item'>";
                    echo "<a href='{$image}' data-lightbox='gallery' data-title='{$title}'>";
                    echo "<img src='{$image}' alt='{$title}'>";
                    echo "</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Add Lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Photo %1 of %2'
        });
    </script>
</body>
</html> 
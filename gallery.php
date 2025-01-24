<?php
$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$title = isset($_GET['title']) ? $_GET['title'] : '';

// Security check to prevent directory traversal
$folder = str_replace(['..', '\\'], ['', '/'], $folder);

// Debug information
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the absolute path to the dokumentasi directory
$baseDir = dirname(__FILE__) . '/dokumentasi';
$galleryDir = $baseDir . '/' . $folder;

// Debug output
error_log("Folder path: " . $folder);
error_log("Gallery directory: " . $galleryDir);

// Get images with proper path handling
if ($folder) {
    $images = glob("dokumentasi/$folder/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    if (empty($images)) {
        error_log("No images found in: dokumentasi/$folder/");
    } else {
        error_log("Found " . count($images) . " images in: dokumentasi/$folder/");
        foreach ($images as $img) {
            error_log("Image found: " . $img);
            error_log("File exists: " . (file_exists($img) ? 'Yes' : 'No'));
            error_log("Is readable: " . (is_readable($img) ? 'Yes' : 'No'));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/activities.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    
    <style>
    /* Additional styles for lightbox */
    .gallery-item {
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .gallery-link {
        display: block;
        width: 100%;
        height: 100%;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    /* Lightbox customization */
    .lb-outerContainer {
        background-color: transparent;
    }
    
    .lb-dataContainer {
        background-color: transparent;
    }
    
    .lb-nav a.lb-prev,
    .lb-nav a.lb-next {
        opacity: 0.8;
    }
    
    .lb-nav a.lb-prev:hover,
    .lb-nav a.lb-next:hover {
        opacity: 1;
    }

    .fullscreen-viewer {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        display: none;
    }

    .viewer-image {
        max-width: 90%;
        max-height: 90vh;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        object-fit: contain;
    }

    .close-viewer {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: white;
        font-size: 30px;
        cursor: pointer;
        z-index: 10000;
        padding: 10px;
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        border: 2px solid #00ff2a;
        color: #00ff2a;
        font-size: 24px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-btn:hover {
        background: rgba(0, 255, 42, 0.2);
        box-shadow: 0 0 20px rgba(0, 255, 42, 0.5);
    }

    .prev-btn {
        left: 20px;
    }

    .next-btn {
        right: 20px;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
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
                    echo "<span><i class='fas fa-images'></i> {$count} photos</span>";
                }
                ?>
            </div>
        </div>

        <div class="gallery-grid">
            <?php
            if ($folder && !empty($images)) {
                foreach ($images as $image) {
                    // Get relative path from document root
                    $imagePath = str_replace('\\', '/', $image);
                    
                    echo "<div class='gallery-item'>";
                    echo "<a href='" . $imagePath . "' data-lightbox='gallery' class='gallery-link'>";
                    echo "<img src='" . $imagePath . "' alt='" . htmlspecialchars($title) . "'>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-images'>No images found in this gallery.</p>";
            }
            ?>
        </div>

        <div class="fullscreen-viewer">
            <button class="close-viewer">&times;</button>
            <button class="nav-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="nav-btn next-btn"><i class="fas fa-chevron-right"></i></button>
            <img src="" alt="" class="viewer-image">
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Move scripts right before closing body tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
    $(document).ready(function() {
        const viewer = $('.fullscreen-viewer');
        const viewerImg = $('.viewer-image');
        const images = $('.gallery-item img').map(function() {
            return $(this).attr('src');
        }).get();
        let currentIndex = 0;

        // Open viewer
        $('.gallery-item').on('click', function(e) {
            e.preventDefault();
            currentIndex = $(this).index();
            showImage(currentIndex);
            viewer.fadeIn(300);
            $('body').css('overflow', 'hidden');
        });

        // Close viewer
        $('.close-viewer').on('click', function() {
            viewer.fadeOut(300);
            $('body').css('overflow', '');
        });

        // Next image
        $('.next-btn').on('click', function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        });

        // Previous image
        $('.prev-btn').on('click', function(e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        });

        // Close on background click
        viewer.on('click', function(e) {
            if (e.target === this) {
                viewer.fadeOut(300);
                $('body').css('overflow', '');
            }
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (!viewer.is(':visible')) return;
            
            switch(e.key) {
                case 'ArrowRight':
                    $('.next-btn').click();
                    break;
                case 'ArrowLeft':
                    $('.prev-btn').click();
                    break;
                case 'Escape':
                    $('.close-viewer').click();
                    break;
            }
        });

        function showImage(index) {
            viewerImg.attr('src', images[index]);
        }
    });
    </script>

    <script src="js/smooth-scroll.js"></script>

    <!-- Add debug output -->
    <script>
        console.log('Available images:', <?php echo json_encode($images); ?>);
    </script>
</body>
</html> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Activities & Events - Student Organization</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/activities.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
</head>
<body>
    <!-- Include your header/navigation -->
    <?php include 'includes/header.php'; ?>

    <!-- Activities Hero Section -->
    <section class="activities-hero">
        <div class="container">
            <h1>Our Activities & Events</h1>
            <p>Documenting our journey through impactful events and memorable moments</p>
        </div>
    </section>

    <!-- Activities Filter -->
    <section class="activities-filter">
        <div class="container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Events</button>
                <button class="filter-btn" data-filter="workshops">Workshops</button>
                <button class="filter-btn" data-filter="community">Community Service</button>
                <button class="filter-btn" data-filter="social">Social Events</button>
                <button class="filter-btn" data-filter="competitions">Competitions</button>
            </div>
        </div>
    </section>

    <!-- Activities Gallery -->
    <section class="activities-gallery">
        <div class="container">
            <div class="gallery-grid">
                <!-- Gallery items will be loaded dynamically -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php 
        if (file_exists('includes/footer.php')) {
            include 'includes/footer.php';
        } else {
            // Fallback footer if file doesn't exist
            echo '<footer class="main-footer">
                <div class="container">
                    <div class="footer-bottom">
                        <p>&copy; 2024 Your Organization Name. All rights reserved.</p>
                    </div>
                </div>
            </footer>';
        }
    ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="js/activities.js"></script>
    <script src="js/smooth-scroll.js"></script>
</body>
</html> 
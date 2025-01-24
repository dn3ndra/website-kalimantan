<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UKM Kalimantan Telkom University</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Slider Section -->
    <div class="hero-slider">
        <div class="hero-text">
            <h1>UKM Kalimantan</h1>
            <h2>Telkom University</h2>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $sliderImages = glob('slider/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach ($sliderImages as $image) {
                    echo "<div class='swiper-slide'><img src='$image' alt='Slider Image'></div>";
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <!-- About Organization Section -->
    <section id="about-organization" class="section">
        <div class="container">
            <h2 class="section-title">About Our Organization</h2>
            <div class="about-content">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </section>

    <!-- Program Kerja Section -->
    <section id="program-kerja" class="section">
        <div class="container">
            <h2 class="section-title">Program Kerja</h2>
            <div class="program-grid">
                <!-- Program cards will be loaded dynamically -->
            </div>
        </div>
    </section>

    <!-- Achievement Section -->
    <section id="achievement" class="section">
        <div class="container">
            <h2 class="section-title">Achievement</h2>
            <div class="achievement-list">
                <!-- Achievements will be loaded dynamically -->
            </div>
        </div>
    </section>

    <!-- Division Section -->
    <section id="division" class="section">
        <div class="container">
            <h2 class="section-title">Division</h2>
            <div class="division-grid">
                <!-- Division cards will be loaded dynamically -->
            </div>
        </div>
    </section>

    <!-- Leader's Remarks -->
    <section id="leaders" class="section">
        <div class="container">
            <h2 class="section-title">Leader's Remarks</h2>
            <div class="leader-content">
                <img src="images/leader/leader.jpg" alt="Leader's Photo" class="leader-photo">
                <div class="leader-message">
                    <h3>John Doe</h3>
                    <p class="leader-position">Organization President</p>
                    <p class="leader-quote">"Our organization strives to create meaningful impact through dedication and innovation."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision and Mission -->
    <section id="vision" class="section">
        <div class="container">
            <h2 class="section-title">Vision & Mission</h2>
            <div class="vision-mission-content">
                <div class="vision-box">
                    <h3>Vision</h3>
                    <p>To become the leading student organization fostering excellence and innovation.</p>
                </div>
                <div class="mission-box">
                    <h3>Mission</h3>
                    <ul>
                        <li>Empower students through leadership opportunities</li>
                        <li>Foster collaboration and innovation</li>
                        <li>Create positive impact in our community</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet the Team -->
    <section id="team" class="section">
        <div class="container">
            <h2 class="section-title">Meet the Team</h2>
            <div class="team-grid">
                <!-- Team members will be loaded dynamically via team.js -->
            </div>
        </div>
    </section>

    <!-- News/Blog Section -->
    <section id="news" class="section">
        <div class="container">
            <h2 class="section-title">Latest News & Events</h2>
            <div class="news-grid">
                <!-- News items will be loaded dynamically via JavaScript -->
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="section">
        <div class="container">
            <h2 class="section-title">What People Say</h2>
            <div class="testimonials-slider swiper-container">
                <div class="swiper-wrapper">
                    <!-- Testimonials will be loaded dynamically via JavaScript -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: contact@organization.com</p>
                    <p>Phone: (123) 456-7890</p>
                    <p>Address: Your Organization Address</p>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#news">News</a></li>
                        <li><a href="#team">Our Team</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Your Organization Name. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/team.js"></script>
    <script src="js/smooth-scroll.js"></script>
</body>
</html> 
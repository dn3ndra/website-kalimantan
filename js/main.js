document.addEventListener('DOMContentLoaded', function() {
    // Initialize Hero Slider
    const heroSwiper = new Swiper('.hero-slider .swiper-container', {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });

    // Load Team Members
    async function loadTeamMembers() {
        try {
            const response = await fetch('includes/get_team.php');
            if (!response.ok) throw new Error('Failed to fetch team members');
            const teamMembers = await response.json();
            
            const teamGrid = document.querySelector('.team-grid');
            if (teamGrid && teamMembers.length > 0) {
                teamGrid.innerHTML = teamMembers.map(member => `
                    <div class="team-member">
                        <div class="member-image">
                            <img src="${member.image_path}" alt="${member.name}">
                        </div>
                        <div class="member-info">
                            <h3>${member.name}</h3>
                            <p class="member-position">${member.position}</p>
                            ${member.bio ? `<p class="member-bio">${member.bio}</p>` : ''}
                            <div class="member-social">
                                ${member.linkedin_url ? `
                                    <a href="${member.linkedin_url}" target="_blank" title="LinkedIn">
                                        <i class="fab fa-linkedin"></i>
                                    </a>` : ''}
                                ${member.twitter_url ? `
                                    <a href="${member.twitter_url}" target="_blank" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>` : ''}
                                ${member.instagram_url ? `
                                    <a href="${member.instagram_url}" target="_blank" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>` : ''}
                                ${member.email ? `
                                    <a href="mailto:${member.email}" title="Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                teamGrid.innerHTML = '<p class="no-data">No team members found</p>';
            }
        } catch (error) {
            console.error('Error loading team members:', error);
            const teamGrid = document.querySelector('.team-grid');
            if (teamGrid) {
                teamGrid.innerHTML = '<p class="error-message">Error loading team members</p>';
            }
        }
    }

    // Load News
    async function loadNews() {
        try {
            const response = await fetch('includes/get_news.php');
            if (!response.ok) throw new Error('Failed to fetch news');
            const newsItems = await response.json();
            
            const newsGrid = document.querySelector('.news-grid');
            if (newsGrid && newsItems.length > 0) {
                newsGrid.innerHTML = newsItems.map(item => `
                    <div class="news-item">
                        <div class="news-image">
                            <img src="${item.image_path}" alt="${item.title}">
                        </div>
                        <div class="news-content">
                            <div class="news-date">${new Date(item.event_date).toLocaleDateString()}</div>
                            <h3>${item.title}</h3>
                            <p>${item.excerpt}</p>
                            <a href="news.php?slug=${item.slug}" class="read-more">Read More</a>
                        </div>
                    </div>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading news:', error);
        }
    }

    // Load Testimonials
    async function loadTestimonials() {
        try {
            const response = await fetch('includes/get_testimonials.php');
            if (!response.ok) throw new Error('Failed to fetch testimonials');
            const testimonials = await response.json();
            
            const testimonialWrapper = document.querySelector('.testimonials-slider .swiper-wrapper');
            if (testimonialWrapper && testimonials.length > 0) {
                testimonialWrapper.innerHTML = testimonials.map(testimonial => `
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="testimonial-image">
                                <img src="${testimonial.image_path}" alt="${testimonial.author_name}">
                            </div>
                            <p class="testimonial-text">${testimonial.content}</p>
                            <div class="testimonial-author">
                                <h4>${testimonial.author_name}</h4>
                                <p>${testimonial.author_position}</p>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Initialize Testimonials Slider
                new Swiper('.testimonials-slider', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });
            }
        } catch (error) {
            console.error('Error loading testimonials:', error);
        }
    }

    // Load About Content
    async function loadAbout() {
        try {
            const response = await fetch('includes/get_about.php');
            if (!response.ok) throw new Error('Failed to fetch about content');
            const aboutData = await response.json();
            
            const aboutContent = document.querySelector('.about-content');
            if (aboutContent && aboutData) {
                aboutContent.innerHTML = `
                    <p>${aboutData.content}</p>
                `;
            }
        } catch (error) {
            console.error('Error loading about content:', error);
        }
    }

    // Load Vision & Mission
    async function loadVisionMission() {
        try {
            const response = await fetch('includes/get_vision_mission.php');
            if (!response.ok) throw new Error('Failed to fetch vision & mission');
            const vmData = await response.json();
            
            const visionBox = document.querySelector('.vision-box');
            const missionBox = document.querySelector('.mission-box');
            
            if (visionBox && missionBox && vmData) {
                visionBox.innerHTML = `
                    <h3>${vmData.vision_title}</h3>
                    <p>${vmData.vision_content}</p>
                `;
                
                missionBox.innerHTML = `
                    <h3>${vmData.mission_title}</h3>
                    <ul>
                        ${vmData.mission_points.map(point => `<li>${point}</li>`).join('')}
                    </ul>
                `;
            }
        } catch (error) {
            console.error('Error loading vision & mission:', error);
        }
    }

    // Load Program Kerja
    async function loadProgramKerja() {
        try {
            const response = await fetch('includes/get_program_kerja.php');
            if (!response.ok) throw new Error('Failed to fetch program kerja');
            const programs = await response.json();
            
            const programGrid = document.querySelector('.program-grid');
            if (programGrid && programs.length > 0) {
                programGrid.innerHTML = programs.map(program => `
                    <div class="program-card">
                        ${program.image_path ? `
                            <div class="program-image">
                                <img src="${program.image_path}" alt="${program.title}">
                            </div>
                        ` : ''}
                        <div class="program-content">
                            <h3>${program.title}</h3>
                            <p>${program.description}</p>
                            <span class="program-status ${program.status.toLowerCase()}">${program.status}</span>
                        </div>
                    </div>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading program kerja:', error);
        }
    }

    // Load Achievements
    async function loadAchievements() {
        try {
            const response = await fetch('includes/get_achievements.php');
            if (!response.ok) throw new Error('Failed to fetch achievements');
            const achievements = await response.json();
            
            const achievementList = document.querySelector('.achievement-list');
            if (achievementList && achievements.length > 0) {
                achievementList.innerHTML = achievements.map(achievement => `
                    <div class="achievement-item">
                        ${achievement.image_path ? `
                            <div class="achievement-image">
                                <img src="${achievement.image_path}" alt="${achievement.title}">
                            </div>
                        ` : ''}
                        <div class="achievement-content">
                            <h3>${achievement.title}</h3>
                            <p>${achievement.description}</p>
                            <div class="achievement-meta">
                                <span class="achievement-date">
                                    ${new Date(achievement.achievement_date).toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    })}
                                </span>
                                ${achievement.category ? `
                                    <span class="achievement-category">${achievement.category}</span>
                                ` : ''}
                            </div>
                            ${achievement.award_by ? `
                                <div class="award-by">
                                    Awarded by: ${achievement.award_by}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `).join('');
            } else {
                achievementList.innerHTML = '<p class="no-data">No achievements found</p>';
            }
        } catch (error) {
            console.error('Error loading achievements:', error);
            const achievementList = document.querySelector('.achievement-list');
            if (achievementList) {
                achievementList.innerHTML = '<p class="error-message">Error loading achievements</p>';
            }
        }
    }

    // Load Divisions
    async function loadDivisions() {
        try {
            const response = await fetch('includes/get_divisions.php');
            if (!response.ok) throw new Error('Failed to fetch divisions');
            const divisions = await response.json();
            
            const divisionGrid = document.querySelector('.division-grid');
            if (divisionGrid && divisions.length > 0) {
                divisionGrid.innerHTML = divisions.map(division => `
                    <div class="division-card">
                        <div class="division-image">
                            <img src="${division.image_path}" alt="${division.name}">
                        </div>
                        <div class="division-content">
                            <h3>${division.name}</h3>
                            <p>${division.description}</p>
                            ${division.leader_name ? `
                                <div class="division-leader">
                                    <strong>Leader:</strong> ${division.leader_name}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `).join('');
            }
        } catch (error) {
            console.error('Error loading divisions:', error);
        }
    }

    // Load all data
    loadTeamMembers();
    loadNews();
    loadTestimonials();
    loadAbout();
    loadVisionMission();
    loadProgramKerja();
    loadAchievements();
    loadDivisions();

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Mobile menu handling
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const dropdowns = document.querySelectorAll('.dropdown > a');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        menuToggle.innerHTML = navLinks.classList.contains('active') ? 
            '<i class="fas fa-times"></i>' : 
            '<i class="fas fa-bars"></i>';
    });

    // Handle dropdown toggles on mobile
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parent = dropdown.parentElement;
                parent.classList.toggle('active');
                
                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.parentElement.classList.remove('active');
                    }
                });
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
            navLinks.classList.remove('active');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            dropdowns.forEach(dropdown => {
                dropdown.parentElement.classList.remove('active');
            });
        }
    });

    // Add some additional styles to your CSS
    const additionalStyles = `
        .program-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 1rem;
        }

        .program-status.planned {
            background: #2d3436;
            color: #dfe6e9;
        }

        .program-status.ongoing {
            background: #00b894;
            color: #fff;
        }

        .program-status.completed {
            background: #00cec9;
            color: #fff;
        }

        .achievement-date {
            color: #00ff2a;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .division-leader {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #1a1a1a;
            font-size: 0.875rem;
        }
    `;

    // Add the styles to your document
    const styleSheet = document.createElement("style");
    styleSheet.textContent = additionalStyles;
    document.head.appendChild(styleSheet);
}); 
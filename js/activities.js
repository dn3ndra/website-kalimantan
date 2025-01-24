document.addEventListener('DOMContentLoaded', function() {
    // Load Activities
    async function loadActivities() {
        try {
            const response = await fetch('includes/get_activities.php');
            if (!response.ok) throw new Error('Failed to fetch activities');
            const activities = await response.json();
            
            const galleryGrid = document.querySelector('.gallery-grid');
            if (galleryGrid && activities.length > 0) {
                galleryGrid.innerHTML = activities.map(activity => {
                    // Create folder path based on date and title
                    const eventDate = activity.activity_date || '2024-12-16'; // Default date if none exists
                    const folderPath = `${activity.category.toLowerCase()}/${eventDate}-${activity.title.toLowerCase().replace(/\s+/g, '-')}`;
                    console.log('Generated folder path:', folderPath);
                    
                    return `
                    <div class="gallery-item" data-category="${activity.category.toLowerCase()}">
                        <a href="gallery.php?folder=${encodeURIComponent(folderPath)}&title=${encodeURIComponent(activity.title)}" class="gallery-link">
                            <div class="gallery-image">
                                <img src="${activity.image_path}" alt="${activity.title}">
                            </div>
                            <div class="gallery-info">
                                <h3>${activity.title}</h3>
                                <p>${activity.description || 'No description available.'}</p>
                                <div class="event-meta">
                                    ${activity.activity_date ? `
                                        <span class="event-date">
                                            ${new Date(activity.activity_date).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            })}
                                        </span>
                                    ` : ''}
                                    <span class="event-category">${activity.category}</span>
                                </div>
                                <div class="gallery-count">
                                    <i class="fas fa-images"></i> ${activity.gallery_images.length} photos
                                </div>
                            </div>
                        </a>
                    </div>
                    `;
                }).join('');

                // Initialize Lightbox
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'albumLabel': 'Photo %1 of %2',
                    'fadeDuration': 300,
                    'imageFadeDuration': 300
                });

                // Check for URL parameter and filter accordingly
                const urlParams = new URLSearchParams(window.location.search);
                const filterParam = urlParams.get('filter');
                if (filterParam) {
                    const filterButton = document.querySelector(`.filter-btn[data-filter="${filterParam}"]`);
                    if (filterButton) {
                        filterButton.click();
                    }
                }
            }
        } catch (error) {
            console.error('Error loading activities:', error);
        }
    }

    // Filter Functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter gallery items
            const filter = button.dataset.filter;
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            galleryItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });

            // Update URL without refreshing the page
            const url = new URL(window.location);
            if (filter === 'all') {
                url.searchParams.delete('filter');
            } else {
                url.searchParams.set('filter', filter);
            }
            window.history.pushState({}, '', url);
        });
    });

    // Load activities when page loads
    loadActivities();
}); 
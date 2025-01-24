document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    const gallery = document.getElementById('gallery');
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('expandedImage');
    const closeModal = document.querySelector('.close-modal');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const downloadAllBtn = document.getElementById('downloadAllBtn');
    const downloadBtnText = document.getElementById('downloadBtnText');
    const downloadSingleBtn = document.getElementById('downloadSingleBtn');
    const creditsFooter = document.querySelector('.credits-footer');
    const shareFolderBtn = document.getElementById('shareFolderBtn');
    
    let allImages = [];
    let currentImageIndex = 0;
    let currentImages = [];
    let isFooterVisible = false;
    let lastScrollPosition = 0;

    // Initialize hero slider
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
    });

    // Load images from server
    async function loadImages() {
        try {
            const response = await fetch('includes/get_activities.php');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            
            // Debug: Log the received data
            console.log('Received data:', data);
            
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allImages = data;
            displayImages('all');
        } catch (error) {
            console.error('Error loading images:', error);
            gallery.innerHTML = `<p class="error">Error loading images. Please check console for details.</p>`;
        }
    }

    // Display images based on category
    function displayImages(category) {
        console.log('Displaying category:', category);
        console.log('Available images:', allImages);
        
        gallery.innerHTML = '';
        
        currentImages = category === 'all' 
            ? allImages 
            : allImages.filter(img => img.category === category);
            
        console.log('Images to show:', currentImages);

        if (currentImages.length === 0) {
            gallery.innerHTML = `<p class="no-images">No images found in this category</p>`;
            return;
        }

        currentImages.forEach((imageData, index) => {
            const card = document.createElement('div');
            card.className = 'image-card';
            card.dataset.category = imageData.category;
            
            const img = document.createElement('img');
            img.src = imageData.thumbnail;
            img.dataset.fullImage = imageData.path;
            img.alt = imageData.alt;
            
            img.onload = () => console.log('Thumbnail loaded:', imageData.thumbnail);
            img.onerror = () => console.error('Thumbnail failed to load:', imageData.thumbnail);
            
            card.appendChild(img);
            gallery.appendChild(card);

            // Update click event for modal
            img.addEventListener('click', () => {
                currentImageIndex = index;
                openModal(imageData.path, img);
            });

            addShareButton(card, imageData);
        });

        updateDownloadButtonText(category);
        shareFolderBtn.innerHTML = `<i class="fas fa-share-alt"></i> Share ${category === 'all' ? 'Album' : category}`;
    }

    // Add function to open modal
    function openModal(fullImagePath, thumbnailImg) {
        modal.style.display = 'block';
        
        // First show the thumbnail
        modalImg.src = thumbnailImg.src;
        modalImg.classList.add('active');
        
        // Then load the full image
        const fullImage = new Image();
        fullImage.onload = () => {
            modalImg.src = fullImagePath;
        };
        fullImage.src = fullImagePath;
        
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        updateNavigationButtons();
        
        downloadSingleBtn.onclick = () => downloadImage(fullImagePath);
        creditsFooter.classList.remove('visible');
        document.querySelector('.download-section').classList.remove('footer-visible');
        isFooterVisible = false;
    }

    // Add function to update navigation buttons
    function updateNavigationButtons() {
        prevButton.style.display = currentImageIndex > 0 ? 'flex' : 'none';
        nextButton.style.display = currentImageIndex < currentImages.length - 1 ? 'flex' : 'none';
    }

    // Add navigation button click handlers
    prevButton.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentImageIndex > 0) {
            const currentImg = modalImg;
            currentImg.classList.add('slide-left-exit');
            
            setTimeout(() => {
                currentImageIndex--;
                const imageData = currentImages[currentImageIndex];
                
                // Show thumbnail first
                modalImg.src = imageData.thumbnail;
                
                // Load full image
                const fullImage = new Image();
                fullImage.onload = () => {
                    modalImg.src = imageData.path;
                };
                fullImage.src = imageData.path;
                
                // Rest of your animation code...
                currentImg.classList.remove('slide-left-exit');
                currentImg.classList.add('slide-right-enter');
                
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        currentImg.classList.remove('slide-right-enter');
                        currentImg.classList.add('active');
                    });
                });
                updateNavigationButtons();
                downloadSingleBtn.onclick = () => downloadImage(imageData.path);
            }, 300);
        }
    });

    nextButton.addEventListener('click', (e) => {
        e.stopPropagation();
        if (currentImageIndex < currentImages.length - 1) {
            const currentImg = modalImg;
            currentImg.classList.add('slide-right-exit');
            
            setTimeout(() => {
                currentImageIndex++;
                const imageData = currentImages[currentImageIndex];
                
                // Show thumbnail first
                modalImg.src = imageData.thumbnail;
                
                // Load full image
                const fullImage = new Image();
                fullImage.onload = () => {
                    modalImg.src = imageData.path;
                };
                fullImage.src = imageData.path;
                
                // Rest of your animation code...
                currentImg.classList.remove('slide-right-exit');
                currentImg.classList.add('slide-left-enter');
                
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        currentImg.classList.remove('slide-left-enter');
                        currentImg.classList.add('active');
                    });
                });
                updateNavigationButtons();
                downloadSingleBtn.onclick = () => downloadImage(imageData.path);
            }, 300);
        }
    });

    // Add keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (modal.style.display === 'block') {
            if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
                prevButton.click(); // Reuse the click handler
            } else if (e.key === 'ArrowRight' && currentImageIndex < currentImages.length - 1) {
                nextButton.click(); // Reuse the click handler
            }
        }
    });

    // Category filtering
    categorySelect.addEventListener('change', () => {
        const category = categorySelect.value;
        displayImages(category);
    });

    // Close modal function
    function closeModalFunction() {
        modalImg.classList.remove('active');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Close modal click
    closeModal.addEventListener('click', closeModalFunction);

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModalFunction();
        }
    });

    // Close modal with escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModalFunction();
        }
    });

    // Initial load
    loadImages();

    // Update download button text based on category
    function updateDownloadButtonText(category) {
        if (category === 'all') {
            downloadBtnText.textContent = 'Download All';
        } else {
            downloadBtnText.textContent = `Download ${category.charAt(0).toUpperCase() + category.slice(1)}`;
        }
    }

    // Add this function to handle single image download
    function downloadImage(imagePath) {
        const link = document.createElement('a');
        link.href = imagePath;
        link.download = imagePath.split('/').pop(); // Get the filename
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Update the download all functionality
    downloadAllBtn.addEventListener('click', async () => {
        const currentCategory = categorySelect.value;
        const imagesToDownload = currentCategory === 'all' ? 
            allImages : 
            allImages.filter(img => img.category === currentCategory);

        if (imagesToDownload.length === 0) {
            alert('No images found in this category');
            return;
        }

        downloadAllBtn.disabled = true;
        downloadBtnText.textContent = 'Downloading...';

        try {
            // Download images one by one
            for (const imageData of imagesToDownload) {
                await downloadImage(imageData.path);
                // Small delay between downloads to prevent browser issues
                await new Promise(resolve => setTimeout(resolve, 500));
            }
        } catch (error) {
            console.error('Error downloading images:', error);
            alert('Failed to download some images. Please try again.');
        } finally {
            downloadAllBtn.disabled = false;
            updateDownloadButtonText(currentCategory);
        }
    });

    // Update the scroll handler
    window.addEventListener('scroll', () => {
        const currentScroll = window.scrollY;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const downloadSection = document.querySelector('.download-section');
        
        // Show footer when near bottom (within 100px)
        if (currentScroll + windowHeight >= documentHeight - 100) {
            if (!isFooterVisible) {
                creditsFooter.classList.add('visible');
                downloadSection.classList.add('footer-visible');
                isFooterVisible = true;
            }
        } else {
            if (isFooterVisible) {
                creditsFooter.classList.remove('visible');
                downloadSection.classList.remove('footer-visible');
                isFooterVisible = false;
            }
        }
        
        lastScrollPosition = currentScroll;
    });

    // Add share functionality
    function addShareButton(imageCard, imageData) {
        const shareBtn = document.createElement('button');
        shareBtn.className = 'share-btn';
        shareBtn.innerHTML = '<i class="fas fa-share-alt"></i>'; // Using Font Awesome icon
        shareBtn.title = 'Share Image'; // Add tooltip
        
        shareBtn.addEventListener('click', async (e) => {
            e.stopPropagation();
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Check out this image',
                        text: imageData.alt,
                        url: window.location.origin + '/' + imageData.path
                    });
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        console.error('Share failed:', err);
                    }
                }
            } else {
                // Fallback: Copy link to clipboard
                try {
                    await navigator.clipboard.writeText(
                        window.location.origin + '/' + imageData.path
                    );
                    
                    // Show success feedback
                    shareBtn.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => {
                        shareBtn.innerHTML = '<i class="fas fa-share-alt"></i>';
                    }, 2000);
                } catch (err) {
                    console.error('Copy failed:', err);
                    alert('Failed to copy link');
                }
            }
        });
        
        imageCard.appendChild(shareBtn);
    }

    // Add this function after your existing share button function
    function shareFolder(category) {
        const baseUrl = window.location.origin + window.location.pathname;
        let shareUrl = baseUrl;
        
        // Add category parameter if not 'all'
        if (category !== 'all') {
            shareUrl += `?category=${category}`;
        }
        
        if (navigator.share) {
            navigator.share({
                title: `Photo Album - ${category === 'all' ? 'All Photos' : category}`,
                text: `Check out this photo album${category !== 'all' ? ` of ${category}` : ''}!`,
                url: shareUrl
            }).catch(err => {
                if (err.name !== 'AbortError') {
                    console.error('Share failed:', err);
                }
            });
        } else {
            // Fallback: Copy link to clipboard
            navigator.clipboard.writeText(shareUrl).then(() => {
                // Show success feedback
                shareFolderBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                setTimeout(() => {
                    shareFolderBtn.innerHTML = '<i class="fas fa-share-alt"></i> Share Album';
                }, 2000);
            }).catch(err => {
                console.error('Copy failed:', err);
                alert('Failed to copy link');
            });
        }
    }

    // Add click handler for share folder button
    shareFolderBtn.addEventListener('click', () => {
        const currentCategory = categorySelect.value;
        shareFolder(currentCategory);
    });
}); 
/**
 * Main JavaScript File
 * WPoets Full Stack Test - Slider Synchronization & Interactions
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        sliderDuration: 500,
        animationEasing: 'cubic-bezier(0.645, 0.045, 0.355, 1)',
        transitionDuration: '0.5s'
    };

    // DOM Elements
    const elements = {
        categoryTabs: document.querySelectorAll('.category-tab'),
        mainSlider: document.getElementById('mainSlider'),
        sliderItems: document.querySelectorAll('.slider-item'),
        sliderPrevBtn: document.getElementById('sliderPrev'),
        sliderNextBtn: document.getElementById('sliderNext'),
        sliderCounter: document.getElementById('sliderCounter'),
        dots: document.querySelectorAll('.dot'),
        imageDisplay: document.getElementById('imageDisplay'),
        imageTitle: document.getElementById('imageTitle'),
        imageDescription: document.getElementById('imageDescription')
    };

    // State management
    let state = {
        currentSlideIndex: 0,
        currentCategoryId: null,
        totalSlides: elements.sliderItems.length,
        isAnimating: false
    };

    /**
     * Initialize the application
     */
    function init() {
        console.log('Initializing WPoets Slider Application');
        
        // Set initial category ID from first tab
        if (elements.categoryTabs.length > 0) {
            state.currentCategoryId = elements.categoryTabs[0].dataset.categoryId;
        }

        attachEventListeners();
        updateSlider();
    }

    /**
     * Attach event listeners to interactive elements
     */
    function attachEventListeners() {
        // Category tabs
        elements.categoryTabs.forEach(tab => {
            tab.addEventListener('click', handleCategoryTabClick);
        });

        // Slider navigation buttons
        elements.sliderPrevBtn.addEventListener('click', goToPreviousSlide);
        elements.sliderNextBtn.addEventListener('click', goToNextSlide);

        // Slider dots
        elements.dots.forEach(dot => {
            dot.addEventListener('click', handleDotClick);
        });

        // Keyboard navigation
        document.addEventListener('keydown', handleKeyboardNavigation);

        // Touch support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        elements.mainSlider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, false);

        elements.mainSlider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, false);

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                goToNextSlide();
            }
            if (touchEndX > touchStartX + 50) {
                goToPreviousSlide();
            }
        }
    }

    /**
     * Handle category tab click
     */
    function handleCategoryTabClick(e) {
        const tab = e.currentTarget;
        const categoryId = tab.dataset.categoryId;

        // Update active state
        elements.categoryTabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        // Update state
        state.currentCategoryId = categoryId;
        state.currentSlideIndex = 0;

        // Fetch items for this category
        fetchCategoryItems(categoryId);
    }

    /**
     * Fetch items for a category via AJAX
     */
    function fetchCategoryItems(categoryId) {
        fetch(`api/get_items.php?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateSliderWithItems(data.data);
                } else {
                    console.error('Error fetching items:', data.message);
                    showErrorMessage('Failed to load items');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showErrorMessage('Network error');
            });
    }

    /**
     * Update slider with new items
     */
    function updateSliderWithItems(items) {
        // Clear current slider
        elements.mainSlider.innerHTML = '';

        // Add new items
        items.forEach(item => {
            const sliderItem = document.createElement('div');
            sliderItem.className = 'slider-item';
            sliderItem.dataset.itemId = item.id;
            sliderItem.dataset.imageUrl = item.image_url;
            sliderItem.innerHTML = `
                <div class="slider-content">
                    <h3>${escapeHtml(item.title)}</h3>
                    <p>${escapeHtml(item.description)}</p>
                </div>
            `;
            elements.mainSlider.appendChild(sliderItem);
        });

        // Update dots
        const dotsContainer = document.getElementById('sliderDots');
        dotsContainer.innerHTML = '';
        items.forEach((item, index) => {
            const dot = document.createElement('span');
            dot.className = `dot ${index === 0 ? 'active' : ''}`;
            dot.dataset.slide = index;
            dot.addEventListener('click', handleDotClick);
            dotsContainer.appendChild(dot);
        });

        // Update state
        state.totalSlides = items.length;
        state.currentSlideIndex = 0;

        // Update display
        updateSlider();
    }

    /**
     * Go to previous slide
     */
    function goToPreviousSlide() {
        if (state.isAnimating) return;
        state.currentSlideIndex = (state.currentSlideIndex - 1 + state.totalSlides) % state.totalSlides;
        updateSlider();
    }

    /**
     * Go to next slide
     */
    function goToNextSlide() {
        if (state.isAnimating) return;
        state.currentSlideIndex = (state.currentSlideIndex + 1) % state.totalSlides;
        updateSlider();
    }

    /**
     * Handle dot click
     */
    function handleDotClick(e) {
        const dot = e.currentTarget;
        const slideIndex = parseInt(dot.dataset.slide);
        state.currentSlideIndex = slideIndex;
        updateSlider();
    }

    /**
     * Handle keyboard navigation
     */
    function handleKeyboardNavigation(e) {
        if (e.key === 'ArrowLeft') {
            goToPreviousSlide();
        } else if (e.key === 'ArrowRight') {
            goToNextSlide();
        }
    }

    /**
     * Update slider display
     */
    function updateSlider() {
        state.isAnimating = true;

        // Calculate translation
        const offset = -state.currentSlideIndex * 100;

        // Apply transform to slider
        elements.mainSlider.style.transform = `translateX(${offset}%)`;
        elements.mainSlider.style.transition = `transform ${config.transitionDuration} ${config.animationEasing}`;

        // Update dots
        updateDots();

        // Update counter
        updateCounter();

        // Update image and info
        updateImageDisplay();

        // Reset animation flag
        setTimeout(() => {
            state.isAnimating = false;
        }, config.sliderDuration);
    }

    /**
     * Update dots styling
     */
    function updateDots() {
        const dots = document.querySelectorAll('.dot');
        dots.forEach((dot, index) => {
            if (index === state.currentSlideIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    /**
     * Update slide counter
     */
    function updateCounter() {
        const current = state.currentSlideIndex + 1;
        const total = state.totalSlides;
        elements.sliderCounter.textContent = `${current} / ${total}`;
    }

    /**
     * Update image display with current slide
     */
    function updateImageDisplay() {
        const currentItem = document.querySelectorAll('.slider-item')[state.currentSlideIndex];
        
        if (currentItem) {
            // Get image URL from data or fallback
            const imageUrl = currentItem.dataset.imageUrl || 'https://via.placeholder.com/500x500?text=Image+' + (state.currentSlideIndex + 1);
            const title = currentItem.querySelector('h3')?.textContent || 'No Title';
            const description = currentItem.querySelector('p')?.textContent || 'No Description';

            // Update image with fade effect
            elements.imageDisplay.classList.remove('fade-in');
            setTimeout(() => {
                elements.imageDisplay.innerHTML = `<img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(title)}" class="img-fluid">`;
                elements.imageDisplay.classList.add('fade-in');
            }, 50);

            // Update info
            elements.imageTitle.textContent = title;
            elements.imageDescription.textContent = description;
        }
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Show error message
     */
    function showErrorMessage(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    }

    /**
     * Mobile accordion handling (Bootstrap accordion)
     */
    function initMobileAccordion() {
        const accordionButtons = document.querySelectorAll('[data-toggle="collapse"]');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                const categoryId = this.closest('.card-header').id.replace('heading', '');
                
                // Update active state
                state.currentCategoryId = categoryId;
            });
        });
    }

    /**
     * Setup mobile accordion on small screens
     */
    function setupResponsive() {
        if (window.innerWidth < 992) {
            initMobileAccordion();
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            init();
            setupResponsive();
        });
    } else {
        init();
        setupResponsive();
    }

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            setupResponsive();
        }, 250);
    });

    // Expose some methods globally for debugging
    window.sliderApp = {
        goNext: goToNextSlide,
        goPrev: goToPreviousSlide,
        getState: () => state
    };

    console.log('WPoets Slider Application loaded successfully');
})();

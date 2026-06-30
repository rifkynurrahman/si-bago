/**
 * SI-BAGO - JavaScript Utilities
 * Enhanced interactivity for SI-BAGO website
 */

// ========== DOCUMENT READY ========== 
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initBackToTop();
    initSmoothScroll();
    initAnimateOnScroll();
    initImagePreview();
    initFormValidation();
});

// ========== BACK TO TOP BUTTON ==========
function initBackToTop() {
    // Create back to top button if it doesn't exist
    if (!document.getElementById('backToTop')) {
        const btn = document.createElement('button');
        btn.id = 'backToTop';
        btn.innerHTML = '↑';
        btn.setAttribute('aria-label', 'Back to top');
        document.body.appendChild(btn);
    }

    const backToTopBtn = document.getElementById('backToTop');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    // Scroll to top when clicked
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ========== SMOOTH SCROLL FOR ANCHOR LINKS ==========
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// ========== ANIMATE ON SCROLL ==========
function initAnimateOnScroll() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// ========== IMAGE PREVIEW FOR FILE UPLOADS ==========
function initImagePreview() {
    const fileInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Find or create preview container
                    let previewContainer = input.nextElementSibling;
                    if (!previewContainer || !previewContainer.classList.contains('image-preview')) {
                        previewContainer = document.createElement('div');
                        previewContainer.className = 'image-preview mt-3';
                        input.parentNode.insertBefore(previewContainer, input.nextSibling);
                    }
                    
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview" 
                             style="max-width: 200px; max-height: 200px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <p class="text-muted small mt-2">Preview gambar</p>
                    `;
                };
                
                reader.readAsDataURL(file);
            }
        });
    });
}

// ========== FORM VALIDATION ==========
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

// ========== GALLERY LIGHTBOX ==========
function initGallery() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const imgSrc = this.querySelector('img').src;
            const imgAlt = this.querySelector('img').alt;
            
            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <span class="lightbox-close">&times;</span>
                    <img src="${imgSrc}" alt="${imgAlt}">
                    <p class="lightbox-caption">${imgAlt}</p>
                </div>
            `;
            
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            // Close lightbox
            lightbox.querySelector('.lightbox-close').addEventListener('click', function() {
                document.body.removeChild(lightbox);
                document.body.style.overflow = '';
            });
            
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    document.body.removeChild(lightbox);
                    document.body.style.overflow = '';
                }
            });
        });
    });
}

// ========== SEARCH FUNCTIONALITY ==========
function initSearch(searchInputId, targetClass) {
    const searchInput = document.getElementById(searchInputId);
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll(targetClass);
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// ========== LOADING INDICATOR ==========
function showLoading(targetElement) {
    const loader = document.createElement('div');
    loader.className = 'loading-spinner';
    loader.style.cssText = `
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 107, 53, 0.3);
        border-top-color: #FF6B35;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    `;
    
    if (targetElement) {
        targetElement.appendChild(loader);
    }
    return loader;
}

function hideLoading(loader) {
    if (loader && loader.parentNode) {
        loader.parentNode.removeChild(loader);
    }
}

// ========== TOAST NOTIFICATION ==========
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
    `;
    
    // Color based on type
    const colors = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };
    
    toast.style.borderLeft = `5px solid ${colors[type] || colors.info}`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// ========== CONFIRM DELETE ==========
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus?') {
    return confirm(message);
}

// ========== EXPORT FUNCTIONS FOR GLOBAL USE ==========
window.SIBago = {
    showLoading,
    hideLoading,
    showToast,
    confirmDelete,
    initGallery,
    initSearch
};

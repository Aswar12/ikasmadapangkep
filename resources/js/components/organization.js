/**
 * Organization Component JavaScript Enhancements
 * File: resources/js/components/organization.js
 * 
 * This file provides additional functionality for the organization component
 * including search, filtering, animations, and accessibility features.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize organization component enhancements
    initOrganizationEnhancements();
});

function initOrganizationEnhancements() {
    // Add keyboard navigation
    addKeyboardNavigation();
    
    // Add search functionality enhancements
    enhanceSearchFunctionality();
    
    // Add smooth scrolling for navigation
    addSmoothScrolling();
    
    // Add print functionality
    addPrintFunctionality();
    
    // Add export functionality
    addExportFunctionality();
    
    // Add accessibility features
    addAccessibilityFeatures();
    
    // Add performance optimizations
    addPerformanceOptimizations();
}

/**
 * Keyboard navigation for better accessibility
 */
function addKeyboardNavigation() {
    const filterButtons = document.querySelectorAll('[x-data] button[\\@click*="activeFilter"]');
    const searchInput = document.querySelector('input[x-model="searchQuery"]');
    const departmentButtons = document.querySelectorAll('[x-data] button[\\@click*="openDept"]');

    // Arrow key navigation for filter buttons
    filterButtons.forEach((button, index) => {
        button.addEventListener('keydown', function(e) {
            let targetIndex;
            
            switch(e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    targetIndex = (index + 1) % filterButtons.length;
                    e.preventDefault();
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    targetIndex = index === 0 ? filterButtons.length - 1 : index - 1;
                    e.preventDefault();
                    break;
                case 'Home':
                    targetIndex = 0;
                    e.preventDefault();
                    break;
                case 'End':
                    targetIndex = filterButtons.length - 1;
                    e.preventDefault();
                    break;
            }
            
            if (targetIndex !== undefined) {
                filterButtons[targetIndex].focus();
            }
        });
    });

    // Quick search activation with Ctrl+F
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f' && searchInput) {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
    });

    // Escape key to clear search or close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
            
            // Close open department sections
            departmentButtons.forEach(button => {
                const alpineComponent = button.closest('[x-data]');
                if (alpineComponent && alpineComponent._x_dataStack) {
                    const data = alpineComponent._x_dataStack[0];
                    if (data.openDept) {
                        data.openDept = false;
                    }
                }
            });
        }
    });
}

/**
 * Enhanced search functionality with debouncing and highlights
 */
function enhanceSearchFunctionality() {
    const searchInput = document.querySelector('input[x-model="searchQuery"]');
    if (!searchInput) return;

    let searchTimeout;
    
    // Add search suggestions
    const suggestionsContainer = createSearchSuggestions();
    searchInput.parentNode.appendChild(suggestionsContainer);
    
    // Debounced search
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(e.target.value);
            updateSearchSuggestions(e.target.value);
        }, 300);
    });
    
    // Search history
    const searchHistory = getSearchHistory();
    
    searchInput.addEventListener('focus', function() {
        if (searchHistory.length > 0) {
            showSearchHistory(searchHistory);
        }
    });
    
    searchInput.addEventListener('blur', function() {
        setTimeout(() => {
            hideSuggestions();
        }, 200);
    });
}

function createSearchSuggestions() {
    const container = document.createElement('div');
    container.className = 'absolute top-full left-0 right-0 bg-white rounded-lg shadow-lg border border-slate-200 mt-2 z-50 hidden';
    container.id = 'search-suggestions';
    return container;
}

function updateSearchSuggestions(query) {
    const container = document.getElementById('search-suggestions');
    if (!container || !query.trim()) {
        hideSuggestions();
        return;
    }
    
    const suggestions = generateSearchSuggestions(query);
    
    if (suggestions.length === 0) {
        hideSuggestions();
        return;
    }
    
    container.innerHTML = suggestions.map(suggestion => 
        `<div class="px-4 py-2 hover:bg-slate-100 cursor-pointer border-b border-slate-100 last:border-b-0" data-suggestion="${suggestion}">
            ${highlightMatch(suggestion, query)}
        </div>`
    ).join('');
    
    container.classList.remove('hidden');
    
    // Add click handlers for suggestions
    container.querySelectorAll('[data-suggestion]').forEach(item => {
        item.addEventListener('click', function() {
            const searchInput = document.querySelector('input[x-model="searchQuery"]');
            searchInput.value = this.dataset.suggestion;
            searchInput.dispatchEvent(new Event('input'));
            hideSuggestions();
            saveSearchHistory(this.dataset.suggestion);
        });
    });
}

function generateSearchSuggestions(query) {
    // This would typically come from your data
    const allNames = [
        'MUHAMMAD NASIR RUKI', 'LUKMAN. AR', 'IMRAN', 'SAENAL ABIDIN',
        'USMAN MAROLA', 'NUR ASMAUL HUSNAH', 'SANTA', 'HJ. NURDIANA',
        'MUAMAR QADAR', 'ALFIAN ARI DWI SAPUTRA', 'MUHAMMAD TAQWIM RAMLI',
        'MUSLIMIN', 'IBRAHIM'
    ];
    
    const positions = [
        'Ketua Umum', 'Ketua Harian', 'Wakil Ketua', 'Sekretaris', 'Bendahara',
        'Koordinator', 'Departemen'
    ];
    
    const allTerms = [...allNames, ...positions];
    
    return allTerms
        .filter(term => term.toLowerCase().includes(query.toLowerCase()))
        .slice(0, 5);
}

function highlightMatch(text, query) {
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<mark class="bg-yellow-200">$1</mark>');
}

function hideSuggestions() {
    const container = document.getElementById('search-suggestions');
    if (container) {
        container.classList.add('hidden');
    }
}

function performSearch(query) {
    // Advanced search functionality
    if (!query.trim()) return;
    
    // Save search to history
    saveSearchHistory(query);
    
    // Analytics tracking (if implemented)
    trackSearchEvent(query);
}

function getSearchHistory() {
    try {
        return JSON.parse(localStorage.getItem('org_search_history') || '[]');
    } catch {
        return [];
    }
}

function saveSearchHistory(query) {
    try {
        const history = getSearchHistory();
        const filtered = history.filter(item => item !== query);
        filtered.unshift(query);
        const limited = filtered.slice(0, 10); // Keep only last 10 searches
        localStorage.setItem('org_search_history', JSON.stringify(limited));
    } catch {
        // Ignore storage errors
    }
}

function showSearchHistory(history) {
    const container = document.getElementById('search-suggestions');
    if (!container) return;
    
    container.innerHTML = `
        <div class="px-4 py-2 text-sm text-slate-500 font-semibold border-b border-slate-200">
            Pencarian Terakhir
        </div>
        ${history.slice(0, 5).map(item => 
            `<div class="px-4 py-2 hover:bg-slate-100 cursor-pointer flex items-center border-b border-slate-100 last:border-b-0" data-suggestion="${item}">
                <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                ${item}
            </div>`
        ).join('')}
    `;
    
    container.classList.remove('hidden');
}

/**
 * Smooth scrolling for better UX
 */
function addSmoothScrolling() {
    // Smooth scroll to sections when filter changes
    const filterButtons = document.querySelectorAll('[x-data] button[\\@click*="activeFilter"]');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                const targetElement = document.querySelector('#organization');
                if (targetElement) {
                    targetElement.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
        });
    });
}

/**
 * Print functionality
 */
function addPrintFunctionality() {
    // Add print button
    const printButton = createPrintButton();
    const headerSection = document.querySelector('#organization .text-center');
    if (headerSection) {
        headerSection.appendChild(printButton);
    }
}

function createPrintButton() {
    const button = document.createElement('button');
    button.className = 'org-no-print inline-flex items-center px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors duration-300 mt-4';
    button.innerHTML = `
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Cetak Struktur Organisasi
    `;
    
    button.addEventListener('click', function() {
        // Hide filters and search before printing
        const filtersAndSearch = document.querySelectorAll('.org-no-print');
        filtersAndSearch.forEach(el => el.style.display = 'none');
        
        // Show all content for printing
        const hiddenElements = document.querySelectorAll('[x-show]:not([x-show*="true"])');
        hiddenElements.forEach(el => {
            el.style.display = 'block';
            el.setAttribute('data-was-hidden', 'true');
        });
        
        window.print();
        
        // Restore after printing
        setTimeout(() => {
            filtersAndSearch.forEach(el => el.style.display = '');
            hiddenElements.forEach(el => {
                if (el.hasAttribute('data-was-hidden')) {
                    el.style.display = 'none';
                    el.removeAttribute('data-was-hidden');
                }
            });
        }, 1000);
    });
    
    return button;
}

/**
 * Export functionality
 */
function addExportFunctionality() {
    const exportButton = createExportButton();
    const headerSection = document.querySelector('#organization .text-center');
    if (headerSection) {
        headerSection.appendChild(exportButton);
    }
}

function createExportButton() {
    const button = document.createElement('button');
    button.className = 'org-no-print inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300 mt-4 ml-4';
    button.innerHTML = `
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export ke PDF
    `;
    
    button.addEventListener('click', function() {
        exportToPDF();
    });
    
    return button;
}

function exportToPDF() {
    // This would require a PDF library like jsPDF or html2pdf
    alert('Fitur export PDF akan segera tersedia!');
}

/**
 * Accessibility features
 */
function addAccessibilityFeatures() {
    // Add aria-labels and descriptions
    const filterButtons = document.querySelectorAll('[x-data] button[\\@click*="activeFilter"]');
    filterButtons.forEach((button, index) => {
        button.setAttribute('aria-describedby', `filter-description-${index}`);
        button.setAttribute('role', 'tab');
    });
    
    // Add screen reader announcements
    const searchInput = document.querySelector('input[x-model="searchQuery"]');
    if (searchInput) {
        searchInput.setAttribute('aria-describedby', 'search-description');
        
        // Add hidden description
        const description = document.createElement('div');
        description.id = 'search-description';
        description.className = 'org-screen-reader-only';
        description.textContent = 'Ketik untuk mencari berdasarkan nama atau jabatan. Gunakan tombol panah untuk navigasi.';
        searchInput.parentNode.appendChild(description);
    }
    
    // Add focus indicators
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });
    
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });
}

/**
 * Performance optimizations
 */
function addPerformanceOptimizations() {
    // Lazy load images if any
    const images = document.querySelectorAll('img[data-src]');
    if (images.length > 0 && 'IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    // Debounce scroll events
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            // Add scroll-based animations or updates here
        }, 10);
    });
}

/**
 * Analytics tracking (optional)
 */
function trackSearchEvent(query) {
    // Integration with analytics service
    if (typeof gtag !== 'undefined') {
        gtag('event', 'search', {
            search_term: query,
            page_title: 'Struktur Organisasi'
        });
    }
}

/**
 * Utility functions
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Export functions for external use
window.OrganizationEnhancements = {
    init: initOrganizationEnhancements,
    search: performSearch,
    export: exportToPDF,
    print: () => window.print()
};
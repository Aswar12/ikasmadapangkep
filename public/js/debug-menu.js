// Debug Script untuk Menu Admin
// Paste script ini di console browser untuk debug masalah menu

function debugMenuIssues() {
    console.log('=== DEBUGGING MENU ISSUES ===');
    
    // 1. Cek semua link di sidebar
    const sidebarLinks = document.querySelectorAll('aside a');
    console.log(`Total sidebar links: ${sidebarLinks.length}`);
    
    sidebarLinks.forEach((link, index) => {
        const styles = window.getComputedStyle(link);
        const rect = link.getBoundingClientRect();
        
        console.log(`\nLink ${index + 1}: ${link.textContent.trim()}`);
        console.log('- href:', link.href);
        console.log('- pointer-events:', styles.pointerEvents);
        console.log('- z-index:', styles.zIndex);
        console.log('- position:', styles.position);
        console.log('- display:', styles.display);
        console.log('- visibility:', styles.visibility);
        console.log('- opacity:', styles.opacity);
        console.log('- clickable area:', rect.width, 'x', rect.height);
        
        // Cek apakah ada element yang menutupi
        const elementAtPoint = document.elementFromPoint(
            rect.left + rect.width / 2,
            rect.top + rect.height / 2
        );
        
        if (elementAtPoint !== link && !link.contains(elementAtPoint)) {
            console.warn('⚠️ Element is covered by:', elementAtPoint);
        }
    });
    
    // 2. Cek z-index hierarchy
    console.log('\n=== Z-INDEX HIERARCHY ===');
    const elements = [
        { name: 'Sidebar', selector: 'aside' },
        { name: 'Main Content', selector: '.md\\:ml-64' },
        { name: 'Overlay', selector: '#sidebarOverlay' },
        { name: 'Nav', selector: 'nav' }
    ];
    
    elements.forEach(({ name, selector }) => {
        const el = document.querySelector(selector);
        if (el) {
            const zIndex = window.getComputedStyle(el).zIndex;
            console.log(`${name}: z-index = ${zIndex || 'auto'}`);
        }
    });
    
    // 3. Fix attempt
    console.log('\n=== ATTEMPTING FIX ===');
    fixMenuLinks();
}

function fixMenuLinks() {
    const links = document.querySelectorAll('aside a');
    
    links.forEach(link => {
        // Remove all event listeners by cloning
        const newLink = link.cloneNode(true);
        link.parentNode.replaceChild(newLink, link);
        
        // Ensure proper styles
        newLink.style.cursor = 'pointer';
        newLink.style.pointerEvents = 'auto';
        newLink.style.position = 'relative';
        newLink.style.zIndex = '999';
        
        // Add click handler for debugging
        newLink.addEventListener('click', function(e) {
            console.log('Clicked:', this.href);
            // Don't prevent default - let navigation work
        });
    });
    
    console.log('✅ Fix applied to all menu links');
}

// Quick fix - copy paste ini di console untuk fix cepat
function quickFix() {
    document.querySelectorAll('aside a').forEach(link => {
        link.style.cssText = 'cursor: pointer !important; pointer-events: auto !important; z-index: 999 !important;';
        const newLink = link.cloneNode(true);
        link.parentNode.replaceChild(newLink, link);
    });
    console.log('✅ Menu links fixed!');
}

// Auto-run
debugMenuIssues();
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    const isOpen = mobileMenu.style.maxHeight !== '0px' && mobileMenu.style.maxHeight !== '';

    if (isOpen) {
        mobileMenu.style.maxHeight = '0';
    } else {
        mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
    }
}

// Close mobile menu when clicking on a link
document.querySelectorAll('#mobileMenu a').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('mobileMenu').style.maxHeight = '0';
    });
});


// Close mobile menu when window is resized to desktop
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        document.getElementById('mobileMenu').style.maxHeight = '0';
    }
});
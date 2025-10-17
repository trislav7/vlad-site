// Layout module JavaScript
console.log('Layout module loaded');

document.addEventListener('DOMContentLoaded', function() {
    // Обработчики для layout кнопок
    const primaryButtons = document.querySelectorAll('.btn-primary');
    primaryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Primary button clicked');
            alert('Primary button from layout module!');
        });
    });
    
    const secondaryButtons = document.querySelectorAll('.btn-secondary');
    secondaryButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Secondary button clicked');
            alert('Secondary button from layout module!');
        });
    });
    
    // Mobile menu toggle (если будет нужно)
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    console.log('Layout JavaScript initialized');
});
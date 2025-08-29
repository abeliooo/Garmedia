function initializeCarousel() {
    const carousel = document.querySelector('.carousel');
    if (!carousel) return;

    const prevArrow = document.querySelector('.prev-arrow');
    const nextArrow = document.querySelector('.next-arrow');
    const cardWrapper = carousel.querySelector('.book-card-wrapper');

    if (!prevArrow || !nextArrow || !cardWrapper) {
        console.error('Carousel arrows or card wrapper not found!');
        return;
    }
    
    const updateArrows = () => {
        const buffer = 2; 
        const scrollLeft = Math.round(carousel.scrollLeft);
        const maxScrollLeft = carousel.scrollWidth - carousel.clientWidth;
        
        prevArrow.style.display = scrollLeft > buffer ? 'flex' : 'none';
        nextArrow.style.display = scrollLeft < maxScrollLeft - buffer ? 'flex' : 'none';
    };

    nextArrow.addEventListener('click', () => {
        const cardWidth = cardWrapper.offsetWidth;
        carousel.scrollBy({ left: cardWidth * 5, behavior: 'smooth' });
    });

    prevArrow.addEventListener('click', () => {
        const cardWidth = cardWrapper.offsetWidth;
        carousel.scrollBy({ left: -cardWidth * 5, behavior: 'smooth' });
    });

    carousel.addEventListener('scrollend', updateArrows);
    window.addEventListener('resize', updateArrows);

    updateArrows();
}

document.addEventListener('DOMContentLoaded', initializeCarousel);

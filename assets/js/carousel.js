/**
 * Dalen Prize Carousel JavaScript
 * Simple navigation between cards using scrollIntoView
 */

class DalenPrizeCarousel {
  constructor(container) {
    this.container = container;
    this.wrapper = container.querySelector('.dpc-carousel-wrapper');
    this.track = container.querySelector('.dpc-carousel-track');
    this.cards = container.querySelectorAll('.dpc-prize-card');
    this.prevButton = container.querySelector('.dpc-carousel-nav__btn--prev');
    this.nextButton = container.querySelector('.dpc-carousel-nav__btn--next');

    this.currentIndex = 0;
    this.totalCards = this.cards.length;

    // Initialize if we have cards and navigation buttons
    if (this.totalCards > 0 && this.prevButton && this.nextButton) {
      this.init();
    }
  }

  init() {
    // Bind event listeners
    this.prevButton.addEventListener('click', () => this.goToPrevious());
    this.nextButton.addEventListener('click', () => this.goToNext());

    // Handle keyboard navigation
    this.container.addEventListener('keydown', (e) => this.handleKeydown(e));
  }

  goToNext() {
    if (this.currentIndex < this.totalCards - 1) {
      this.currentIndex++;
      this.scrollToCard(this.currentIndex);
    }
  }

  goToPrevious() {
    if (this.currentIndex > 0) {
      this.currentIndex--;
      this.scrollToCard(this.currentIndex);
    }
  }

  scrollToCard(index) {
    if (index >= 0 && index < this.totalCards) {
      const targetCard = this.cards[index];

      targetCard.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
        inline: 'start',
      });
    }
  }

  handleKeydown(event) {
    // Allow keyboard navigation with arrow keys
    switch (event.key) {
      case 'ArrowLeft':
        event.preventDefault();
        this.goToPrevious();
        break;
      case 'ArrowRight':
        event.preventDefault();
        this.goToNext();
        break;
    }
  }

  // Public methods for external control
  goToCard(index) {
    if (index >= 0 && index < this.totalCards) {
      this.currentIndex = index;
      this.scrollToCard(index);
    }
  }

  getCurrentIndex() {
    return this.currentIndex;
  }
}

// Initialize all carousels when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
  const carousels = document.querySelectorAll('.dpc-carousel-container');

  carousels.forEach((container) => {
    new DalenPrizeCarousel(container);
  });
});

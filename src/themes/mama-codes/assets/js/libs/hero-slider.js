(function($) {
  //remove no-js class
  removeClass(document.getElementsByTagName('html')[0], 'no-js');

  //Hero Slider - by CodyHouse.co
  function HeroSlider(element) {
    this.element = element;
    this.navigation = this.element.getElementsByClassName('js-cd-nav')[0];
    this.navigationItems = this.navigation.getElementsByTagName('li');
    this.marker = this.navigation.getElementsByClassName('js-cd-marker')[0];
    this.slides = this.element.getElementsByClassName('js-cd-slide');
    this.slidesNumber = this.slides.length;
    this.newSlideIndex = 0;
    this.oldSlideIndex = 0;
    this.autoplay = hasClass(this.element, 'js-cd-autoplay');
    this.autoPlayId;
    this.autoPlayDelay = 5000;
    this.init();
  }

  HeroSlider.prototype.init = function() {
    var self = this;

    //autoplay slider
    this.setAutoplay();

    // Listen for the click event on the slider navigation
    $('.mc-slider-nav--next').on('click', e => {
      e.preventDefault();
      self.paginateNextSlide();
    });

    $('.mc-slider-nav--prev').on('click', e => {
      e.preventDefault();
      self.paginatePrevSlide();
    });

    // Pause on hover.
    if (this.autoplay) {
      $('.mc-slider-nav--next, .mc-slider-nav--prev').on('mouseenter', () => {
        clearInterval(self.autoPlayId);
      });

      $('.mc-slider-nav--next, .mc-slider-nav--prev').on('mouseleave', () => {
        self.setAutoplay();
      });

      // on hover - pause autoplay
      this.element.addEventListener('mouseenter', function() {
        clearInterval(self.autoPlayId);
      });

      this.element.addEventListener('mouseleave', function() {
        self.setAutoplay();
      });
    }
  };

  HeroSlider.prototype.setAutoplay = function() {
    var self = this;
    if (this.autoplay) {
      clearInterval(self.autoPlayId);
      self.autoPlayId = window.setInterval(function() {
        self.autoplaySlider();
      }, self.autoPlayDelay);
    }
  };

  HeroSlider.prototype.paginatePrevSlide = function() {
    this.oldSlideIndex = this.newSlideIndex;
    var self = this;

    // if
    if (this.newSlideIndex <= 0) {
      this.newSlideIndex = this.slidesNumber - 1;
      this.newSlide();
    } else {
      this.newSlideIndex -= 1;
      this.newSlide();
    }
  };

  HeroSlider.prototype.paginateNextSlide = function() {
    this.oldSlideIndex = this.newSlideIndex;
    var self = this;
    if (this.newSlideIndex < this.slidesNumber - 1) {
      this.newSlideIndex += 1;
      this.newSlide();
    } else {
      this.newSlideIndex = 0;
      this.newSlide();
    }
  };

  HeroSlider.prototype.autoplaySlider = function() {
    this.oldSlideIndex = this.newSlideIndex;
    var self = this;
    if (this.newSlideIndex < this.slidesNumber - 1) {
      this.newSlideIndex += 1;
      this.newSlide();
    } else {
      this.newSlideIndex = 0;
      this.newSlide();
    }
  };

  HeroSlider.prototype.newSlide = function(direction) {
    var self = this;
    removeClass(
      this.slides[this.oldSlideIndex],
      'cd-hero__slide--selected cd-hero__slide--from-left cd-hero__slide--from-right'
    );
    addClass(this.slides[this.oldSlideIndex], 'cd-hero__slide--is-moving');
    setTimeout(function() {
      removeClass(self.slides[self.oldSlideIndex], 'cd-hero__slide--is-moving');
    }, 500);

    for (var i = 0; i < this.slidesNumber; i++) {
      if (i < this.newSlideIndex && this.oldSlideIndex < this.newSlideIndex) {
        addClass(this.slides[i], 'cd-hero__slide--move-left');
      } else if (
        i == this.newSlideIndex &&
        this.oldSlideIndex < this.newSlideIndex
      ) {
        addClass(
          this.slides[i],
          'cd-hero__slide--selected cd-hero__slide--from-right'
        );
      } else if (
        i == this.newSlideIndex &&
        this.oldSlideIndex > this.newSlideIndex
      ) {
        addClass(
          this.slides[i],
          'cd-hero__slide--selected cd-hero__slide--from-left'
        );
        removeClass(this.slides[i], 'cd-hero__slide--move-left');
      } else if (
        i > this.newSlideIndex &&
        this.oldSlideIndex > this.newSlideIndex
      ) {
        removeClass(this.slides[i], 'cd-hero__slide--move-left');
      }
    }

    this.checkVideo();
  };

  HeroSlider.prototype.checkVideo = function() {
    //check if a video outside the viewport is playing - if yes, pause it
    var hiddenVideo = this.slides[this.oldSlideIndex].getElementsByTagName(
      'video'
    );
    if (hiddenVideo.length) hiddenVideo[0].pause();

    //check if the select slide contains a video element - if yes, play the video
    var visibleVideo = this.slides[this.newSlideIndex].getElementsByTagName(
      'video'
    );
    if (visibleVideo.length) visibleVideo[0].play();
  };

  var heroSliders = document.getElementsByClassName('js-cd-hero');
  if (heroSliders.length > 0) {
    for (var i = 0; i < heroSliders.length; i++) {
      (function(i) {
        new HeroSlider(heroSliders[i]);
      })(i);
    }
  }

  function removeClassPrefix(el, prefix) {
    //remove all classes starting with 'prefix'
    var classes = el.className.split(' ').filter(function(c) {
      return c.indexOf(prefix) < 0;
    });
    el.className = classes.join(' ');
  }

  //class manipulations - needed if classList is not supported
  function hasClass(el, className) {
    if (el.classList) return el.classList.contains(className);
    else
      return !!el.className.match(
        new RegExp('(\\s|^)' + className + '(\\s|$)')
      );
  }

  function addClass(el, className) {
    var classList = className.split(' ');
    if (el.classList) el.classList.add(classList[0]);
    else if (!hasClass(el, classList[0])) el.className += ' ' + classList[0];
    if (classList.length > 1) addClass(el, classList.slice(1).join(' '));
  }

  function removeClass(el, className) {
    var classList = className.split(' ');
    if (el.classList) el.classList.remove(classList[0]);
    else if (hasClass(el, classList[0])) {
      var reg = new RegExp('(\\s|^)' + classList[0] + '(\\s|$)');
      el.className = el.className.replace(reg, ' ');
    }
    if (classList.length > 1) removeClass(el, classList.slice(1).join(' '));
  }
})(jQuery);

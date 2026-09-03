"use strict";

jQuery(document).ready(function ($) {
  /* ---------- Mobile menu ---------- */
  $(document).on('click', '.menu-toggle', function () {
    var open = $('body').toggleClass('open-mobile-menu').hasClass('open-mobile-menu');
    $(this).attr('aria-expanded', open ? 'true' : 'false');
  });

  /* ---------- Homepage hero: scroll-scrubbed rolodex + headline exit ----------
     Lenis drives smooth scroll; GSAP ScrollTrigger pins the hero under the
     fixed nav, scrubs the video and animates the headline. */
  var hero = document.getElementById('hero');
  var video = document.getElementById('heroVideo');
  if (hero && video && window.gsap && window.ScrollTrigger && window.Lenis) {
    var showFrame = function showFrame(t) {
      if (video.readyState < 1) {
        return;
      }
      if (video.seeking) {
        pending = t;
        return;
      }
      if (Math.abs(t - lastShown) < 0.01) {
        return;
      }
      lastShown = t;
      video.currentTime = t;
    };
    gsap.registerPlugin(ScrollTrigger);
    var lenis = new Lenis({
      lerp: 0.1,
      smoothWheel: true
    });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add(function (t) {
      lenis.raf(t * 1000);
    });
    gsap.ticker.lagSmoothing(0);
    video.pause();
    var lastShown = -1,
      pending = null;
    video.addEventListener('seeked', function () {
      if (pending !== null) {
        var t = pending;
        pending = null;
        showFrame(t);
      }
    });
    var navH = $('.site-header').outerHeight() || 88;
    var tl = gsap.timeline({
      scrollTrigger: {
        trigger: '#hero',
        start: 'top ' + navH + 'px',
        end: '+=1000',
        pin: true,
        pinSpacing: true,
        scrub: 0.5,
        anticipatePin: 1,
        onUpdate: function onUpdate(self) {
          showFrame(self.progress * (video.duration || 5));
        }
      }
    });
    tl.to('.hero-l1', {
      xPercent: -320,
      ease: 'power2.in',
      duration: 0.75
    }, 0).to('.hero-l2', {
      xPercent: 320,
      ease: 'power2.in',
      duration: 0.75
    }, 0).to('.hero__eyebrow', {
      opacity: 0,
      ease: 'none',
      duration: 0.3
    }, 0).to('.hero-simple', {
      scale: 1.65,
      y: -150,
      transformOrigin: 'left center',
      ease: 'power1.inOut',
      duration: 1
    }, 0);
    $(window).on('load', function () {
      ScrollTrigger.refresh();
    });
  }
});
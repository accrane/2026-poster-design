jQuery(document).ready(function ($) {

	/* ---------- Mobile menu ---------- */
	$(document).on('click', '.menu-toggle', function () {
		var open = $('body').toggleClass('open-mobile-menu').hasClass('open-mobile-menu');
		$(this).attr('aria-expanded', open ? 'true' : 'false');
	});


	/* ---------- Forms: peeking eyes ----------
	   A little rubber-hose face hides behind every text field and pops up
	   to watch when the field gets focus (CSS handles the motion via
	   :focus-within; this only adds the markup). */
	var eyesSVG = '<svg viewBox="0 0 84 44" aria-hidden="true">' +
		'<path d="M4 44 C4 18 20 6 42 6 C64 6 80 18 80 44 Z" fill="#efdec4" stroke="#2b0b0a" stroke-width="3" stroke-linejoin="round"></path>' +
		'<ellipse cx="29" cy="27" rx="11" ry="13" fill="#fff" stroke="#2b0b0a" stroke-width="3"></ellipse>' +
		'<ellipse cx="55" cy="27" rx="11" ry="13" fill="#fff" stroke="#2b0b0a" stroke-width="3"></ellipse>' +
		'<g class="field-eyes__pupils">' +
		'<path d="M29 25 m-5.5 0 a5.5 5.5 0 1 1 5.5 5.5 L29 25 Z" fill="#2b0b0a"></path>' +
		'<path d="M55 25 m-5.5 0 a5.5 5.5 0 1 1 5.5 5.5 L55 25 Z" fill="#2b0b0a"></path>' +
		'</g>' +
		'<g class="field-eyes__lids"><ellipse cx="29" cy="27" rx="11.5" ry="13.5" fill="#efdec4"></ellipse><ellipse cx="55" cy="27" rx="11.5" ry="13.5" fill="#efdec4"></ellipse></g>' +
		'<path d="M16 12 q6 -6 12 -2" fill="none" stroke="#2b0b0a" stroke-width="3" stroke-linecap="round"></path>' +
		'<path d="M56 10 q6 -4 12 2" fill="none" stroke="#2b0b0a" stroke-width="3" stroke-linecap="round"></path>' +
		'</svg>';
	$('.gform_wrapper .ginput_container').find('input[type="text"], input[type="email"], input[type="tel"], input[type="url"], input[type="number"], textarea').each(function () {
		var $parent = $(this).parent();
		if ($parent.find('.field-eyes').length) { return; }
		$parent.addClass('has-field-eyes').prepend('<span class="field-eyes">' + eyesSVG + '</span>');
	});
	// class toggle alongside :focus-within, so the eyes also work where that selector doesn't fire
	$(document).on('focusin', '.has-field-eyes', function () { $(this).addClass('is-watching'); })
		.on('focusout', '.has-field-eyes', function () { $(this).removeClass('is-watching'); });

	/* ---------- Homepage hero: scroll-scrubbed rolodex + headline exit ----------
	   Lenis drives smooth scroll; GSAP ScrollTrigger pins the hero under the
	   fixed nav, scrubs the video and animates the headline. */
	var hero = document.getElementById('hero');
	var video = document.getElementById('heroVideo');
	if (hero && video && window.gsap && window.ScrollTrigger && window.Lenis) {
		gsap.registerPlugin(ScrollTrigger);

		var lenis = new Lenis({ lerp: 0.1, smoothWheel: true });
		lenis.on('scroll', ScrollTrigger.update);
		gsap.ticker.add(function (t) { lenis.raf(t * 1000); });
		gsap.ticker.lagSmoothing(0);

		video.pause();
		var lastShown = -1, pending = null;
		function showFrame(t) {
			if (video.readyState < 1) { return; }
			if (video.seeking) { pending = t; return; }
			if (Math.abs(t - lastShown) < 0.01) { return; }
			lastShown = t;
			video.currentTime = t;
		}
		video.addEventListener('seeked', function () {
			if (pending !== null) { var t = pending; pending = null; showFrame(t); }
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
				onUpdate: function (self) { showFrame(self.progress * (video.duration || 5)); }
			}
		});
		tl.to('.hero-l1', { xPercent: -320, ease: 'power2.in', duration: 0.75 }, 0)
			.to('.hero-l2', { xPercent: 320, ease: 'power2.in', duration: 0.75 }, 0)
			.to('.hero__eyebrow', { opacity: 0, ease: 'none', duration: 0.3 }, 0)
			.to('.hero-simple', { scale: 1.65, y: -150, transformOrigin: 'left center', ease: 'power1.inOut', duration: 1 }, 0);

		$(window).on('load', function () { ScrollTrigger.refresh(); });
	}

	/* ---------- Stroke icons draw themselves when scrolled into view ----------
	   Every shape gets a dash the length of its own outline, offset fully so
	   nothing shows; entering the viewport eases the offset to 0, staggered
	   per icon and per shape. Skipped for reduced-motion users. */
	(function () {
		var icons = document.querySelectorAll('.icon-strip svg, .service-list__item > svg');
		if (!icons.length || !('IntersectionObserver' in window)) { return; }
		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }
		var shapesOf = function (svg) { return svg.querySelectorAll('path, rect, circle, line, polyline, polygon'); };
		icons.forEach(function (svg, i) {
			shapesOf(svg).forEach(function (el, j) {
				var len;
				try { len = el.getTotalLength(); } catch (e) { return; }
				if (!len) { return; }
				el.style.strokeDasharray = len + ' ' + len;
				el.style.strokeDashoffset = len;
				el.style.transition = 'stroke-dashoffset 900ms ease ' + (i * 140 + j * 160) + 'ms';
			});
		});
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) { return; }
				shapesOf(entry.target).forEach(function (el) { el.style.strokeDashoffset = 0; });
				entry.target.classList.add('is-drawn');
				io.unobserve(entry.target);
			});
		}, { threshold: 0.4 });
		icons.forEach(function (svg) { io.observe(svg); });
	})();
});

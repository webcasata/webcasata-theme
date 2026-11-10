/**
 * Webcasata theme front-end script.
 * Vanilla JS, deferred. Progressive enhancement only.
 */
( function () {
	'use strict';

	function onReady( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
		} else {
			document.addEventListener( 'DOMContentLoaded', fn );
		}
	}

	function initMobileMenu() {
		var toggle = document.querySelector( '.menu-toggle' );
		var nav = document.getElementById( 'site-navigation' );

		if ( ! toggle || ! nav ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
			nav.classList.toggle( 'is-open', ! expanded );
			document.body.classList.toggle( 'menu-open', ! expanded );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && nav.classList.contains( 'is-open' ) ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				nav.classList.remove( 'is-open' );
				document.body.classList.remove( 'menu-open' );
				toggle.focus();
			}
		} );
	}

	function initScrollToTop() {
		var button = document.getElementById( 'webcasata-scroll-top' );

		if ( ! button ) {
			return;
		}

		var threshold = 400;

		function toggleButton() {
			if ( window.scrollY > threshold ) {
				button.removeAttribute( 'hidden' );
				button.classList.add( 'is-visible' );
			} else {
				button.setAttribute( 'hidden', '' );
				button.classList.remove( 'is-visible' );
			}
		}

		button.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );

		window.addEventListener( 'scroll', toggleButton, { passive: true } );
		toggleButton();
	}

	onReady( function () {
		initMobileMenu();
		initScrollToTop();
	} );
} )();

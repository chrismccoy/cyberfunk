/**
 * archive.js — scripts loaded on archive and index pages
 *
 * reveal (scroll-reveal animations), keyboard-shortcuts, reading-time-filter.
 *
 * @package Cyberfunk
 */

( function () {
	'use strict';

	( function () {
		var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function revealAll( items ) {
			items.forEach( function ( el ) {
				el.classList.add( 'js-reveal', 'revealed' );
			} );
		}

		function init() {
			var items = document.querySelectorAll( '.post-wrap' );
			if ( 0 === items.length ) { return; }

			if ( reducedMotion || ! ( 'IntersectionObserver' in window ) ) {
				revealAll( items );
				return;
			}

			var observer = new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							entry.target.classList.add( 'revealed' );
							observer.unobserve( entry.target );
						}
					} );
				},
				{ threshold: 0.08 }
			);

			items.forEach( function ( el ) {
				el.classList.add( 'js-reveal' );
				var rect = el.getBoundingClientRect();
				if ( rect.top < window.innerHeight ) {
					el.classList.add( 'revealed' );
				} else {
					observer.observe( el );
				}
			} );
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );

	( function () {
		var posts       = [];
		var currentIdx  = -1;
		var overlay     = null;
		var overlayOpen = false;

		function inTextContext() {
			var el = document.activeElement;
			if ( ! el ) { return false; }
			var tag = el.tagName.toUpperCase();
			return 'INPUT' === tag || 'TEXTAREA' === tag || 'SELECT' === tag || true === el.isContentEditable;
		}

		function focusPost( idx ) {
			if ( idx < 0 || idx >= posts.length ) { return; }
			if ( currentIdx >= 0 && posts[ currentIdx ] ) {
				posts[ currentIdx ].classList.remove( 'kb-focused' );
			}
			currentIdx = idx;
			var wrap = posts[ currentIdx ];
			wrap.classList.add( 'kb-focused' );
			wrap.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
			var link = wrap.querySelector( 'a' );
			if ( link ) { link.focus( { preventScroll: true } ); }
		}

		var SHORTCUTS = [
			{ key: 'j / ↓', desc: 'Next post'         },
			{ key: 'k / ↑', desc: 'Previous post'      },
			{ key: 'o',      desc: 'Open post'          },
			{ key: '?',      desc: 'Show / hide help'   },
			{ key: 'Esc',    desc: 'Close help overlay' },
		];

		function buildOverlay() {
			var el = document.createElement( 'div' );
			el.className = 'kb-overlay';
			el.id        = 'kbOverlay';
			el.setAttribute( 'role', 'dialog' );
			el.setAttribute( 'aria-modal', 'true' );
			el.setAttribute( 'aria-label', 'Keyboard shortcuts' );

			var inner = '<div class="kb-overlay-inner">';
			inner += '<p class="kb-overlay-title">KEYBOARD_SHORTCUTS</p>';
			inner += '<dl class="kb-shortcut-list">';
			SHORTCUTS.forEach( function ( s ) {
				inner += '<dt><kbd>' + s.key + '</kbd></dt><dd>' + s.desc + '</dd>';
			} );
			inner += '</dl>';
			inner += '<button class="kb-overlay-close" aria-label="Close shortcuts overlay">';
			inner += '<i class="fa-solid fa-xmark" aria-hidden="true"></i></button>';
			inner += '</div>';
			el.innerHTML = inner;

			el.addEventListener( 'click', function ( e ) {
				if ( e.target === el ) { hideOverlay(); }
			} );
			el.querySelector( '.kb-overlay-close' ).addEventListener( 'click', hideOverlay );
			document.body.appendChild( el );
			return el;
		}

		function showOverlay() {
			if ( ! overlay ) { overlay = buildOverlay(); }
			overlay.classList.add( 'is-open' );
			overlay.removeAttribute( 'hidden' );
			overlayOpen = true;
			var btn = overlay.querySelector( '.kb-overlay-close' );
			if ( btn ) { btn.focus(); }
		}

		function hideOverlay() {
			if ( ! overlay ) { return; }
			overlay.classList.remove( 'is-open' );
			overlay.setAttribute( 'hidden', '' );
			overlayOpen = false;
		}

		function onKeyDown( e ) {
			// Never intercept command/ctrl modifier shortcuts (e.g. Ctrl+K for command palette).
			if ( e.ctrlKey || e.metaKey ) { return; }
			if ( inTextContext() ) { return; }
			var key = e.key;

			if ( 'Escape' === key && overlayOpen ) { hideOverlay(); return; }
			if ( '?' === key ) { e.preventDefault(); overlayOpen ? hideOverlay() : showOverlay(); return; }
			if ( overlayOpen ) { return; }

			if ( 'j' === key || 'ArrowDown' === key ) {
				e.preventDefault();
				focusPost( currentIdx + 1 >= posts.length ? 0 : currentIdx + 1 );
				return;
			}
			if ( 'k' === key || 'ArrowUp' === key ) {
				e.preventDefault();
				focusPost( currentIdx - 1 < 0 ? posts.length - 1 : currentIdx - 1 );
				return;
			}
			if ( 'o' === key && currentIdx >= 0 && posts[ currentIdx ] ) {
				var link = posts[ currentIdx ].querySelector( 'a' );
				if ( link ) { link.click(); }
			}
		}

		function init() {
			var wraps = document.querySelectorAll( '.post-wrap' );
			if ( 0 === wraps.length ) { return; }
			wraps.forEach( function ( el ) { posts.push( el ); } );
			document.addEventListener( 'keydown', onKeyDown );
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );


}() );

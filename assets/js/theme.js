/**
 * theme.js — global scripts loaded on every front-end page.
 *
 * navigation, accordion, read-tracker, back-to-top.
 *
 * @package Cyberfunk
 */

( function () {
	'use strict';

	var siteNav = document.querySelector( '.site-nav' );
	if ( siteNav ) {
		function onNavScroll() {
			siteNav.classList.toggle( 'nav-scrolled', window.scrollY > 4 );
		}
		window.addEventListener( 'scroll', onNavScroll, { passive: true } );
		onNavScroll();
	}

	var announceBar = document.getElementById( 'announceBar' );
	if ( announceBar ) {
		if ( sessionStorage.getItem( 'cf_announce_dismissed' ) ) {
			announceBar.hidden = true;
		} else {
			var announceClose = announceBar.querySelector( '.announce-close' );
			if ( announceClose ) {
				announceClose.addEventListener( 'click', function () {
					announceBar.hidden = true;
					sessionStorage.setItem( 'cf_announce_dismissed', '1' );
				} );
			}
		}
	}

	var navToggle = document.getElementById( 'navToggle' );
	var mobileMenu = document.getElementById( 'mobileMenu' );

	if ( navToggle && mobileMenu ) {
		function openMenu() {
			mobileMenu.classList.add( 'open' );
			navToggle.setAttribute( 'aria-expanded', 'true' );
			mobileMenu.setAttribute( 'aria-hidden', 'false' );
			navToggle.setAttribute( 'aria-label', navToggle.getAttribute( 'data-label-close' ) || 'Close navigation menu' );
		}

		function closeMenu() {
			mobileMenu.classList.remove( 'open' );
			navToggle.setAttribute( 'aria-expanded', 'false' );
			mobileMenu.setAttribute( 'aria-hidden', 'true' );
			navToggle.setAttribute( 'aria-label', navToggle.getAttribute( 'data-label-open' ) || 'Open navigation menu' );
		}

		function isMenuOpen() {
			return mobileMenu.classList.contains( 'open' );
		}

		navToggle.setAttribute( 'data-label-open', navToggle.getAttribute( 'aria-label' ) || 'Open navigation menu' );

		navToggle.addEventListener( 'click', function () {
			if ( isMenuOpen() ) {
				closeMenu();
			} else {
				openMenu();
				var firstLink = mobileMenu.querySelector( 'a' );
				if ( firstLink ) {
					firstLink.focus();
				}
			}
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && isMenuOpen() ) {
				closeMenu();
				navToggle.focus();
			}
		} );

		mobileMenu.addEventListener( 'keydown', function ( e ) {
			if ( 'Tab' !== e.key || ! isMenuOpen() ) {
				return;
			}
			var focusable = Array.prototype.slice.call(
				mobileMenu.querySelectorAll( 'a[href], button:not([disabled])' )
			);
			if ( 0 === focusable.length ) {
				return;
			}
			var first = focusable[ 0 ];
			var last  = focusable[ focusable.length - 1 ];
			if ( e.shiftKey && document.activeElement === first ) {
				e.preventDefault();
				last.focus();
			} else if ( ! e.shiftKey && document.activeElement === last ) {
				e.preventDefault();
				first.focus();
			}
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( isMenuOpen() && ! e.target.closest( '.nav-bar' ) ) {
				closeMenu();
			}
		} );
	}

	function closeAllDropdowns( except ) {
		document.querySelectorAll( '.nav-links > li.has-sub-menu.open' ).forEach( function ( li ) {
			if ( li !== except ) {
				closeDropdown( li );
			}
		} );
	}

	function openDropdown( li ) {
		var btn = li.querySelector( ':scope > .sub-menu-toggle' );
		var sub = li.querySelector( ':scope > .sub-menu' );
		li.classList.add( 'open' );
		if ( btn ) { btn.setAttribute( 'aria-expanded', 'true' ); }
		if ( sub ) { sub.setAttribute( 'aria-hidden', 'false' ); }
	}

	function closeDropdown( li ) {
		var btn = li.querySelector( ':scope > .sub-menu-toggle' );
		var sub = li.querySelector( ':scope > .sub-menu' );
		li.classList.remove( 'open' );
		if ( btn ) { btn.setAttribute( 'aria-expanded', 'false' ); }
		if ( sub ) { sub.setAttribute( 'aria-hidden', 'true' ); }
	}

	document.querySelectorAll( '.nav-links > li' ).forEach( function ( li ) {
		var subMenu = li.querySelector( ':scope > .sub-menu' );
		if ( ! subMenu ) {
			return;
		}

		li.classList.add( 'has-sub-menu' );
		subMenu.setAttribute( 'aria-hidden', 'true' );

		var btn = document.createElement( 'button' );
		btn.type      = 'button';
		btn.className = 'sub-menu-toggle';
		btn.setAttribute( 'aria-expanded', 'false' );
		btn.setAttribute( 'aria-label', 'Toggle sub-menu' );
		btn.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';

		var topLink = li.querySelector( ':scope > a' );
		if ( topLink ) {
			topLink.after( btn );
		} else {
			li.prepend( btn );
		}

		btn.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			if ( li.classList.contains( 'open' ) ) {
				closeDropdown( li );
			} else {
				closeAllDropdowns( li );
				openDropdown( li );
				var firstSubLink = subMenu.querySelector( 'a' );
				if ( firstSubLink ) {
					firstSubLink.focus();
				}
			}
		} );

		li.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && li.classList.contains( 'open' ) ) {
				closeDropdown( li );
				btn.focus();
			}
		} );

		li.addEventListener( 'pointerenter', function ( e ) {
			if ( 'mouse' === e.pointerType ) {
				closeAllDropdowns( li );
				openDropdown( li );
			}
		} );

		li.addEventListener( 'pointerleave', function ( e ) {
			if ( 'mouse' === e.pointerType ) {
				closeDropdown( li );
			}
		} );
	} );

	document.addEventListener( 'click', function ( e ) {
		if ( ! e.target.closest( '.nav-links' ) ) {
			closeAllDropdowns( null );
		}
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key ) {
			closeAllDropdowns( null );
		}
	} );

	function toggleArchive( btn ) {
		var item   = btn.closest( '.archive-item' );
		var isOpen = item.classList.contains( 'open' );
		item.classList.toggle( 'open', ! isOpen );
		btn.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
	}

	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest( '.archive-toggle' );
		if ( btn ) {
			toggleArchive( btn );
		}
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Enter' !== e.key && ' ' !== e.key ) {
			return;
		}
		var btn = e.target.closest( '.archive-toggle' );
		if ( btn ) {
			e.preventDefault();
			toggleArchive( btn );
		}
	} );

	var READ_PREFIX = 'cf_read_';

	function rtMarkRead( id ) {
		try { localStorage.setItem( READ_PREFIX + id, '1' ); } catch ( e ) {}
	}

	function rtIsRead( id ) {
		try { return '1' === localStorage.getItem( READ_PREFIX + id ); } catch ( e ) { return false; }
	}

	function rtInitSingle() {
		var match = document.body.className.match( /\bpostid-(\d+)\b/ );
		var id    = match ? match[ 1 ] : null;
		if ( ! id || rtIsRead( id ) ) {
			return;
		}

		var recorded = false;
		function record() {
			if ( recorded ) { return; }
			recorded = true;
			rtMarkRead( id );
		}

		var dwellTimer = setTimeout( record, 10000 );

		window.addEventListener( 'scroll', function onScroll() {
			var scrolled = window.scrollY + window.innerHeight;
			var total    = document.documentElement.scrollHeight;
			if ( scrolled / total >= 0.25 ) {
				clearTimeout( dwellTimer );
				record();
				window.removeEventListener( 'scroll', onScroll );
			}
		}, { passive: true } );
	}

	function rtInitArchive() {
		var articles = document.querySelectorAll( 'article[id^="post-"]' );
		articles.forEach( function ( article ) {
			var id = article.id.replace( 'post-', '' );
			if ( ! id || ! rtIsRead( id ) ) {
				return;
			}
			var postContent = article.querySelector( '.post-content' );
			if ( postContent && ! postContent.querySelector( '.read-badge' ) ) {
				var badge = document.createElement( 'span' );
				badge.className = 'read-badge';
				badge.setAttribute( 'aria-label', 'Already read' );
				badge.innerHTML = '<i class="fa-solid fa-eye" aria-hidden="true"></i>SYS::READ';

				var catBadge = postContent.querySelector( '.post-category-badge' );
				if ( catBadge && catBadge.parentNode ) {
					catBadge.parentNode.insertBefore( badge, catBadge.nextSibling );
				} else {
					postContent.insertBefore( badge, postContent.firstChild );
				}
			}
		} );
	}

	function rtInit() {
		if ( document.body.classList.contains( 'single' ) ||
			 document.body.classList.contains( 'page' ) ) {
			rtInitSingle();
		} else {
			rtInitArchive();
		}
	}

	function bttInit() {
		var btn = document.getElementById( 'backToTop' );
		if ( ! btn ) {
			return;
		}

		btn.removeAttribute( 'hidden' );

		var prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		window.addEventListener( 'scroll', function () {
			btn.classList.toggle( 'visible', window.scrollY > 400 );
		}, { passive: true } );

		btn.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: prefersReduced ? 'instant' : 'smooth' } );
			var skip = document.querySelector( '.skip-link' );
			if ( skip ) {
				skip.focus();
			}
		} );
	}

	function init() {
		rtInit();
		bttInit();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

	( function () {
		var overlay     = null;
		var input       = null;
		var results     = null;
		var isOpen      = false;
		var debounceTimer = null;
		var currentIdx  = -1;
		var resultItems = [];

		var data    = window.cyberfunkData || {};
		var restUrl = data.restUrl || '/wp-json/';
		var homeUrl = data.homeUrl || '/';

		var quickLinks = [
			{ label: 'HOME',     icon: 'fa-house',          url: homeUrl },
			{ label: 'ARCHIVES', icon: 'fa-folder-open',    url: homeUrl + 'archives/' },
			{ label: 'SEARCH',   icon: 'fa-magnifying-glass', url: homeUrl + '?s=' },
		];

		function buildOverlay() {
			overlay = document.createElement( 'div' );
			overlay.id        = 'cmdPalette';
			overlay.className = 'cmd-overlay';
			overlay.setAttribute( 'role', 'dialog' );
			overlay.setAttribute( 'aria-modal', 'true' );
			overlay.setAttribute( 'aria-label', 'Command palette' );
			overlay.setAttribute( 'aria-hidden', 'true' );

			overlay.innerHTML = [
				'<div class="cmd-inner">',
				'  <div class="cmd-search-wrap">',
				'    <i class="fa-solid fa-magnifying-glass cmd-search-icon" aria-hidden="true"></i>',
				'    <input type="search" class="cmd-input" placeholder="SEARCH_TRANSMISSIONS..." autocomplete="off" spellcheck="false" aria-label="Search posts" />',
				'    <kbd class="cmd-esc-hint">ESC</kbd>',
				'  </div>',
				'  <div class="cmd-results" role="listbox" aria-label="Search results"></div>',
				'</div>',
			].join( '' );

			document.body.appendChild( overlay );

			input   = overlay.querySelector( '.cmd-input' );
			results = overlay.querySelector( '.cmd-results' );

			overlay.addEventListener( 'click', function ( e ) {
				if ( e.target === overlay ) { close(); }
			} );

			input.addEventListener( 'input', onInput );
			input.addEventListener( 'keydown', onInputKeyDown );
		}

		function renderQuickLinks() {
			var html = '<p class="cmd-section-label">QUICK_NAV</p><ul class="cmd-list">';
			quickLinks.forEach( function ( link, i ) {
				html += '<li role="option" class="cmd-item" data-url="' + link.url + '" data-idx="' + i + '">';
				html += '<i class="fa-solid ' + link.icon + ' cmd-item-icon" aria-hidden="true"></i>';
				html += '<span class="cmd-item-title">' + link.label + '</span>';
				html += '</li>';
			} );
			html += '</ul>';
			results.innerHTML = html;
			bindResultClicks();
			currentIdx = -1;
		}

		function onInput() {
			clearTimeout( debounceTimer );
			var query = input.value.trim();
			if ( '' === query ) {
				renderQuickLinks();
				return;
			}
			results.innerHTML = '<p class="cmd-searching">SCANNING_TRANSMISSIONS...</p>';
			debounceTimer = setTimeout( function () { search( query ); }, 250 );
		}

		function search( query ) {
			fetch( restUrl + 'wp/v2/posts?search=' + encodeURIComponent( query ) + '&per_page=7&_fields=id,title,link,excerpt' )
				.then( function ( r ) { return r.json(); } )
				.then( function ( posts ) {
					if ( ! Array.isArray( posts ) || 0 === posts.length ) {
						results.innerHTML = '<p class="cmd-no-results">NO_RESULTS // ' + query.replace( /</g, '&lt;' ) + '</p>';
						return;
					}
					var html = '<ul class="cmd-list" role="listbox">';
					posts.forEach( function ( post, i ) {
						var title = ( post.title && post.title.rendered )
							? post.title.rendered.replace( /<[^>]+>/g, '' )
							: 'Untitled';

						var excerpt = '';
						if ( post.excerpt && post.excerpt.rendered ) {
							excerpt = post.excerpt.rendered.replace( /<[^>]+>/g, '' ).trim();
							if ( excerpt.length > 90 ) { excerpt = excerpt.slice( 0, 90 ) + '…'; }
						}

						html += '<li role="option" class="cmd-item" data-url="' + post.link + '" data-idx="' + i + '">';
						html += '<i class="fa-solid fa-file-lines cmd-item-icon" aria-hidden="true"></i>';
						html += '<span class="cmd-item-body">';
						html += '<span class="cmd-item-title">' + title + '</span>';
						if ( excerpt ) {
							html += '<span class="cmd-item-excerpt">' + excerpt + '</span>';
						}
						html += '</span>';
						html += '</li>';
					} );
					html += '</ul>';
					results.innerHTML = html;
					bindResultClicks();
					currentIdx = -1;
				} )
				.catch( function () {
					results.innerHTML = '<p class="cmd-no-results">CONNECTION_ERROR</p>';
				} );
		}

		function bindResultClicks() {
			resultItems = Array.prototype.slice.call( results.querySelectorAll( '.cmd-item' ) );
			resultItems.forEach( function ( item ) {
				item.addEventListener( 'click', function () {
					window.location.href = item.getAttribute( 'data-url' );
				} );
			} );
		}

		function highlightItem( idx ) {
			resultItems.forEach( function ( item ) { item.classList.remove( 'cmd-item-active' ); } );
			if ( idx >= 0 && resultItems[ idx ] ) {
				resultItems[ idx ].classList.add( 'cmd-item-active' );
				resultItems[ idx ].scrollIntoView( { block: 'nearest' } );
			}
			currentIdx = idx;
		}

		function onInputKeyDown( e ) {
			if ( 'ArrowDown' === e.key ) {
				e.preventDefault();
				highlightItem( currentIdx + 1 >= resultItems.length ? 0 : currentIdx + 1 );
			} else if ( 'ArrowUp' === e.key ) {
				e.preventDefault();
				highlightItem( currentIdx - 1 < 0 ? resultItems.length - 1 : currentIdx - 1 );
			} else if ( 'Enter' === e.key && currentIdx >= 0 && resultItems[ currentIdx ] ) {
				window.location.href = resultItems[ currentIdx ].getAttribute( 'data-url' );
			} else if ( 'Escape' === e.key ) {
				close();
			}
		}

		function open() {
			if ( ! overlay ) { buildOverlay(); }
			overlay.setAttribute( 'aria-hidden', 'false' );
			overlay.classList.add( 'is-open' );
			isOpen = true;
			document.body.style.overflow = 'hidden';
			input.value = '';
			renderQuickLinks();
			// Small delay so the transition plays before focus triggers scroll.
			setTimeout( function () { input.focus(); }, 60 );
		}

		function close() {
			if ( ! overlay ) { return; }
			overlay.setAttribute( 'aria-hidden', 'true' );
			overlay.classList.remove( 'is-open' );
			isOpen = false;
			document.body.style.overflow = '';
		}

		document.addEventListener( 'keydown', function ( e ) {
			if ( ( e.metaKey || e.ctrlKey ) && 'k' === e.key ) {
				e.preventDefault();
				isOpen ? close() : open();
			} else if ( 'Escape' === e.key && isOpen ) {
				close();
			}
		} );
	}() );

}() );

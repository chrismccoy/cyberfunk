/**
 * single.js — scripts loaded on singular post and page views.
 *
 * reading-progress (+ title progress), share, toc (+ active tracking),
 * lightbox, code-copy.
 *
 * @package Cyberfunk
 */

( function () {
	'use strict';

	function copyToClipboard( text, onSuccess ) {
		if ( navigator.clipboard && navigator.clipboard.writeText ) {
			navigator.clipboard.writeText( text ).then( onSuccess ).catch( function () {
				legacyCopy( text, onSuccess );
			} );
		} else {
			legacyCopy( text, onSuccess );
		}
	}

	function legacyCopy( text, onSuccess ) {
		var el = document.createElement( 'textarea' );
		el.value = text;
		el.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0;';
		document.body.appendChild( el );
		el.select();
		try {
			if ( document.execCommand( 'copy' ) && onSuccess ) {
				onSuccess();
			}
		} catch ( e ) {
			// Silent failure.
		}
		document.body.removeChild( el );
	}

	( function () {
		var bar     = document.getElementById( 'readProgress' );
		var article = document.querySelector( '.post-body' );
		var label   = document.getElementById( 'readProgressLabel' );

		if ( ! bar || ! article ) {
			return;
		}

		var prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		var readingTime    = parseInt( bar.getAttribute( 'data-reading-time' ) || '0', 10 );
		var originalTitle  = document.title;

		function finishTime( remainingMinutes ) {
			var finish = new Date( Date.now() + remainingMinutes * 60000 );
			var hh     = finish.getHours().toString().padStart( 2, '0' );
			var mm     = finish.getMinutes().toString().padStart( 2, '0' );
			return hh + ':' + mm;
		}

		function updateLabel( pct ) {
			if ( ! label || readingTime <= 0 ) {
				return;
			}
			if ( pct >= 99 ) {
				label.textContent = 'FIN';
			} else {
				var remaining = Math.max( 1, Math.ceil( readingTime * ( 1 - pct / 100 ) ) );
				label.textContent = remaining + ' MIN LEFT // FINISH AT ' + finishTime( remaining );
			}
			if ( pct > 2 && 'true' === label.getAttribute( 'aria-hidden' ) ) {
				label.setAttribute( 'aria-hidden', 'false' );
			}
		}

		function updateProgress() {
			var articleTop    = article.getBoundingClientRect().top + window.pageYOffset;
			var articleBottom = articleTop + article.offsetHeight;
			var total         = articleBottom - articleTop - window.innerHeight;

			if ( total <= 0 ) {
				bar.style.width = '100%';
				updateLabel( 100 );
				document.title = '(100%) ' + originalTitle;
				return;
			}

			var scrolled = window.pageYOffset - articleTop;
			var pct      = Math.min( 100, Math.max( 0, ( scrolled / total ) * 100 ) );
			bar.style.width = pct + '%';
			updateLabel( pct );

			// Update browser tab title with reading progress.
			if ( pct >= 1 ) {
				document.title = '(' + Math.round( pct ) + '%) ' + originalTitle;
			} else {
				document.title = originalTitle;
			}
		}

		if ( prefersReduced ) {
			bar.style.width = '100%';
			if ( label ) { label.textContent = 'FIN'; }
			return;
		}

		window.addEventListener( 'scroll', updateProgress, { passive: true } );
		updateProgress();
	}() );

	( function () {
		document.querySelectorAll( '.js-copy-link' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var url  = btn.dataset.copyUrl;
				var icon = btn.querySelector( 'i' );
				if ( ! url ) {
					return;
				}
				copyToClipboard( url, function () {
					if ( icon ) {
						icon.className = 'fa-solid fa-check';
					}
					btn.setAttribute( 'aria-label', 'Link copied!' );
					setTimeout( function () {
						if ( icon ) {
							icon.className = 'fa-solid fa-link';
						}
						btn.setAttribute( 'aria-label', 'Copy link' );
					}, 1500 );
				} );
			} );
		} );
	}() );

	( function () {
		var widget = document.getElementById( 'toc-widget' );
		if ( ! widget ) {
			return;
		}

		var toggle = widget.querySelector( '.js-toc-toggle' );
		var list   = document.getElementById( 'toc-list' );

		if ( ! toggle || ! list ) {
			return;
		}

		// Collapse / expand toggle.
		toggle.addEventListener( 'click', function () {
			var expanded = 'true' === toggle.getAttribute( 'aria-expanded' );
			list.style.display = expanded ? 'none' : '';
			toggle.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
			widget.classList.toggle( 'toc-collapsed', expanded );
		} );

		// Smooth scroll without adding # to the URL. Handles #top → scroll to top.
		list.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				var id = link.getAttribute( 'href' ).slice( 1 );
				if ( '' === id || 'top' === id ) {
					window.scrollTo( { top: 0, behavior: 'smooth' } );
					history.replaceState( null, '', window.location.pathname + window.location.search );
					return;
				}
				var target = document.getElementById( id );
				if ( target ) {
					target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
					history.replaceState( null, '', window.location.pathname + window.location.search );
				}
			} );
		} );

		// Active section tracking via IntersectionObserver.
		var headingIds = [];
		list.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
			headingIds.push( link.getAttribute( 'href' ).slice( 1 ) );
		} );

		if ( headingIds.length > 0 && ( 'IntersectionObserver' in window ) ) {
			var headingObserver = new IntersectionObserver(
				function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							var activeId = entry.target.id;
							list.querySelectorAll( 'a' ).forEach( function ( a ) {
								a.classList.toggle( 'toc-active', a.getAttribute( 'href' ) === '#' + activeId );
							} );
						}
					} );
				},
				// Trigger when heading crosses 80px from the top of the viewport.
				{ rootMargin: '-80px 0px -70% 0px', threshold: 0 }
			);

			headingIds.forEach( function ( id ) {
				var el = document.getElementById( id );
				if ( el ) { headingObserver.observe( el ); }
			} );
		}
	}() );

	( function () {
		var items        = [];
		var currentIndex = 0;
		var overlay      = null;
		var lastFocused  = null;
		var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		function collectItems() {
			document.querySelectorAll( '.gallery-item a' ).forEach( function ( link ) {
				var img = link.querySelector( 'img' );
				items.push( { src: link.href, alt: img ? img.alt : '', trigger: link } );
				link.setAttribute( 'data-lb-index', items.length - 1 );
				link.addEventListener( 'click', onTriggerClick );
			} );

			document.querySelectorAll( '.post-body img' ).forEach( function ( img ) {
				if ( img.closest( '.gallery-section' ) ) {
					return;
				}
				var parent  = img.parentElement;
				var src     = ( parent && 'A' === parent.tagName ) ? parent.href : img.src;
				var trigger = ( parent && 'A' === parent.tagName ) ? parent : img;

				if ( ! src || 0 === src.indexOf( 'data:' ) ) {
					return;
				}

				if ( 'IMG' === trigger.tagName ) {
					trigger.setAttribute( 'tabindex', '0' );
					trigger.setAttribute( 'role', 'button' );
					trigger.setAttribute( 'aria-label', img.alt || 'View image' );
					trigger.style.cursor = 'zoom-in';
				}

				items.push( { src: src, alt: img.alt, trigger: trigger } );
				trigger.setAttribute( 'data-lb-index', items.length - 1 );
				trigger.addEventListener( 'click', onTriggerClick );

				if ( 'IMG' === trigger.tagName ) {
					trigger.addEventListener( 'keydown', function ( e ) {
						if ( 'Enter' === e.key || ' ' === e.key ) {
							e.preventDefault();
							onTriggerClick.call( trigger, e );
						}
					} );
				}
			} );
		}

		function onTriggerClick( e ) {
			e.preventDefault();
			lbOpen( parseInt( this.getAttribute( 'data-lb-index' ), 10 ) );
		}

		function buildOverlay() {
			overlay = document.createElement( 'div' );
			overlay.id        = 'lb-overlay';
			overlay.className = 'lb-overlay';
			overlay.setAttribute( 'role', 'dialog' );
			overlay.setAttribute( 'aria-modal', 'true' );
			overlay.setAttribute( 'aria-label', 'Image lightbox' );
			overlay.setAttribute( 'aria-hidden', 'true' );
			overlay.innerHTML = [
				'<div class="lb-backdrop"></div>',
				'<div class="lb-stage">',
				'  <button type="button" class="lb-close" aria-label="Close lightbox">',
				'    <i class="fa-solid fa-xmark" aria-hidden="true"></i>',
				'  </button>',
				'  <button type="button" class="lb-prev" aria-label="Previous image">',
				'    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
				'  </button>',
				'  <div class="lb-image-wrap"><img class="lb-img" src="" alt="" /></div>',
				'  <button type="button" class="lb-next" aria-label="Next image">',
				'    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
				'  </button>',
				'  <div class="lb-counter" aria-live="polite"></div>',
				'</div>'
			].join( '' );

			document.body.appendChild( overlay );
			overlay.querySelector( '.lb-backdrop' ).addEventListener( 'click', lbClose );
			overlay.querySelector( '.lb-close' ).addEventListener( 'click', lbClose );
			overlay.querySelector( '.lb-prev' ).addEventListener( 'click', lbPrev );
			overlay.querySelector( '.lb-next' ).addEventListener( 'click', lbNext );
		}

		function lbOpen( index ) {
			if ( ! overlay ) { buildOverlay(); }
			currentIndex = index;
			lastFocused  = document.activeElement;
			lbRender();
			overlay.setAttribute( 'aria-hidden', 'false' );
			if ( ! reducedMotion ) {
				overlay.classList.add( 'lb-visible' );
			} else {
				overlay.style.display = 'flex';
			}
			document.body.style.overflow = 'hidden';
			overlay.querySelector( '.lb-close' ).focus();
		}

		function lbClose() {
			if ( ! overlay ) { return; }
			overlay.setAttribute( 'aria-hidden', 'true' );
			if ( ! reducedMotion ) {
				overlay.classList.remove( 'lb-visible' );
			} else {
				overlay.style.display = '';
			}
			document.body.style.overflow = '';
			if ( lastFocused ) { lastFocused.focus(); }
		}

		function lbRender() {
			var item    = items[ currentIndex ];
			overlay.querySelector( '.lb-img' ).src              = item.src;
			overlay.querySelector( '.lb-img' ).alt              = item.alt;
			overlay.querySelector( '.lb-counter' ).textContent  = ( currentIndex + 1 ) + ' / ' + items.length;
			overlay.querySelector( '.lb-prev' ).disabled        = ( 0 === currentIndex );
			overlay.querySelector( '.lb-next' ).disabled        = ( items.length - 1 === currentIndex );
		}

		function lbPrev() { if ( currentIndex > 0 ) { currentIndex--; lbRender(); } }
		function lbNext() { if ( currentIndex < items.length - 1 ) { currentIndex++; lbRender(); } }

		document.addEventListener( 'keydown', function ( e ) {
			if ( ! overlay || 'true' === overlay.getAttribute( 'aria-hidden' ) ) { return; }
			if ( 'Escape' === e.key )          { lbClose(); }
			else if ( 'ArrowLeft' === e.key )  { lbPrev(); }
			else if ( 'ArrowRight' === e.key ) { lbNext(); }
		} );

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', collectItems );
		} else {
			collectItems();
		}
	}() );

	( function () {
		function injectButton( pre ) {
			var btn  = document.createElement( 'button' );
			var lang = pre.getAttribute( 'data-lang' ) || '';
			btn.type      = 'button';
			btn.className = 'code-copy-btn';
			btn.setAttribute( 'aria-label', 'Copy code to clipboard' );
			btn.innerHTML = lang
				? '<i class="fa-regular fa-copy" aria-hidden="true"></i><span class="code-lang-label">' + lang + '</span>'
				: '<i class="fa-regular fa-copy" aria-hidden="true"></i>';
			pre.appendChild( btn );

			btn.addEventListener( 'click', function () {
				var codeEl = pre.querySelector( 'code' );
				var text   = ( codeEl ? codeEl : pre ).textContent || '';
				copyToClipboard( text, function () {
					btn.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
					btn.setAttribute( 'aria-label', 'Copied!' );
					setTimeout( function () {
						btn.innerHTML = '<i class="fa-regular fa-copy" aria-hidden="true"></i>';
						btn.setAttribute( 'aria-label', 'Copy code to clipboard' );
					}, 1500 );
				} );
			} );
		}

		function init() {
			document.querySelectorAll( '.post-body pre' ).forEach( injectButton );
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );

	( function () {
		var row = document.querySelector( '.reaction-row' );
		if ( ! row ) { return; }

		var postId   = row.getAttribute( 'data-post-id' );
		var data     = window.cyberfunkData || {};
		var STORE_KEY = 'cf_reacted_' + postId;

		// Restore previously voted state.
		try {
			var voted = localStorage.getItem( STORE_KEY );
			if ( voted ) {
				var prev = row.querySelector( '[data-reaction="' + voted + '"]' );
				if ( prev ) { prev.classList.add( 'reaction-voted' ); }
			}
		} catch ( e ) {}

		row.querySelectorAll( '.reaction-btn' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				try { if ( localStorage.getItem( STORE_KEY ) ) { return; } } catch ( e ) {}

				var reaction = btn.getAttribute( 'data-reaction' );
				var countEl  = btn.querySelector( '.reaction-count' );

				// Optimistic UI.
				if ( countEl ) { countEl.textContent = parseInt( countEl.textContent || '0', 10 ) + 1; }
				btn.classList.add( 'reaction-voted' );
				try { localStorage.setItem( STORE_KEY, reaction ); } catch ( e ) {}

				// Persist via AJAX.
				var body = new FormData();
				body.append( 'action',   'cyberfunk_react' );
				body.append( 'nonce',    data.reactNonce || '' );
				body.append( 'post_id',  postId );
				body.append( 'reaction', reaction );

				fetch( data.ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: body } )
					.then( function ( r ) { return r.json(); } )
					.then( function ( res ) {
						if ( res.success && countEl ) { countEl.textContent = res.data.count; }
					} )
					.catch( function () {} );
			} );
		} );
	}() );

	( function () {
		document.querySelectorAll( '.series-toc-item[data-post-id]' ).forEach( function ( item ) {
			var id = item.getAttribute( 'data-post-id' );
			try {
				if ( '1' === localStorage.getItem( 'cf_read_' + id ) ) {
					item.classList.add( 'series-toc-read' );
				}
			} catch ( e ) {}
		} );
	}() );

	( function () {
		document.querySelectorAll( '.spoiler' ).forEach( function ( el ) {
			function reveal() {
				el.setAttribute( 'data-revealed', 'true' );
				el.removeAttribute( 'tabindex' );
				el.removeAttribute( 'role' );
				el.removeAttribute( 'aria-label' );
				el.removeEventListener( 'click', reveal );
				el.removeEventListener( 'keydown', onKey );
			}
			function onKey( e ) {
				if ( 'Enter' === e.key || ' ' === e.key ) {
					e.preventDefault();
					reveal();
				}
			}
			el.addEventListener( 'click', reveal );
			el.addEventListener( 'keydown', onKey );
		} );
	}() );

	( function () {
		var SIZES = [ 'fs-small', 'fs-medium', 'fs-large' ];
		var body  = document.body;
		var btns  = document.querySelectorAll( '.fsc-btn' );
		if ( 0 === btns.length ) { return; }

		var current;
		try {
			current = localStorage.getItem( 'cf_font_size' ) || 'fs-medium';
		} catch ( e ) {
			current = 'fs-medium';
		}

		// Apply saved size immediately.
		body.classList.add( current );
		btns.forEach( function ( btn ) {
			if ( btn.dataset.fontSize === current ) { btn.classList.add( 'fsc-active' ); }
			btn.addEventListener( 'click', function () {
				var size = btn.dataset.fontSize;
				SIZES.forEach( function ( s ) { body.classList.remove( s ); } );
				body.classList.add( size );
				try { localStorage.setItem( 'cf_font_size', size ); } catch ( e ) {}
				btns.forEach( function ( b ) {
					b.classList.toggle( 'fsc-active', b.dataset.fontSize === size );
				} );
			} );
		} );
	}() );

	( function () {
		function init() {
			var content = document.querySelector( '.post-body' );
			if ( ! content ) { return; }

			content.querySelectorAll( 'h2[id], h3[id], h4[id]' ).forEach( function ( h ) {
				var btn = document.createElement( 'a' );
				btn.className = 'heading-anchor';
				btn.href      = '#' + h.id;
				btn.setAttribute( 'aria-label', 'Copy link to this section' );
				btn.innerHTML = '<i class="fa-solid fa-link" aria-hidden="true"></i>';

				btn.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					var url = window.location.origin + window.location.pathname + '#' + h.id;
					copyToClipboard( url, function () {
						btn.classList.add( 'heading-anchor--copied' );
						btn.setAttribute( 'aria-label', 'Link copied!' );
						setTimeout( function () {
							btn.classList.remove( 'heading-anchor--copied' );
							btn.setAttribute( 'aria-label', 'Copy link to this section' );
						}, 1500 );
					} );
				} );

				h.classList.add( 'has-anchor' );
				h.appendChild( btn );
			} );
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );

	( function () {
		function init() {
			var form = document.getElementById( 'commentform' );
			if ( ! form ) { return; }
			var ta = form.querySelector( '#comment' );
			if ( ! ta ) { return; }

			var data = window.cyberfunkPost || {};
			var key  = 'cf_draft_' + ( data.id || window.location.pathname );

			// Restore saved draft.
			try {
				var saved = localStorage.getItem( key );
				if ( saved ) { ta.value = saved; }
			} catch ( e ) {}

			// Auto-save on input with a short debounce.
			var timer;
			ta.addEventListener( 'input', function () {
				clearTimeout( timer );
				timer = setTimeout( function () {
					try { localStorage.setItem( key, ta.value ); } catch ( e ) {}
				}, 500 );
			} );

			// Clear on submit so the field doesn't re-appear after posting.
			form.addEventListener( 'submit', function () {
				try { localStorage.removeItem( key ); } catch ( e ) {}
			} );
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );

	( function () {
		var data = window.cyberfunkPost;
		if ( ! data || ! data.id ) { return; }

		var KEY = 'cf_history';
		var MAX = 6;

		try {
			var hist = JSON.parse( localStorage.getItem( KEY ) || '[]' );
			// Move current post to the front (remove duplicate first).
			hist = hist.filter( function ( p ) { return p.id !== data.id; } );
			hist.unshift( {
				id:    data.id,
				title: data.title,
				url:   data.url,
				thumb: data.thumb,
				time:  data.time,
			} );
			if ( hist.length > MAX ) { hist.length = MAX; }
			localStorage.setItem( KEY, JSON.stringify( hist ) );
			// Also mark as read for the series TOC / read-tracker.
			localStorage.setItem( 'cf_read_' + data.id, '1' );
		} catch ( e ) {}
	}() );

	( function () {
		function init() {
			var items = document.querySelectorAll( '.sp-item[data-post-id]' );
			if ( 0 === items.length ) { return; }

			var total = items.length;
			var read  = 0;

			items.forEach( function ( item ) {
				var id = item.getAttribute( 'data-post-id' );
				try {
					if ( '1' === localStorage.getItem( 'cf_read_' + id ) ) {
						item.classList.add( 'sp-read' );
						read++;
					}
				} catch ( e ) {}
			} );

			var bar    = document.getElementById( 'sp-bar' );
			var status = document.getElementById( 'sp-status' );

			if ( bar ) {
				bar.style.width = ( total > 0 ? Math.round( ( read / total ) * 100 ) : 0 ) + '%';
			}
			if ( status ) {
				status.textContent = read + ' / ' + total + ' READ';
			}
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	}() );

}() );

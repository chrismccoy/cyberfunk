/**
 * load-more.js — Progressive pagination for archive pages.
 *
 * @package Cyberfunk
 */

( function () {
	'use strict';

	function findNextLink( paginationEl ) {
		// The "next page" <a> contains a .fa-chevron-right icon.
		var icons = paginationEl.querySelectorAll( 'a.page-btn i.fa-chevron-right' );
		return icons.length ? icons[ 0 ].parentElement : null;
	}

	function init() {
		var container  = document.querySelector( '.main-col' );
		var pagination = container ? container.querySelector( '.pagination' ) : null;

		if ( ! container || ! pagination ) { return; }

		var nextLink = findNextLink( pagination );

		// No next page — just hide pagination (single page of results).
		if ( ! nextLink ) {
			pagination.hidden = true;
			return;
		}

		// Hide paginated navigation; the button takes over.
		pagination.hidden = true;

		var nextUrl = nextLink.href;

		// Build the LOAD MORE button.
		var btn = document.createElement( 'button' );
		btn.type      = 'button';
		btn.className = 'load-more-btn';
		btn.innerHTML =
			'<i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>' +
			' LOAD_MORE // TRANSMISSIONS';

		container.insertBefore( btn, pagination );

		var loading = false;

		btn.addEventListener( 'click', function () {
			if ( loading ) { return; }
			loading      = true;
			btn.disabled = true;
			btn.innerHTML =
				'<i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>' +
				' LOADING...';

			fetch( nextUrl )
				.then( function ( r ) { return r.text(); } )
				.then( function ( html ) {
					var parser       = new DOMParser();
					var doc          = parser.parseFromString( html, 'text/html' );
					var newPosts     = doc.querySelectorAll( '.post-wrap' );
					var newPagination = doc.querySelector( '.pagination' );

					// Append fetched cards before the button.
					newPosts.forEach( function ( post ) {
						container.insertBefore( post, btn );
					} );

					// Find the next-page URL in the freshly fetched page.
					var newNextLink = newPagination ? findNextLink( newPagination ) : null;

					if ( newNextLink ) {
						nextUrl      = newNextLink.href;
						btn.disabled = false;
						btn.innerHTML =
							'<i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>' +
							' LOAD_MORE // TRANSMISSIONS';
						loading = false;
					} else {
						// No more pages.
						btn.innerHTML = 'END_OF_TRANSMISSIONS';
						btn.classList.add( 'load-more-done' );
					}
				} )
				.catch( function () {
					btn.disabled = false;
					btn.innerHTML =
						'<i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>' +
						' LOAD_MORE // TRANSMISSIONS';
					loading = false;
				} );
		} );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

}() );

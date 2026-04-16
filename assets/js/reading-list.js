/**
 * reading-list.js — Queue/bookmark manager and reading stats renderer.
 *
 * @package Cyberfunk
 */

( function () {
	'use strict';

	var QUEUE_PREFIX = 'cf_queue_';
	var READ_PREFIX  = 'cf_read_';
	var REACT_PREFIX = 'cf_reacted_';

	function getQueue() {
		var queue = [];
		try {
			for ( var i = 0; i < localStorage.length; i++ ) {
				var key = localStorage.key( i );
				if ( key && 0 === key.indexOf( QUEUE_PREFIX ) ) {
					try {
						var item = JSON.parse( localStorage.getItem( key ) );
						if ( item && item.id ) { queue.push( item ); }
					} catch ( e ) {}
				}
			}
		} catch ( e ) {}
		queue.sort( function ( a, b ) { return ( b.queued || 0 ) - ( a.queued || 0 ); } );
		return queue;
	}

	function isQueued( postId ) {
		try { return !! localStorage.getItem( QUEUE_PREFIX + postId ); } catch ( e ) { return false; }
	}

	function addToQueue( data ) {
		try { localStorage.setItem( QUEUE_PREFIX + data.id, JSON.stringify( data ) ); } catch ( e ) {}
	}

	function removeFromQueue( postId ) {
		try { localStorage.removeItem( QUEUE_PREFIX + postId ); } catch ( e ) {}
	}

	function escHtml( str ) {
		return String( str )
			.replace( /&/g, '&amp;' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' )
			.replace( /"/g, '&quot;' );
	}

	function escText( str ) {
		return String( str )
			.replace( /&/g, '&amp;' )
			.replace( /</g, '&lt;' )
			.replace( />/g, '&gt;' );
	}

	( function () {
		var btns = document.querySelectorAll( '.js-queue-btn' );
		if ( ! btns.length ) { return; }

		btns.forEach( function ( btn ) {
			var postId = Math.abs( parseInt( btn.getAttribute( 'data-post-id' ) || '0', 10 ) );
			if ( ! postId ) { return; }

			if ( isQueued( postId ) ) {
				btn.classList.add( 'queued' );
				btn.setAttribute( 'aria-pressed', 'true' );
				btn.setAttribute( 'aria-label', 'Remove from reading list' );
			}

			btn.addEventListener( 'click', function () {
				if ( isQueued( postId ) ) {
					removeFromQueue( postId );
					btn.classList.remove( 'queued' );
					btn.setAttribute( 'aria-pressed', 'false' );
					btn.setAttribute( 'aria-label', 'Add to reading list' );
				} else {
					addToQueue( {
						id:     postId,
						title:  btn.getAttribute( 'data-title' ) || '',
						link:   btn.getAttribute( 'data-link' )  || '',
						time:   parseInt( btn.getAttribute( 'data-time' ) || '0', 10 ),
						thumb:  btn.getAttribute( 'data-thumb' ) || '',
						queued: Date.now(),
					} );
					btn.classList.add( 'queued' );
					btn.setAttribute( 'aria-pressed', 'true' );
					btn.setAttribute( 'aria-label', 'Remove from reading list' );
				}
			} );
		} );
	}() );

	( function () {
		var container = document.getElementById( 'reading-list-container' );
		if ( ! container ) { return; }

		function render() {
			var queue = getQueue();

			if ( ! queue.length ) {
				container.innerHTML =
					'<div class="rl-empty">' +
					'<i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>' +
					'<p>NO_TRANSMISSIONS_QUEUED // YOUR_READING_LIST_IS_EMPTY</p>' +
					'</div>';
				return;
			}

			var html = '<div class="reading-list-grid">';
			queue.forEach( function ( item ) {
				var isRead = false;
				try { isRead = !! localStorage.getItem( READ_PREFIX + item.id ); } catch ( e ) {}

				html += '<div class="rl-item' + ( isRead ? ' rl-item--read' : '' ) + '">';

				if ( item.thumb ) {
					html +=
						'<a href="' + escHtml( item.link ) + '" class="rl-thumb-link" tabindex="-1" aria-hidden="true">' +
						'<img src="' + escHtml( item.thumb ) + '" alt="" class="rl-thumb" loading="lazy">' +
						'</a>';
				}

				html += '<div class="rl-content">';
				if ( isRead ) {
					html += '<span class="rl-read-badge">READ</span>';
				}
				html += '<a href="' + escHtml( item.link ) + '" class="rl-title">' + escText( item.title ) + '</a>';
				if ( item.time ) {
					html += '<span class="rl-time"><i class="fa-solid fa-gauge-high" aria-hidden="true"></i> ' + item.time + ' MIN</span>';
				}
				html += '</div>';

				html +=
					'<button type="button" class="rl-remove" data-post-id="' + escHtml( String( item.id ) ) + '" aria-label="Remove from queue">' +
					'<i class="fa-solid fa-xmark"></i>' +
					'</button>';

				html += '</div>';
			} );
			html += '</div>';

			container.innerHTML = html;

			container.querySelectorAll( '.rl-remove' ).forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					var id = parseInt( btn.getAttribute( 'data-post-id' ), 10 );
					removeFromQueue( id );
					document.querySelectorAll( '.js-queue-btn[data-post-id="' + id + '"]' ).forEach( function ( qb ) {
						qb.classList.remove( 'queued' );
						qb.setAttribute( 'aria-pressed', 'false' );
						qb.setAttribute( 'aria-label', 'Add to reading list' );
					} );
					render(); // Re-render the list.
				} );
			} );
		}

		render();
	}() );

	( function () {
		var container = document.getElementById( 'reading-stats-container' );
		if ( ! container ) { return; }

		var readCount    = 0;
		var reactionMap  = { fire: 0, hype: 0, intel: 0, confused: 0 };
		var reactionTotal = 0;
		var queueCount   = 0;

		try {
			for ( var i = 0; i < localStorage.length; i++ ) {
				var key = localStorage.key( i );
				if ( ! key ) { continue; }

				if ( 0 === key.indexOf( READ_PREFIX ) ) {
					readCount++;
				} else if ( 0 === key.indexOf( REACT_PREFIX ) ) {
					var val = localStorage.getItem( key ) || '';
					if ( reactionMap.hasOwnProperty( val ) ) {
						reactionMap[ val ]++;
					}
					reactionTotal++;
				} else if ( 0 === key.indexOf( QUEUE_PREFIX ) ) {
					queueCount++;
				}
			}
		} catch ( e ) {}

		var html = '<div class="stats-grid">';

		html +=
			'<div class="stat-card">' +
			'<div class="stat-value">' + readCount + '</div>' +
			'<div class="stat-label">TRANSMISSIONS_DECODED</div>' +
			'</div>';

		html +=
			'<div class="stat-card">' +
			'<div class="stat-value">' + reactionTotal + '</div>' +
			'<div class="stat-label">SIGNALS_BROADCAST</div>' +
			'<div class="stat-breakdown">' +
			'<span><i class="fa-solid fa-fire" aria-hidden="true"></i> ' + reactionMap.fire + '</span>' +
			'<span><i class="fa-solid fa-bolt" aria-hidden="true"></i> ' + reactionMap.hype + '</span>' +
			'<span><i class="fa-solid fa-brain" aria-hidden="true"></i> ' + reactionMap.intel + '</span>' +
			'<span><i class="fa-solid fa-circle-question" aria-hidden="true"></i> ' + reactionMap.confused + '</span>' +
			'</div>' +
			'</div>';

		html +=
			'<div class="stat-card">' +
			'<div class="stat-value">' + queueCount + '</div>' +
			'<div class="stat-label">QUEUED_TRANSMISSIONS</div>' +
			'</div>';

		html += '</div>';

		var queue = getQueue();
		if ( queue.length ) {
			html += '<div class="stats-queue-preview"><p class="stats-section-label">QUEUED_FOR_READING</p><ul class="stats-queue-list">';
			queue.slice( 0, 5 ).forEach( function ( item ) {
				var isRead = false;
				try { isRead = !! localStorage.getItem( READ_PREFIX + item.id ); } catch ( e ) {}
				html +=
					'<li class="' + ( isRead ? 'stats-queue-read' : '' ) + '">' +
					'<a href="' + escHtml( item.link ) + '">' + escText( item.title ) + '</a>' +
					( item.time ? ' <span>' + item.time + ' MIN</span>' : '' ) +
					( isRead ? ' <span class="rl-read-badge">READ</span>' : '' ) +
					'</li>';
			} );
			if ( queue.length > 5 ) {
				html += '<li class="stats-queue-more">…and ' + ( queue.length - 5 ) + ' more</li>';
			}
			html += '</ul></div>';
		}

		if ( 0 === readCount && 0 === reactionTotal && 0 === queueCount ) {
			container.innerHTML =
				'<div class="rl-empty">' +
				'<i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>' +
				'<p>NO_ACTIVITY_RECORDED // START_READING_TO_BUILD_YOUR_PROFILE</p>' +
				'</div>';
			return;
		}

		container.innerHTML = html;
	}() );

	( function () {
		function render() {
			var widget = document.getElementById( 'cf-recently-viewed' );
			if ( ! widget ) { return; }

			try {
				var items = JSON.parse( localStorage.getItem( 'cf_history' ) || '[]' );
				if ( 0 === items.length ) {
					widget.innerHTML =
						'<p class="rv-empty">' +
						( widget.getAttribute( 'data-empty' ) || '' ) +
						'</p>';
					return;
				}
				var html = '<ul class="rv-list">';
				items.forEach( function ( p ) {
					html += '<li class="rv-item">';
					if ( p.thumb ) {
						html +=
							'<a href="' + p.url + '" class="rv-thumb-link" tabindex="-1" aria-hidden="true">' +
							'<img src="' + p.thumb + '" alt="" class="rv-thumb" loading="lazy">' +
							'</a>';
					}
					html += '<div class="rv-info">';
					html += '<a href="' + p.url + '" class="rv-title">' + p.title + '</a>';
					if ( p.time ) {
						html += '<span class="rv-time">' + p.time + ' MIN READ</span>';
					}
					html += '</div></li>';
				} );
				html += '</ul>';
				widget.innerHTML = html;
			} catch ( e ) {}
		}

		if ( 'loading' === document.readyState ) {
			document.addEventListener( 'DOMContentLoaded', render );
		} else {
			render();
		}
	}() );

}() );

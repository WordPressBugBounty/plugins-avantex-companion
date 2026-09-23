/**
 * Avantex Extras — AJAX handler for plugin/theme actions.
 *
 * Uses vanilla JS (no jQuery dependency). Delegates click events from the
 * card grid via data-attributes: data-slug and data-action.
 *
 * @package avantex
 */

( function () {
	'use strict';

	/**
	 * Show a dismissible notice at the top of the page.
	 *
	 * @param {string} message  Notice text.
	 * @param {string} type     'success' | 'error' | 'info'.
	 */
	function showNotice( message, type ) {
		var notice = document.getElementById( 'avantex-extras-notice' );
		if ( ! notice ) {
			return;
		}

		notice.textContent = message;
		notice.className   = 'avantex-extras-notice avantex-extras-notice--' + type;
		notice.hidden      = false;

		// Auto-dismiss after 5 seconds.
		setTimeout( function () {
			notice.hidden = true;
		}, 5000 );
	}

	/**
	 * Send an AJAX request to wp-admin/admin-ajax.php.
	 *
	 * @param {string}      slug   Plugin or theme slug.
	 * @param {string}      action AJAX action name.
	 * @param {HTMLElement}  btn    The button that was clicked.
	 */
	function sendRequest( slug, action, btn ) {

		var originalLabel = btn.textContent;

		// Disable and show progress.
		btn.disabled    = true;
		btn.textContent = 'Processing…';
		btn.classList.add( 'avantex-extras-btn--loading' );

		var body = new FormData();
		body.append( 'action', action );
		body.append( 'slug', slug );
		body.append( 'nonce', avantexExtras.nonce );

		fetch( avantexExtras.ajaxUrl, {
			method:      'POST',
			credentials: 'same-origin',
			body:        body,
		} )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( data ) {
				if ( data.success ) {
					showNotice( data.data.message || 'Done!', 'success' );
					btn.textContent = 'Done ✓';
					btn.classList.remove( 'avantex-extras-btn--loading' );
					btn.classList.add( 'avantex-extras-btn--success' );

					// Reload after a short delay so the user sees the notice.
					setTimeout( function () {
						window.location.reload();
					}, 1500 );
				} else {
					showNotice( data.data.message || 'Something went wrong.', 'error' );
					btn.textContent = originalLabel;
					btn.disabled    = false;
					btn.classList.remove( 'avantex-extras-btn--loading' );
				}
			} )
			.catch( function () {
				showNotice( 'Network error — please try again.', 'error' );
				btn.textContent = originalLabel;
				btn.disabled    = false;
				btn.classList.remove( 'avantex-extras-btn--loading' );
			} );
	}

	/* ── Delegated click handler ── */

	document.addEventListener( 'DOMContentLoaded', function () {

		var loader = document.getElementById( 'avantex-extras-loader' );
		var pluginsGrid = document.querySelector( '#avantex-extras-plugins .avantex-extras-grid' );
		var themesGrid = document.querySelector( '#avantex-extras-themes .avantex-extras-grid' );

		// Load extras data via AJAX.
		if ( pluginsGrid && themesGrid ) {
			var body = new FormData();
			body.append( 'action', 'avantex_extras_get_data' );
			body.append( 'nonce', avantexExtras.nonce );

			fetch( avantexExtras.ajaxUrl, {
				method:      'POST',
				credentials: 'same-origin',
				body:        body,
			} )
				.then( function ( response ) {
					return response.json();
				} )
				.then( function ( data ) {
					if ( data.success && data.data ) {
						pluginsGrid.innerHTML = data.data.plugins || '';
						themesGrid.innerHTML = data.data.themes || '';
					} else {
						showNotice( 'Failed to load recommended plugins and themes.', 'error' );
					}

					// Hide loader
					if ( loader ) {
						loader.classList.add( 'avantex-extras-loader--hidden' );
						loader.addEventListener( 'transitionend', function () {
							loader.remove();
						} );
					}
				} )
				.catch( function () {
					showNotice( 'Network error while loading data.', 'error' );
					if ( loader ) {
						loader.classList.add( 'avantex-extras-loader--hidden' );
						loader.addEventListener( 'transitionend', function () {
							loader.remove();
						} );
					}
				} );
		} else {
			// Fallback: hide loader if grids are not found.
			if ( loader ) {
				loader.classList.add( 'avantex-extras-loader--hidden' );
				loader.addEventListener( 'transitionend', function () {
					loader.remove();
				} );
			}
		}

		// Tabs switching logic
		var tabButtons = document.querySelectorAll( '.avantex-extras-tab-btn' );
		var sections = document.querySelectorAll( '.avantex-extras-section' );

		tabButtons.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var targetId = btn.getAttribute( 'data-target' );
				var targetSection = document.getElementById( targetId );

				if ( ! targetSection ) {
					return;
				}

				// Deactivate all tabs and hide all sections
				tabButtons.forEach( function ( b ) {
					b.classList.remove( 'avantex-extras-tab-btn--active' );
				} );
				sections.forEach( function ( s ) {
					s.classList.remove( 'avantex-extras-section--active' );
				} );

				// Activate current tab and section
				btn.classList.add( 'avantex-extras-tab-btn--active' );
				targetSection.classList.add( 'avantex-extras-section--active' );
			} );
		} );

		var wrap = document.querySelector( '.avantex-extras-wrap' );
		if ( ! wrap ) {
			return;
		}

		wrap.addEventListener( 'click', function ( e ) {

			var btn = e.target.closest( 'button[data-action]' );
			if ( ! btn || btn.disabled ) {
				return;
			}

			var slug   = btn.getAttribute( 'data-slug' );
			var action = btn.getAttribute( 'data-action' );

			if ( slug && action ) {
				sendRequest( slug, action, btn );
			}
		} );
	} );
} )();

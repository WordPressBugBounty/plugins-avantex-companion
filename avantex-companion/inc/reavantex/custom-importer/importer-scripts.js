/**
 * AJAX Engine & UI Handlers for Avantex Custom Demo Importer.
 * 
 * @package avantex
 * @since 1.1.0
 */

jQuery(document).ready(function($) {
	'use strict';

	// ==========================================
	// 1. LIVE SEARCH & CATEGORY FILTER TABS
	// ==========================================
	var $searchVal = '';
	var $filterVal = 'all';

	function filterDemos() {
		var search = $searchVal.toLowerCase().trim();

		$('.demo-card').each(function() {
			var $card = $(this);
			var name = $card.find('h3').text().toLowerCase();
			var category = $card.data('category');

			var matchesSearch = name.indexOf(search) > -1;
			var matchesFilter = ($filterVal === 'all' || category === $filterVal);

			if (matchesSearch && matchesFilter) {
				$card.fadeIn(300);
			} else {
				$card.fadeOut(200);
			}
		});
	}

	// Live Search Input Keyup
	$('#demo-search-input').on('keyup', function() {
		$searchVal = $(this).val();
		filterDemos();
	});

	// Category Tabs Filtering
	$('.filter-tab').on('click', function() {
		var $tab = $(this);
		$('.filter-tab').removeClass('active');
		$tab.addClass('active');

		$filterVal = $tab.data('filter');
		filterDemos();
	});


	// ==========================================
	// 2. DYNAMIC AJAX SEQUENTIAL IMPORT ENGINE
	// ==========================================
	var activeDemoSlug = '';
	var activeDemoName = '';
	var isManualUpload = false;

	// Trigger Import Action Click
	$('.btn-import').on('click', function(e) {
		e.preventDefault();

		var $btn = $(this);
		activeDemoSlug = $btn.data('slug');
		activeDemoName = $btn.data('name');
		isManualUpload = false;

		if (!activeDemoSlug) {
			return;
		}

		// Initialize Modal
		$('#modal-demo-name').text(activeDemoName);
		resetImporterModal();
		$('#avantex-import-overlay').fadeIn(400);

		// Step 1: Install and activate plugins
		runPluginsPhase();
	});

	// Reset Importer Modal UI Elements
	function resetImporterModal() {
		$('#progress-bar-fill').css('width', '0%');
		$('#progress-percent').text('0%');

		$('.import-step').removeClass('active completed');
		$('.import-step .step-status').removeClass('dashicons-yes-alt dashicons-ellipsis').addClass('dashicons-ellipsis');

		$('#modal-success-state').hide();
		$('.upload-loader-text').remove();
	}

	// Step 1: Plugins Phase
	function runPluginsPhase() {
		var $step = $('#step-plugins');
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_import_plugins',
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
					updateProgressBar(10);

					// Proceed to Download Phase
					runDownloadPhase();
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Step 2: Download & Deploy Zip Package Phase
	function runDownloadPhase() {
		var $step = $('#step-download');
		$step.addClass('active');

		if (isManualUpload) {
			$step.removeClass('active').addClass('completed');
			$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
			updateProgressBar(25);

			// Proceed to XML Import Phase
			runXmlPhase(0);
			return;
		}

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_download_package',
				demo: activeDemoSlug,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
					updateProgressBar(25);

					// Proceed to XML Import Phase
					runXmlPhase(0);
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Step 3: Content XML Chunked Phase
	function runXmlPhase(offset) {
		var $step = $('#step-xml');
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_import_xml_chunk',
				demo: activeDemoSlug,
				offset: offset,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					var data = response.data;
					if (data.status === 'importing') {
						// XML Import is in progress. Map XML progress (0% - 100%) to global progress (25% - 75%)
						var xmlPercent = data.progress;
						var globalPercent = 25 + Math.round((xmlPercent / 100) * 50);
						updateProgressBar(globalPercent);

						// Loop step recursively
						runXmlPhase(data.offset);
					} else if (data.status === 'done') {
						// XML Import Complete
						$step.removeClass('active').addClass('completed');
						$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
						updateProgressBar(75);

						// Proceed to Customizer Phase
						runCustomizerPhase();
					}
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Step 3: Customizer DAT Phase
	function runCustomizerPhase() {
		var $step = $('#step-customizer');
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_import_customizer',
				demo: activeDemoSlug,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
					updateProgressBar(85);

					// Proceed to Widgets Phase
					runWidgetsPhase();
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Step 4: Widgets WIE Phase
	function runWidgetsPhase() {
		var $step = $('#step-widgets');
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_import_widgets',
				demo: activeDemoSlug,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
					updateProgressBar(92);

					// Proceed to Finalize Layout Phase
					runFinalizePhase();
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Step 5: Finalization Phase
	function runFinalizePhase() {
		var $step = $('#step-finalize');
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_import_finalize',
				demo: activeDemoSlug,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');
					updateProgressBar(100);

					// Trigger Success Modal Screen with slideDown/fadeIn
					setTimeout(function() {
						$('#modal-success-state').slideDown(500);
					}, 400);
				} else {
					handleImportError(response.data.message || avantexImporterAjax.messages.error);
				}
			},
			error: function() {
				handleImportError(avantexImporterAjax.messages.error);
			}
		});
	}

	// Helper to Update Progress Bar Width and Value
	function updateProgressBar(percentage) {
		$('#progress-bar-fill').css('width', percentage + '%');
		$('#progress-percent').text(percentage + '%');
	}

	// Handle and alert any AJAX processing error
	function handleImportError(message) {
		$('.import-step.active').removeClass('active').css('color', '#ff3860');
		alert('Import Failed: ' + message);
		$('#avantex-import-overlay').fadeOut(400);
	}

	// Close Modal triggers
	$('#btn-close-modal').on('click', function() {
		$('#avantex-import-overlay').fadeOut(400, function() {
			location.reload();
		});
	});

	// Custom ZIP Manual Upload handler
	$('#manual-zip-upload').on('change', function(e) {
		var file = e.target.files[0];
		if (!file) {
			return;
		}

		var $input = $(this);
		var formData = new FormData();
		formData.append('action', 'avantex_upload_custom_zip');
		formData.append('demo_zip', file);
		formData.append('security', avantexImporterAjax.security);

		// Initialize Modal
		activeDemoSlug = '';
		activeDemoName = file.name.replace(/\.[^/.]+$/, ""); // Strip extension
		isManualUpload = true;

		$('#modal-demo-name').text(activeDemoName);
		resetImporterModal();
		$('#avantex-import-overlay').fadeIn(400);

		var $step = $('#step-plugins');
		$step.addClass('active');
		$step.append('<span class="upload-loader-text" style="color: var(--accent-color); font-size:12px; margin-left: 5px;">(Uploading ZIP...)</span>');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				$('.upload-loader-text').remove();
				if (response.success) {
					activeDemoSlug = response.data.slug;
					activeDemoName = response.data.name;
					$('#modal-demo-name').text(activeDemoName);

					// Clear input value
					$input.val('');

					// Proceed to Step 1: Plugins phase
					runPluginsPhase();
				} else {
					$input.val('');
					handleImportError(response.data.message || 'Failed to upload custom ZIP.');
				}
			},
			error: function() {
				$('.upload-loader-text').remove();
				$input.val('');
				handleImportError('Error uploading ZIP file.');
			}
		});
	});


	// ==========================================
	// 3. THEME RESET ENGINE
	// ==========================================

	var resetPhases = [
		{ key: 'backup',     stepId: 'reset-step-backup' },
		{ key: 'posts',      stepId: 'reset-step-posts' },
		{ key: 'attachments', stepId: 'reset-step-attachments' },
		{ key: 'nav_menus',  stepId: 'reset-step-menus' },
		{ key: 'terms',      stepId: 'reset-step-terms' },
		{ key: 'customizer', stepId: 'reset-step-customizer' },
		{ key: 'widgets',    stepId: 'reset-step-widgets' },
		{ key: 'options',    stepId: 'reset-step-options' },
		{ key: 'cleanup',    stepId: 'reset-step-cleanup' }
	];
	var resetPhaseIndex = 0;
	var resetDemoSlug = '';
	var resetBackupFile = '';
	var isPreImportReset = false;
	var pendingImportSlug = '';
	var pendingImportName = '';

	// Open reset confirmation modal
	$('#avantex-reset-btn').on('click', function() {
		var $scope = $('#reset-demo-scope');
		resetDemoSlug = $scope.length ? $scope.val() : '';
		isPreImportReset = false;

		var scopeText = resetDemoSlug
			? 'Scope: Resetting only "' + resetDemoSlug.replace(/-/g, ' ') + '" demo content.'
			: 'Scope: Full reset — ALL demo content from all imports will be removed.';

		$('#reset-scope-label').text(scopeText);
		$('#reset-confirm-text').val('');
		$('#reset-confirm-btn').prop('disabled', true);
		$('#reset-confirm-screen').show();
		$('#reset-progress-screen').hide();
		$('#avantex-reset-overlay').fadeIn(400);

		setTimeout(function() { $('#reset-confirm-text').focus(); }, 500);
	});

	// Enable confirm button only when "RESET" is typed
	$('#reset-confirm-text').on('keyup input', function() {
		var val = $(this).val().trim().toUpperCase();
		$('#reset-confirm-btn').prop('disabled', val !== 'RESET');
	});

	// Cancel reset
	$('#reset-cancel-btn').on('click', function() {
		$('#avantex-reset-overlay').fadeOut(400);
		isPreImportReset = false;
		pendingImportSlug = '';
		pendingImportName = '';
	});

	// Execute reset
	$('#reset-confirm-btn').on('click', function() {
		$(this).prop('disabled', true);
		$('#reset-confirm-screen').slideUp(300, function() {
			$('#reset-progress-screen').slideDown(400);
		});

		// Reset all step icons
		$('#reset-progress-screen .import-step').removeClass('active completed');
		$('#reset-progress-screen .import-step .step-status')
			.removeClass('dashicons-yes-alt')
			.addClass('dashicons-ellipsis');
		$('#reset-success-state').hide();
		$('#reset-progress-fill').css('width', '0%');
		$('#reset-progress-percent').text('0%');

		resetPhaseIndex = 0;
		resetBackupFile = '';
		runResetPhase();
	});

	function runResetPhase() {
		if (resetPhaseIndex >= resetPhases.length) {
			// All phases complete — show success
			updateResetProgress(100);
			setTimeout(function() {
				if (resetBackupFile) {
					$('#reset-backup-note').html(
						'<span class="dashicons dashicons-media-text" style="vertical-align:middle; margin-right:4px;"></span>' +
						'Backup saved: <strong>wp-content/uploads/avantex-reset-backups/' + resetBackupFile + '</strong>'
					);
				}
				// If this was a pre-import reset, auto-proceed to import
				if (isPreImportReset && pendingImportSlug) {
					$('#reset-success-state').find('h3').text('Reset Complete!');
					$('#reset-success-state').find('p').first().text('Now importing Demo, please wait...');
					$('#reset-success-state').find('.success-buttons').hide();
					$('#reset-success-state').slideDown(500);

					setTimeout(function() {
						$('#avantex-reset-overlay').fadeOut(300);
						// Trigger the actual import
						activeDemoSlug = pendingImportSlug;
						activeDemoName = pendingImportName;
						isManualUpload = false;
						isPreImportReset = false;
						pendingImportSlug = '';
						pendingImportName = '';

						$('#modal-demo-name').text(activeDemoName);
						resetImporterModal();
						$('#avantex-import-overlay').fadeIn(400);
						runPluginsPhase();
					}, 1500);
				} else {
					$('#reset-success-state').slideDown(500);
				}
			}, 400);
			return;
		}

		var phase = resetPhases[resetPhaseIndex];
		var $step = $('#' + phase.stepId);
		$step.addClass('active');

		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_theme_reset',
				phase: phase.key,
				demo_slug: resetDemoSlug,
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success) {
					$step.removeClass('active').addClass('completed');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-yes-alt');

					// Capture backup filename if returned
					if (response.data && response.data.backup_file) {
						resetBackupFile = response.data.backup_file;
					}

					updateResetProgress(Math.round(((resetPhaseIndex + 1) / resetPhases.length) * 100));
					resetPhaseIndex++;
					runResetPhase();
				} else {
					$step.removeClass('active').css('color', '#ff3860');
					$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-no');
					alert('Reset error at phase "' + phase.key + '": ' + (response.data ? response.data.message : 'Unknown error'));
				}
			},
			error: function() {
				$step.removeClass('active').css('color', '#ff3860');
				$step.find('.step-status').removeClass('dashicons-ellipsis').addClass('dashicons-no');
				alert('AJAX error during reset phase: ' + phase.key);
			}
		});
	}

	function updateResetProgress(pct) {
		$('#reset-progress-fill').css('width', pct + '%');
		$('#reset-progress-percent').text(pct + '%');
	}


	// ==========================================
	// 4. PRE-IMPORT RESET (Auto-reset before importing a new demo)
	// ==========================================

	// Override the import button click to check for existing demo content first
	$('.btn-import').off('click').on('click', function(e) {
		e.preventDefault();

		var $btn = $(this);
		var slug = $btn.data('slug');
		var name = $btn.data('name');

		if (!slug) {
			return;
		}

		// Check if there's existing demo content
		$.ajax({
			url: avantexImporterAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'avantex_reset_status',
				demo_slug: '',
				security: avantexImporterAjax.security
			},
			success: function(response) {
				if (response.success && response.data.counts && response.data.counts.total > 0) {
					// Demo content exists — show custom pre-import options modal
					$('#pre-import-desc').text(
						'Existing demo content detected (' + response.data.counts.total + ' items). ' +
						'Do you want to reset the existing demo before importing "' + name + '"?'
					);
					
					// Store data for modal buttons
					$('#btn-pre-import-reset').data('slug', slug).data('name', name);
					$('#btn-pre-import-continue').data('slug', slug).data('name', name);
					
					$('#avantex-pre-import-overlay').fadeIn(400);
					return;
				}

				// No demo content or user chose to skip reset — proceed directly
				activeDemoSlug = slug;
				activeDemoName = name;
				isManualUpload = false;

				$('#modal-demo-name').text(activeDemoName);
				resetImporterModal();
				$('#avantex-import-overlay').fadeIn(400);
				runPluginsPhase();
			},
			error: function() {
				// On error checking status, just proceed with import
				activeDemoSlug = slug;
				activeDemoName = name;
				isManualUpload = false;

				$('#modal-demo-name').text(activeDemoName);
				resetImporterModal();
				$('#avantex-import-overlay').fadeIn(400);
				runPluginsPhase();
			}
		});
	});

	// Pre-Import Options: Reset first then continue import
	$('#btn-pre-import-reset').on('click', function() {
		$('#avantex-pre-import-overlay').fadeOut(400);
		
		var slug = $(this).data('slug');
		var name = $(this).data('name');
		
		// Set up pre-import reset
		isPreImportReset = true;
		pendingImportSlug = slug;
		pendingImportName = name;
		resetDemoSlug = ''; // Full reset

		$('#reset-scope-label').text('Pre-import reset: Cleaning all existing demo content before importing "' + name + '".');
		$('#reset-confirm-text').val('');
		$('#reset-confirm-btn').prop('disabled', true);
		$('#reset-confirm-screen').show();
		$('#reset-progress-screen').hide();
		$('#avantex-reset-overlay').fadeIn(400);

		setTimeout(function() { $('#reset-confirm-text').focus(); }, 500);
	});

	// Pre-Import Options: Import on top of existing
	$('#btn-pre-import-continue').on('click', function() {
		$('#avantex-pre-import-overlay').fadeOut(400);
		
		var slug = $(this).data('slug');
		var name = $(this).data('name');
		
		activeDemoSlug = slug;
		activeDemoName = name;
		isManualUpload = false;

		$('#modal-demo-name').text(activeDemoName);
		resetImporterModal();
		$('#avantex-import-overlay').fadeIn(400);
		runPluginsPhase();
	});

	// Pre-Import Options: Cancel
	$('#btn-pre-import-cancel').on('click', function() {
		$('#avantex-pre-import-overlay').fadeOut(400);
	});
});

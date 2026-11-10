/**
 * Webcasata Customizer live preview.
 * Updates CSS custom properties for postMessage settings.
 */
( function () {
	'use strict';

	if ( typeof wp === 'undefined' || ! wp.customize ) {
		return;
	}

	var cssVars = {
		webcasata_color_primary: '--wc-color-primary',
		webcasata_color_secondary: '--wc-color-secondary',
		webcasata_color_tertiary: '--wc-color-tertiary',
		webcasata_color_text: '--wc-color-text',
		webcasata_color_link: '--wc-color-link',
		webcasata_color_bg: '--wc-color-bg',
		webcasata_color_header_bg: '--wc-color-header-bg',
		webcasata_color_footer_bg: '--wc-color-footer-bg',
		webcasata_color_footer_text: '--wc-color-footer-text',
		webcasata_container_width: '--wc-container-width',
		webcasata_font_size_base: '--wc-font-size-base',
		webcasata_line_height: '--wc-line-height',
		webcasata_btn_radius: '--wc-btn-radius',
		webcasata_btn_padding_x: '--wc-btn-padding-x',
		webcasata_btn_padding_y: '--wc-btn-padding-y'
	};

	var root = document.documentElement;

	var units = { webcasata_container_width: 'px', webcasata_font_size_base: 'px', webcasata_btn_radius: 'px', webcasata_btn_padding_x: 'px', webcasata_btn_padding_y: 'px' };

	Object.keys( cssVars ).forEach( function ( settingId ) {
		wp.customize( settingId, function ( value ) {
			value.bind( function ( to ) {
				var unit = units[ settingId ] || '';
				root.style.setProperty( cssVars[ settingId ], to + unit );
			} );
		} );
	} );
} )();

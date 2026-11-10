=== Webcasata Theme ===
Contributors: webcasata
Requires at least: 5.9
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, e-commerce, one-column, custom-background, custom-colors, custom-header, custom-logo, custom-menu, editor-style, featured-images, footer-widgets, sticky-post, threaded-comments, translation-ready, wide-blocks, block-styles, block-patterns, theme-options

A secure, lightweight and flexible starter theme for brochure sites, blogs and WooCommerce stores.

== Description ==

Webcasata Theme is a lightweight classic theme for brochure sites, blogs and online stores.

* Global settings in the Customizer: layout, colors, typography, header layout, buttons and footer.
* Settings are output as CSS custom properties, with live preview.
* Three widget areas: Header, Content and Footer (one to four columns).
* Custom logo, custom header image, custom background and three menu locations.
* Custom block styles (Card, Rounded with shadow, Checklist, Accent border, Short accent) and block patterns.
* Optional features you switch on only when needed: top bar, sticky header, scroll to top button, breadcrumbs, post excerpts and more.
* WooCommerce support that loads only when WooCommerce is active.
* Settings import and export under Appearance > Webcasata Import/Export.
* SCSS sources are included next to the compiled CSS.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme, choose the theme ZIP file and click Install Now.
3. Click Activate to use your new theme right away.
4. Go to Appearance > Customize > Webcasata Global Settings to configure the theme.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

Webcasata Theme includes support for WooCommerce.

= How do I rebuild the CSS? =

Run `npm install` and then `npm run build` in the theme folder. The SCSS sources are in assets/css/.

= Does the theme load external resources? =

Only if you choose a Google Font in Customizer > Typography. With the default "System Default" fonts the theme makes no external requests.

== Changelog ==

= 1.0.1 =
* Changed the text domain to webcasata-theme to match the theme slug.
* Removed the generator meta tag removal (plugin territory).
* Every Customizer setting now has a sanitization callback.
* Imported settings are sanitized with the same rules as the Customizer.
* Custom JavaScript can only be saved by users with the unfiltered_html capability.
* Added custom header and custom background support.
* Added block styles and block patterns.
* Added styles for .sticky, .gallery-caption and .bypostauthor.
* Maintenance page now uses the core document title.
* Breadcrumb separators are now displayed.
* Button radius can now be set to 0.
* The theme script uses the core defer loading strategy.
* Added readme.txt, screenshot and translation template.

= 1.0.0 =
* Initial release.

== Copyright ==

Webcasata Theme WordPress Theme, Copyright 2026 Webcasata
Webcasata Theme is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Resources ==

* Screenshot, Copyright 2026 Webcasata
  License: GPLv2 or later, https://www.gnu.org/licenses/gpl-2.0.html
  Source: original screenshot of the theme, contains no third-party images.

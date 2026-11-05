# Avantex Companion Plugin

**Avantex Companion** is the official companion plugin for Avantex and ReAvantex WordPress themes. It provides extended customizer repeater controls, frontpage section rendering, page templates, native starter site demo importer/exporter, and default content provisioning.

---

## Features

- **Front Page Sections:** Complete control over 10 homepage sections (Slider, About, Services, Portfolio, Callout, Team, Testimonials, Funfacts, News, Sponsors) with drag-and-drop ordering.
- **Native Starter Site Importer:** 1-click custom demo importer & exporter with XML, DAT, and WIE support (no external heavy plugins required).
- **Rich Customizer Repeaters:** High-performance dynamic repeater controls with font, color, and layout customizers.
- **Custom Page Templates:** About Us, Services, Portfolio, FAQ, Contact Us, Terms of Service, Privacy Policy, and Unified Blog Template.
- **Default Content & Menu Architecture:** Automated creation and binding of Header, Footer, and Services navigation menus.

---

## Installation

1. Upload the `avantex-companion` folder to your `/wp-content/plugins/` directory (or upload the `avantex-companion.zip` file via **Plugins > Add New > Upload Plugin**).
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Access **Appearance > ReAvantex Demo Import** to import starter sites or configure frontpage sections in **Appearance > Customize**.

---

## Changelog

### Version 0.2.8
- Integrated custom page template Customizer settings directly into the companion plugin.
- Added 16-item maximum limits across all template repeater controls.
- Fixed Customizer sanitization callbacks to use core WordPress functions and protected repeater defaults with PHP 8 constant existence checks.

### Version 0.2.7
- Updated compatibility for WordPress 7.1.2 and PHP 8.4.
- Enhanced Avantex Blog Template with dynamic layout, column controls, and sidebar fallback bridging.
- Improved pagination calculation and query parameters handling.

### Version 0.2.6
- Integrated native custom demo importer, exporter, and extras modules for ReAvantex.
- Added automated provisioning of Header, Footer, and Services menus.
- Enhanced widget and menu location binding upon demo import.
- Updated compatibility for WordPress 6.8 and PHP 8.0+.

---

## License

GPLv3 or later — see [license.txt](license.txt) for details.

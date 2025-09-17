# hmcoders Elementor Addon

A comprehensive Elementor addon plugin featuring 5 fully dynamic and customizable widgets to enhance your page building experience.

## Description

The hmcoders Elementor Addon is a powerful collection of dynamic widgets designed specifically for WordPress users who want to create stunning websites with Elementor. This plugin provides 5 unique, fully-featured widgets that are both user-friendly and highly customizable.

## Features

- **5 Dynamic Widgets**: Each widget is fully dynamic with extensive customization options
- **PHP Class-Based Architecture**: Clean, maintainable code following WordPress standards
- **Responsive Design**: All widgets are mobile-friendly and responsive
- **Modern UI/UX**: Beautiful, modern designs that enhance user experience
- **Performance Optimized**: Lightweight code with efficient loading
- **Accessibility Ready**: WCAG compliant and keyboard navigable
- **Cross-Browser Compatible**: Works seamlessly across all major browsers

## Included Widgets

### 1. Dynamic Post Grid
**Purpose**: Display your WordPress posts in an attractive grid layout

**Features**:
- Customizable columns (1-4)
- Multiple post types support
- Featured image toggle
- Excerpt length control
- Meta information display
- Advanced styling options

### 2. Advanced Team Member
**Purpose**: Showcase your team members with style

**Features**:
- Multiple layout styles (Image Top, Image Left, Overlay)
- Social media links with custom icons
- Responsive image sizing
- Hover effects and animations
- Custom positioning and descriptions
- Typography controls

### 3. Pricing Table Pro
**Purpose**: Create compelling pricing tables for your services

**Features**:
- Featured/popular plan highlighting
- Unlimited features list
- Custom currency and pricing
- Strike-through original pricing
- Hover effects and animations
- Call-to-action buttons
- Icon support for features

### 4. Testimonial Carousel
**Purpose**: Display customer testimonials in an interactive carousel

**Features**:
- Responsive carousel functionality
- Star ratings system
- Client photos and information
- Autoplay with customizable speed
- Navigation arrows and dots
- Smooth transitions
- Touch/swipe support

### 5. Interactive Timeline
**Purpose**: Create engaging timelines for your content

**Features**:
- Vertical and horizontal layouts
- Scroll-based animations
- Custom icons and dates
- Image support
- Multiple alignment options
- Responsive design
- Link support for timeline items

## Installation

### Automatic Installation
1. Go to your WordPress admin dashboard
2. Navigate to **Plugins > Add New**
3. Search for "hmcoders Elementor Addon"
4. Click **Install Now** and then **Activate**

### Manual Installation
1. Download the plugin zip file
2. Go to **Plugins > Add New > Upload Plugin**
3. Choose the zip file and click **Install Now**
4. Activate the plugin

### From Source
1. Download or clone this repository
2. Upload the `hmcoders-elementor-addon` folder to your `/wp-content/plugins/` directory
3. Activate the plugin through the WordPress admin

## Requirements

- **WordPress**: 5.0 or higher
- **PHP**: 7.4 or higher
- **Elementor**: 3.0.0 or higher
- **Memory**: 64MB minimum (128MB recommended)

## Usage

1. **Install and activate** both Elementor and hmcoders Elementor Addon
2. **Edit any page** with Elementor
3. **Look for the "hmcoders Elements" category** in the widget panel
4. **Drag and drop** any of the 5 widgets to your page
5. **Customize** using the extensive options in the left panel
6. **Preview and publish** your page

## Widget Categories

All widgets are organized under the **"hmcoders Elements"** category in the Elementor widget panel for easy access.

## Customization Options

Each widget includes extensive customization options:

- **Content Settings**: Control all text, images, and links
- **Layout Options**: Choose from multiple display styles
- **Styling Controls**: Comprehensive typography, colors, and spacing
- **Animation Effects**: Smooth hover and scroll animations
- **Responsive Settings**: Mobile-specific customizations

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Performance

The plugin is optimized for performance with:
- Minified CSS and JavaScript
- Conditional loading of assets
- Efficient DOM manipulation
- Optimized database queries
- Image lazy loading support

## Accessibility

The plugin follows WCAG 2.1 guidelines:
- Keyboard navigation support
- Screen reader compatibility
- Proper ARIA labels
- High contrast support
- Focus management

## Developer Information

- **Developer**: hmcoders
- **Version**: 1.0.0
- **License**: GPL v2 or later
- **Text Domain**: hmcoders-elementor-addon

## File Structure

```
hmcoders-elementor-addon/
├── hmcoders-elementor-addon.php    # Main plugin file
├── assets/
│   ├── css/
│   │   └── style.css               # Frontend styles
│   └── js/
│       └── frontend.js             # Frontend scripts
├── widgets/
│   ├── dynamic-post-grid.php       # Post Grid widget
│   ├── advanced-team-member.php    # Team Member widget
│   ├── pricing-table-pro.php       # Pricing Table widget
│   ├── testimonial-carousel.php    # Testimonial Carousel widget
│   └── interactive-timeline.php    # Timeline widget
├── languages/                      # Translation files
└── README.md                       # This file
```

## Hooks and Filters

The plugin provides several hooks for developers:

### Actions
- `hmcoders_elementor_addon_loaded` - Fired when plugin is fully loaded
- `hmcoders_widget_before_render` - Before widget rendering
- `hmcoders_widget_after_render` - After widget rendering

### Filters
- `hmcoders_widget_settings` - Modify widget settings
- `hmcoders_default_styles` - Modify default styles
- `hmcoders_widget_output` - Modify widget output

## Troubleshooting

### Common Issues

**Widgets not appearing in Elementor**
- Ensure Elementor is installed and activated
- Check PHP version (7.4+ required)
- Verify plugin activation

**Styles not loading**
- Clear any caching plugins
- Check file permissions
- Verify asset URLs are correct

**JavaScript not working**
- Check browser console for errors
- Ensure jQuery is loaded
- Verify no plugin conflicts

## Support

For support and questions:
1. Check the documentation above
2. Review common issues
3. Contact hmcoders support team at support@hmcoders.com

## Changelog

### Version 1.0.0
- Initial release
- 5 dynamic widgets included
- Full Elementor integration
- Responsive design implementation
- Accessibility features added

## Contributing

We welcome contributions! Please:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This plugin is licensed under the GPL v2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Credits

Developed by hmcoders team with ❤️ for the WordPress community.

---

**Note**: This plugin requires Elementor to function. Make sure you have Elementor installed and activated before using this addon.
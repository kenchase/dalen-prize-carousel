# Dalen Prize Carousel

A custom WordPress plugin for displaying prize information in a horizontal scrolling carousel format with ACF integration. Developed by Ken Chase for Dalen Design.

## Features

- 🎠 **Horizontal Scrolling Carousel** - Smooth card-by-card navigation
- 🎯 **ACF Integration** - Fully integrated with Advanced Custom Fields
- ⌨️ **Keyboard Navigation** - Arrow key support for accessibility
- 📱 **Mobile Friendly** - Touch scrolling and responsive design
- 🎨 **BEM CSS Architecture** - Clean, maintainable CSS structure
- ⚡ **Vanilla JavaScript** - No external dependencies
- 🔧 **Divi Compatible** - Works seamlessly with Divi themes

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Advanced Custom Fields (ACF) plugin

## Installation

1. Download or clone this repository
2. Upload the `dalen-prize-carousel` folder to your `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Ensure Advanced Custom Fields is installed and activated

## Setup

### 1. Create Custom Post Type

Use ACF to create a custom post type called `prize` (or update the post type name in the plugin code).

### 2. Create ACF Fields

Set up the following ACF fields for your prize post type:

- `prize_title` (Text) - Main prize title
- `prize_sub_title` (Text) - Prize subtitle
- `prize_image` (Image) - Prize image
- `prize_sponsor_name` (Text) - Sponsor name
- `prize_value` (Text) - Prize value
- `prize_cta_label` (Text) - Call-to-action button text
- `prize_cta_link` (URL) - Call-to-action button link

### 3. Update Post Type Name

If you use a different post type name, update line 147 in `dalen-prize-carousel.php`:

```php
'post_type' => 'your_post_type_name', // Update this line
```

## Usage

### Shortcode

Display the carousel anywhere using the shortcode:

```php
[prize_carousel]
```

### Shortcode Attributes

- `slides_to_show` - Number of slides to show (default: 3)
- `show_arrows` - Show navigation arrows (default: true)

```php
[prize_carousel slides_to_show="4" show_arrows="false"]
```

### Template Function

Use in theme files:

```php
<?php echo dpc_render_carousel(); ?>

// With attributes
<?php echo dpc_render_carousel(['slides_to_show' => 4]); ?>
```

## File Structure

```
dalen-prize-carousel/
├── dalen-prize-carousel.php    # Main plugin file
├── assets/
│   ├── css/
│   │   └── carousel.css        # Carousel styles
│   └── js/
│       └── carousel.js         # Carousel functionality
├── languages/                  # Translation files (future)
├── README.md
└── .gitignore
```

## Customization

### CSS Customization

The carousel uses BEM naming convention. Key CSS classes:

- `.dpc-carousel-container` - Main container
- `.dpc-carousel-nav__btn` - Navigation buttons
- `.dpc-prize-card` - Individual prize cards
- `.dpc-prize-header` - Prize title area
- `.dpc-prize-image` - Prize image container
- `.dpc-prize-meta` - Prize metadata (sponsor, value)
- `.dpc-prize-cta__button` - Call-to-action button

### JavaScript Customization

The carousel class provides public methods:

```javascript
// Get carousel instance
const carousel = new DalenPrizeCarousel(container);

// Navigate to specific card
carousel.goToCard(2);

// Get current card index
const currentIndex = carousel.getCurrentIndex();
```

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Development

### Prerequisites

- WordPress development environment
- Advanced Custom Fields plugin
- Basic knowledge of PHP, CSS, and JavaScript

### Local Development

1. Clone the repository into your WordPress plugins directory
2. Create sample prize posts with ACF fields
3. Test the carousel functionality
4. Customize CSS and JavaScript as needed

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## License

This project is licensed under the GPL v2 or later - see the plugin header for details.

## Support

For support, please create an issue on GitHub or contact [Dalen Design](https://www.dalendesign.com/).

## Changelog

### 1.0.0

- Initial release
- Basic carousel functionality
- ACF integration
- Responsive design
- Keyboard navigation

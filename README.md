# Dalen Prize Carousel

A custom WordPress plugin for displaying prize information in a horizontal scrolling carousel format with ACF integration.

## Features

- 🎠 **Horizontal Scrolling Carousel** - Smooth card-by-card navigation with custom scrollbars
- 🎯 **ACF Integration** - Fully integrated with Advanced Custom Fields
- ⌨️ **Keyboard Navigation** - Arrow key support for accessibility
- 📱 **Mobile Friendly** - Touch scrolling and responsive design
- 🎨 **Modern CSS Architecture** - CSS custom properties and BEM naming convention
- ⚡ **Vanilla JavaScript** - No external dependencies
- 🔧 **Divi Optimized** - Enhanced experience with Divi themes (not required)
- 💰 **Currency Formatting** - Automatic Canadian dollar formatting
- 🌐 **Internationalization Ready** - Translation support

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Advanced Custom Fields (ACF) plugin

**Note:** While Divi is not required, the plugin provides an enhanced experience when used with Divi themes, including optimized icon usage and styling integration.

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

- `prize_title` (Text) - Main prize title (fallback to post title if empty)
- `prize_sub_title` (Text) - Prize subtitle
- `prize_image` (Image) - Prize image
- `prize_sponsor_name` (Text) - Sponsor name
- `prize_value` (Number) - Prize value (will be formatted as CAD currency)
- `prize_cta_label` (Text) - Call-to-action button text (default: "Enter Now")
- `prize_cta_link` (URL) - Call-to-action button link

### 3. Update Post Type Name

If you use a different post type name, update line 147 in `dalen-prize-carousel.php`:

```php
'post_type' => 'your_post_type_name', // Update this line
```

## Usage

### Basic Shortcode

Display the carousel with default settings (sorted by highest prize value):

```php
[prize_carousel]
```

### Shortcode with Custom Content and Sorting

Customize the title, introductory text, and sorting method:

```php
[prize_carousel title="2025 Prize List" text="Check out the incredible prizes generously donated by our partners. Your support matters." orderby="title"]
```

### Template Function

Use in theme files:

```php
<?php echo dpc_render_carousel(); ?>

// With custom attributes
<?php echo dpc_render_carousel([
    'title' => 'Custom Prize Title',
    'text' => 'Custom introductory text',
    'orderby' => 'prizevalue'
]); ?>
```

## Shortcode Attributes

| Attribute | Type   | Default                              | Description               |
| --------- | ------ | ------------------------------------ | ------------------------- |
| `title`   | string | "2025 Prize List"                    | Main carousel title       |
| `text`    | string | "Check out the incredible prizes..." | Introductory text         |
| `orderby` | string | "prizevalue"                         | Sorting method for prizes |

### Sorting Options (orderby)

| Value        | Description                        | Order                     |
| ------------ | ---------------------------------- | ------------------------- |
| `prizevalue` | Sort by prize value                | Highest to lowest (DESC)  |
| `title`      | Sort alphabetically by prize title | A to Z (ASC)              |
| `menu_order` | Use WordPress menu order           | Admin-defined order (ASC) |
| `date`       | Sort by publication date           | Newest first (DESC)       |

### Sorting Examples

```php
<!-- Display highest value prizes first (default) -->
[prize_carousel]

<!-- Sort prizes alphabetically -->
[prize_carousel orderby="title"]

<!-- Use admin drag-and-drop order -->
[prize_carousel orderby="menu_order"]

<!-- Show newest prizes first -->
[prize_carousel orderby="date"]

<!-- Custom title with specific sorting -->
[prize_carousel title="Premium Prizes" orderby="prizevalue"]
```

## File Structure

```
dalen-prize-carousel/
├── dalen-prize-carousel.php    # Main plugin file
├── assets/
│   ├── css/
│   │   └── carousel.css        # Carousel styles with CSS custom properties
│   └── js/
│       └── carousel.js         # Vanilla JavaScript functionality
├── languages/                  # Translation files (future)
├── README.md
└── .gitignore
```

## Design Features

### Visual Design

- Clean, modern card-based layout
- Smooth hover effects and transitions
- Custom orange color scheme with CSS variables
- Professional typography hierarchy
- Responsive breakpoints for mobile devices

### Navigation

- Circular navigation buttons with WordPress Dashicons
- Keyboard navigation with arrow keys
- Touch-friendly scrolling on mobile
- Custom scrollbar styling with theme colors

### Currency Display

- Automatic Canadian dollar formatting using PHP's NumberFormatter
- Graceful fallback for environments without NumberFormatter
- Clean, readable price display

## Customization

### CSS Custom Properties

The carousel uses CSS custom properties for easy theming:

```css
:root {
  --dpc-colour-neutral-400: #444444;
  --dpc-colour-neutral-500: #464646;
  --dpc-colour-orange-500: #d9571d;
  --dpc-colour-white: #fff;
  --dpc-font-size-xs: 0.875rem;
  --dpc-spacing-md: 1rem;
  /* ... and more */
}
```

### Key CSS Classes (BEM Convention)

- `.dpc-carousel-container` - Main container
- `.dpc-carousel-title` - Carousel title
- `.dpc-carousel-nav__btn` - Navigation buttons
- `.dpc-prize-card` - Individual prize cards
- `.dpc-prize-header` - Prize title area
- `.dpc-prize-image` - Prize image container
- `.dpc-prize-meta` - Prize metadata (sponsor, value)
- `.dpc-prize-cta__button` - Call-to-action button

### JavaScript API

The carousel class provides public methods:

```javascript
// Get carousel instance
const carousel = new DalenPrizeCarousel(container);

// Navigate to specific card
carousel.goToCard(2);

// Get current card index
const currentIndex = carousel.getCurrentIndex();
```

## Theme Compatibility

### Divi Theme Integration

When used with Divi themes, the plugin automatically:

- Uses Divi's icon font for enhanced visual consistency
- Integrates with Divi's design system
- Provides optimized styling for Divi layouts

### Other Themes

The plugin works with any WordPress theme and includes:

- Fallback icons when Divi is not present
- Self-contained styling that doesn't conflict with theme styles
- Responsive design that adapts to any container width

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
4. Customize CSS variables for your design needs

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

### 1.1.0

- **NEW:** Added `orderby` shortcode attribute for flexible prize sorting
- **NEW:** Sort by prize value (highest to lowest) - now the default
- **NEW:** Sort alphabetically by prize title
- **NEW:** Sort by WordPress menu order (admin drag-and-drop)
- **NEW:** Sort by publication date (newest first)
- **IMPROVED:** Enhanced query safety with meta field existence checks
- **IMPROVED:** More robust error handling for sorting operations
- **IMPROVED:** Better parameter naming consistency throughout codebase

### 1.0.0

- Initial release
- Horizontal scrolling carousel with smooth navigation
- ACF integration with fallback support
- Canadian currency formatting
- Responsive design with mobile optimization
- Divi theme integration with fallbacks
- Keyboard navigation support
- CSS custom properties for easy theming
- WordPress Dashicons integration

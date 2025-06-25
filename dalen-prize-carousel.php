<?php

/**
 * Plugin Name: Dalen Prize Carousel
 * Plugin URI: https://yoursite.com/
 * Description: A custom carousel plugin for displaying prize information with ACF integration.
 * Version: 1.0.0
 * Author: Dalen Design
 * Author URI: https://www.dalendesign.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dalen-prize-carousel
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DPC_VERSION', '1.0.0');
define('DPC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DPC_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DPC_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class Dalen_Prize_Carousel
{

    /**
     * Single instance of the plugin
     */
    private static $instance = null;

    /**
     * Get single instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Initialize plugin
     */
    public function init()
    {
        // Check for ACF dependency
        if (!$this->check_acf_dependency()) {
            return;
        }

        // Load text domain
        load_plugin_textdomain('dalen-prize-carousel', false, dirname(DPC_PLUGIN_BASENAME) . '/languages');

        // Initialize components
        $this->init_shortcode();
        $this->enqueue_assets();
    }

    /**
     * Check if ACF is active
     */
    private function check_acf_dependency()
    {
        if (!class_exists('ACF')) {
            add_action('admin_notices', array($this, 'acf_dependency_notice'));
            return false;
        }
        return true;
    }

    /**
     * Display ACF dependency notice
     */
    public function acf_dependency_notice()
    {
?>
        <div class="notice notice-error">
            <p><?php _e('Dalen Prize Carousel requires Advanced Custom Fields to be installed and active.', 'dalen-prize-carousel'); ?></p>
        </div>
    <?php
    }



    /**
     * Initialize shortcode
     */
    public function init_shortcode()
    {
        add_shortcode('prize_carousel', array($this, 'render_carousel_shortcode'));
    }

    /**
     * Render carousel shortcode
     */
    public function render_carousel_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'slides_to_show' => 3,
            'show_arrows' => 'true',
        ), $atts, 'prize_carousel');

        // Get prizes
        $prizes = $this->get_prizes();

        if (empty($prizes)) {
            return '<p>' . __('No prizes found.', 'dalen-prize-carousel') . '</p>';
        }

        // Start output buffering
        ob_start();

    ?>
        <div class="dpc-carousel-container"
            data-slides-to-show="<?php echo esc_attr($atts['slides_to_show']); ?>"
            data-show-arrows="<?php echo esc_attr($atts['show_arrows']); ?>">

            <?php if ($atts['show_arrows'] === 'true'): ?>
                <div class="dpc-carousel-nav">
                    <button class="dpc-carousel-nav__btn dpc-carousel-nav__btn--prev" aria-label="<?php _e('Previous slide', 'dalen-prize-carousel'); ?>">
                        <span>&lt;</span>
                    </button>
                    <button class="dpc-carousel-nav__btn dpc-carousel-nav__btn--next" aria-label="<?php _e('Next slide', 'dalen-prize-carousel'); ?>">
                        <span>&gt;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="dpc-carousel-wrapper">
                <div class="dpc-carousel-track">
                    <?php foreach ($prizes as $prize): ?>
                        <?php $this->render_prize_card($prize); ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    <?php

        return ob_get_clean();
    }

    /**
     * Get all prizes
     */
    private function get_prizes()
    {
        // Since ACF will handle the custom post type,
        // you'll need to update this with your actual post type name
        // For example, if ACF creates 'prize' post type:
        $args = array(
            'post_type' => 'prize', // Update this to match your ACF post type
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );

        return get_posts($args);
    }

    /**
     * Render individual prize card
     */
    private function render_prize_card($prize)
    {
        // Get ACF fields (customize these field names based on your ACF setup)
        $prize_title = get_field('prize_title', $prize->ID);
        $prize_sub_title = get_field('prize_sub_title', $prize->ID);
        $prize_image = get_field('prize_image', $prize->ID);
        $prize_sponsor_name = get_field('prize_sponsor_name', $prize->ID);
        $prize_value = get_field('prize_value', $prize->ID);
        $prize_cta_label = get_field('prize_cta_label', $prize->ID) ?: __('Enter Now', 'dalen-prize-carousel');
        $prize_cta_link = get_field('prize_cta_link', $prize->ID);

    ?>
        <div class="dpc-prize-card">

            <div class="dpc-prize-header">
                <h3 class="dpc-prize-header-title"><?php echo esc_html($prize_title); ?>
                    <span class="dpc-prize-header-sub-title"><?php echo esc_html($prize_sub_title); ?></span>
                </h3>
            </div>

            <?php if ($prize_image): ?>
                <div class="dpc-prize-image">
                    <img src="<?php echo esc_url($prize_image['url']); ?>" alt="<?php echo esc_attr($prize_image['alt'] ?: $prize->post_title); ?>" />
                </div>
            <?php endif; ?>

            <div class="dpc-prize-meta">
                <?php if ($prize_sponsor_name): ?>
                    <div class="dpc-prize-meta__item">
                        <span class="dpc-prize-meta__label"><?php _e('Sponsor:', 'dalen-prize-carousel'); ?></span>
                        <span class="dpc-prize-meta__value"><?php echo esc_html($prize_sponsor_name); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($prize_value): ?>
                    <div class="dpc-prize-meta__item">
                        <span class="dpc-prize-meta__label"><?php _e('Value:', 'dalen-prize-carousel'); ?></span>
                        <span class="dpc-prize-meta__value"><?php echo esc_html($prize_value); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($prize_cta_link): ?>
                <div class="dpc-prize-cta">
                    <a href="<?php echo esc_url($prize_cta_link); ?>" class="dpc-prize-cta__button">
                        <?php echo esc_html($prize_cta_label); ?> →
                    </a>
                </div>
            <?php endif; ?>

        </div>

<?php
    }

    /**
     * Enqueue assets
     */
    public function enqueue_assets()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets()
    {
        // Only enqueue on pages that use the shortcode
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'prize_carousel')) {
            wp_enqueue_style(
                'dpc-carousel-css',
                DPC_PLUGIN_URL . 'assets/css/carousel.css',
                array(),
                DPC_VERSION
            );

            wp_enqueue_script(
                'dpc-carousel-js',
                DPC_PLUGIN_URL . 'assets/js/carousel.js',
                array(),
                DPC_VERSION,
                true
            );
        }
    }

    /**
     * Plugin activation
     */
    public function activate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation
     */
    public function deactivate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}

// Initialize the plugin
Dalen_Prize_Carousel::get_instance();

/**
 * Helper function to render carousel anywhere in theme
 */
function dpc_render_carousel($atts = array())
{
    return do_shortcode('[prize_carousel ' . http_build_query($atts, '', ' ') . ']');
}

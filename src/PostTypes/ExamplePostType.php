<?php
// src/PostTypes/ExamplePostType.php
namespace WPLaravel\PostTypes;

class ExamplePostType
{
    protected $slug = 'wp_laravel_example';
    
    public function register()
    {
        register_post_type($this->slug, [
            'labels' => $this->getLabels(),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'examples'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
            'show_in_rest' => true,
        ]);
        
        $this->registerTaxonomies();
        $this->registerMetaBoxes();
    }
    
    protected function getLabels()
    {
        return [
            'name' => _x('Examples', 'Post Type General Name', 'wp-laravel-boilerplate'),
            'singular_name' => _x('Example', 'Post Type Singular Name', 'wp-laravel-boilerplate'),
            'menu_name' => __('Examples', 'wp-laravel-boilerplate'),
            'name_admin_bar' => __('Example', 'wp-laravel-boilerplate'),
            'archives' => __('Example Archives', 'wp-laravel-boilerplate'),
            'attributes' => __('Example Attributes', 'wp-laravel-boilerplate'),
            'parent_item_colon' => __('Parent Example:', 'wp-laravel-boilerplate'),
            'all_items' => __('All Examples', 'wp-laravel-boilerplate'),
            'add_new_item' => __('Add New Example', 'wp-laravel-boilerplate'),
            'add_new' => __('Add New', 'wp-laravel-boilerplate'),
            'new_item' => __('New Example', 'wp-laravel-boilerplate'),
            'edit_item' => __('Edit Example', 'wp-laravel-boilerplate'),
            'update_item' => __('Update Example', 'wp-laravel-boilerplate'),
            'view_item' => __('View Example', 'wp-laravel-boilerplate'),
            'view_items' => __('View Examples', 'wp-laravel-boilerplate'),
            'search_items' => __('Search Example', 'wp-laravel-boilerplate'),
        ];
    }
    
    protected function registerTaxonomies()
    {
        register_taxonomy('example_category', [$this->slug], [
            'labels' => [
                'name' => _x('Categories', 'Taxonomy General Name', 'wp-laravel-boilerplate'),
                'singular_name' => _x('Category', 'Taxonomy Singular Name', 'wp-laravel-boilerplate'),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
        ]);
    }
    
    protected function registerMetaBoxes()
    {
        add_action('add_meta_boxes', function() {
            add_meta_box(
                'wp_laravel_example_meta',
                __('Example Meta', 'wp-laravel-boilerplate'),
                [$this, 'renderMetaBox'],
                $this->slug,
                'side',
                'default'
            );
        });
        
        add_action('save_post_' . $this->slug, [$this, 'saveMetaBox']);
    }
    
    public function renderMetaBox($post)
    {
        wp_nonce_field('wp_laravel_example_meta', 'wp_laravel_example_meta_nonce');
        
        $value = get_post_meta($post->ID, '_example_meta_key', true);
        
        echo '<label for="example_meta_field">';
        _e('Meta Field:', 'wp-laravel-boilerplate');
        echo '</label> ';
        echo '<input type="text" id="example_meta_field" name="example_meta_field" value="' . esc_attr($value) . '" size="25" />';
    }
    
    public function saveMetaBox($post_id)
    {
        if (!isset($_POST['wp_laravel_example_meta_nonce'])) {
            return;
        }
        
        if (!wp_verify_nonce($_POST['wp_laravel_example_meta_nonce'], 'wp_laravel_example_meta')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if (isset($_POST['example_meta_field'])) {
            update_post_meta($post_id, '_example_meta_key', sanitize_text_field($_POST['example_meta_field']));
        }
    }
}

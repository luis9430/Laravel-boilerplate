<?php
// src/PostTypes/PostTypeManager.php
namespace WPLaravel\PostTypes;

class PostTypeManager
{
    protected $postTypes = [
        ExamplePostType::class,
    ];
    
    public function register()
    {
        foreach ($this->postTypes as $postTypeClass) {
            $postType = new $postTypeClass();
            add_action('init', [$postType, 'register']);
        }
    }
}
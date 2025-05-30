<?php
// src/Traits/HasMeta.php
namespace WPLaravel\Traits;

trait HasMeta
{
    public function getMeta($key, $default = null)
    {
        $meta = $this->meta_data ?? [];
        
        if (is_string($meta)) {
            $meta = json_decode($meta, true) ?: [];
        }
        
        return $meta[$key] ?? $default;
    }
    
    public function setMeta($key, $value)
    {
        $meta = $this->meta_data ?? [];
        
        if (is_string($meta)) {
            $meta = json_decode($meta, true) ?: [];
        }
        
        $meta[$key] = $value;
        
        $this->meta_data = $meta;
        
        return $this;
    }
    
    public function deleteMeta($key)
    {
        $meta = $this->meta_data ?? [];
        
        if (is_string($meta)) {
            $meta = json_decode($meta, true) ?: [];
        }
        
        unset($meta[$key]);
        
        $this->meta_data = $meta;
        
        return $this;
    }
}
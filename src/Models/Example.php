<?php 
namespace WPLaravel\Models;

class Example extends BaseModel
{
    // Nombre de la tabla SIN el prefijo de WordPress
    // El prefijo se agregará automáticamente
    protected $table = 'wp_laravel_examples';
    
    protected $fillable = [
        'title',
        'content',
        'status',
        'meta_data'
    ];
    
    protected $casts = [
        'meta_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
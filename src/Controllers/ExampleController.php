<?php
// src/Controllers/ExampleController.php
namespace WPLaravel\Controllers;

use WPLaravel\Models\Example;

class ExampleController extends BaseController
{
    public function index()
    {
        $examples = Example::active()->get();
        
        return $this->view('examples.index', compact('examples'));
    }
    
    public function store()
    {
        $data = [
            'title' => sanitize_text_field($_POST['title'] ?? ''),
            'content' => wp_kses_post($_POST['content'] ?? ''),
            'status' => 'active'
        ];
        
        $example = Example::create($data);
        
        return $this->json([
            'success' => true,
            'data' => $example
        ]);
    }
    
    public function show($id)
    {
        $example = Example::findOrFail($id);
        
        return $this->view('examples.show', compact('example'));
    }
}
<?php
// src/Api/ExampleApiController.php
namespace WPLaravel\Api;

use WPLaravel\Models\Example;
use WP_REST_Request;
use WP_REST_Response;

class ExampleApiController
{
    public function index(WP_REST_Request $request)
    {
        $page = $request->get_param('page') ?: 1;
        $perPage = $request->get_param('per_page') ?: 10;
        
        $examples = Example::active()
            ->paginate($perPage, ['*'], 'page', $page);
        
        return new WP_REST_Response([
            'data' => $examples->items(),
            'meta' => [
                'total' => $examples->total(),
                'current_page' => $examples->currentPage(),
                'last_page' => $examples->lastPage(),
            ]
        ], 200);
    }
    
    public function show(WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $example = Example::find($id);
        
        if (!$example) {
            return new WP_REST_Response(['error' => 'Not found'], 404);
        }
        
        return new WP_REST_Response(['data' => $example], 200);
    }
    
    public function create(WP_REST_Request $request)
    {
        $data = [
            'title' => sanitize_text_field($request->get_param('title')),
            'content' => wp_kses_post($request->get_param('content')),
            'status' => 'active',
            'meta_data' => $request->get_param('meta_data') ?: []
        ];
        
        $example = Example::create($data);
        
        return new WP_REST_Response(['data' => $example], 201);
    }
    
    public function update(WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $example = Example::find($id);
        
        if (!$example) {
            return new WP_REST_Response(['error' => 'Not found'], 404);
        }
        
        $example->update([
            'title' => sanitize_text_field($request->get_param('title')),
            'content' => wp_kses_post($request->get_param('content')),
            'meta_data' => $request->get_param('meta_data') ?: $example->meta_data
        ]);
        
        return new WP_REST_Response(['data' => $example], 200);
    }
    
    public function delete(WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        $example = Example::find($id);
        
        if (!$example) {
            return new WP_REST_Response(['error' => 'Not found'], 404);
        }
        
        $example->delete();
        
        return new WP_REST_Response(null, 204);
    }
}

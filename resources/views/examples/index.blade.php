@extends('layouts.app')

@section('content')
<div class="wrap">
    <h1>{{ __('Examples', 'wp-laravel-boilerplate') }}</h1>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>{{ __('Title', 'wp-laravel-boilerplate') }}</th>
                <th>{{ __('Status', 'wp-laravel-boilerplate') }}</th>
                <th>{{ __('Created', 'wp-laravel-boilerplate') }}</th>
                <th>{{ __('Actions', 'wp-laravel-boilerplate') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($examples as $example)
            <tr>
                <td>{{ $example->title }}</td>
                <td>{{ $example->status }}</td>
                <td>{{ $example->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="#" class="button">{{ __('Edit', 'wp-laravel-boilerplate') }}</a>
                    <a href="#" class="button">{{ __('Delete', 'wp-laravel-boilerplate') }}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

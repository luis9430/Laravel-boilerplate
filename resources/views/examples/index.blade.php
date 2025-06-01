@extends('layouts.app')
@section('title', __('Panel de Workflow', 'wp-laravel-boilerplate')) 
@section('content')
<div class="wrap">
    <h1>{{ __('Panel de Administración del Plugin', 'wp-laravel-boilerplate') }}</h1>
    {{-- Este es el único elemento importante que Preact necesita para montarse --}}
    <div id="pagina_preact_root">
        <p>Cargando aplicación...</p>
    </div>
</div>
@endsection

<?php 

// src/Queue/Jobs/ExampleJob.php
namespace WPLaravel\Queue\Jobs;

class ExampleJob
{
    public function handle($data)
    {
        // Procesar trabajo en background
        error_log('Processing job with data: ' . json_encode($data));
    }
}


<?php $__env->startSection('title', __('Panel de Workflow', 'wp-laravel-boilerplate')); ?> 
<?php $__env->startSection('content'); ?>
<div class="wrap">
    <h1><?php echo e(__('Panel de Administración del Plugin', 'wp-laravel-boilerplate')); ?></h1>
    
    <div id="pagina_preact_root">
        <p>Cargando aplicación...</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\wordpress\wp-content\plugins\Laravel-boilerplate\resources\views/examples/index.blade.php ENDPATH**/ ?>
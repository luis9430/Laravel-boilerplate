 

<?php $__env->startSection('title', $pageTitle ?? __('Gestor de Plantillas', 'wp-laravel-boilerplate')); ?>

<?php $__env->startSection('content'); ?>
<div class="wrap">
    <h1><?php echo e($pageTitle ?? __('Gestor de Plantillas de Producto', 'wp-laravel-boilerplate')); ?></h1>
    
    <div id="product-template-manager-root">
        <p><?php echo e(__('Cargando aplicación del gestor de plantillas...', 'wp-laravel-boilerplate')); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\wordpress\wp-content\plugins\Laravel-boilerplate\resources\views/product-templates/index.blade.php ENDPATH**/ ?>
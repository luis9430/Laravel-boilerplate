

<?php $__env->startSection('content'); ?>
<div class="wrap">
    <h1><?php echo e(__('Examples', 'wp-laravel-boilerplate')); ?></h1>
    
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php echo e(__('Title', 'wp-laravel-boilerplate')); ?></th>
                <th><?php echo e(__('Status', 'wp-laravel-boilerplate')); ?></th>
                <th><?php echo e(__('Created', 'wp-laravel-boilerplate')); ?></th>
                <th><?php echo e(__('Actions', 'wp-laravel-boilerplate')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $examples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $example): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($example->title); ?></td>
                <td><?php echo e($example->status); ?></td>
                <td><?php echo e($example->created_at->format('Y-m-d H:i')); ?></td>
                <td>
                    <a href="#" class="button"><?php echo e(__('Edit', 'wp-laravel-boilerplate')); ?></a>
                    <a href="#" class="button"><?php echo e(__('Delete', 'wp-laravel-boilerplate')); ?></a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\wordpress\wp-content\plugins\Laravel-boilerplate\resources\views/examples/index.blade.php ENDPATH**/ ?>
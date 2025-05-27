<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gewoontetracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Mijn Gewoontes</h1>

    <a href="<?php echo e(route('habits.create')); ?>" class="btn btn-primary mb-3">+ Nieuwe gewoonte</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($habits->isEmpty()): ?>
        <p class="text-muted">Je hebt nog geen gewoontes toegevoegd.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php $__currentLoopData = $habits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo e($habit->name); ?></strong><br>
                        <small class="text-muted"><?php echo e($habit->description); ?></small>
                    </div>
                    <div>
                        <a href="<?php echo e(route('habits.edit', $habit)); ?>" class="btn btn-sm btn-outline-secondary me-2">Bewerk</a>
                        <form action="<?php echo e(route('habits.destroy', $habit)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Verwijder</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/habits/index.blade.php ENDPATH**/ ?>
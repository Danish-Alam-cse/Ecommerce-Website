<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <a class="navbar-brand" href="">Online Foodie</a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="" class="nav-link">Home</a></li>
    <li class="nav-item"><a href="<?php echo e(route('cart' )); ?>" class="nav-link">Cart 
            <sup><span class="badge badge-pill bg-white text-dark">

            <?php 
                
                    echo $count = App\Http\Controllers\Cart::get_cart_count(); ?>
            </span></sup>
        </a></li>
    </ul>
</nav>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->yieldSection(); ?>

</body>
</html><?php /**PATH D:\Kamana\Projects-laravel\ecom\resources\views/home/base.blade.php ENDPATH**/ ?>
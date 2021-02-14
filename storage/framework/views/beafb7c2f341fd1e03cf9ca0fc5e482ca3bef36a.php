


<?php $__env->startSection('content'); ?>
    
    

<div class="jumbotron bg-transparent rounded-0" style="background-image:url('wp1929358.jpg');height:500px;background-size:cover">
    <div class="col-lg-6 mx-auto">
    
    <form action="" class="mt-5 pt-5">
        <h2 class="text-white">Find your Taste</h2>
        <input type="search" class="form-control" placeholder="E.g Burger, snacks">
    </form>
    
    </div>
</div>

<div class="container">
<div class="row">

    <?php $__currentLoopData = $pro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
    
    <div class="col-lg-3">
        <div class="card">
            <?php 
            if($p->isVeg==true):
                $color = "bg-success";
                $text = "Veg";
        else:
                $color = "bg-danger";
                $text = "Non-Veg";
        endif;
        ?>
        <span class="veg <?= $color;?>"><?= $text;?></span>

            <img src="<?= $p->image;?>" alt="" class="card-img-top">
            <div class="card-body">
                <h2 class="small font-weight-bolder"><?= $p->title;?></h2>
                <div class="row no-gutters">
                    <div class="col-3">
                        <h2 class="h6 mt-1"> ₹<?= $p->price;?>/-</h2>
                    </div>
                    <div class="col">
                    <a href="<?php echo e(route('addtocart',['item_id'=>$p->id])); ?>" class="btn btn-success btn-block btn-sm">Add To Cart</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>


</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kamana\laravel\ecom\resources\views/home/index.blade.php ENDPATH**/ ?>
<?php if(!empty($featureWithImages)): ?>
<section class="section" id="section-features">
    <div class="container">
        <header class="section-header">
            <small>Features</small>
            <h2><?php echo e($detail->feature_title); ?></h2>
            <p class="lead"><?php echo e($detail->feature_description); ?></p>
            <hr>
        </header>

        <?php $__empty_1 = true; $__currentLoopData = $featureWithImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if($key % 2 == 0): ?>
                <div class="row gap-y align-items-center">
                    <div class="col-12  col-md-5 text-center">
                        <img <?php if($value->image): ?>src="<?php echo e(asset('front-uploads/feature/'.$value->image)); ?>" <?php else: ?> src="<?php echo e(asset('front/img-3.png')); ?>" <?php endif; ?> alt="..." class="shadow-4">
                    </div>

                    <div class="col-12 offset-md-1  col-md-6">
                        <h5><?php echo e($value->title); ?></h5>
                        <p><?php echo $value->description; ?> </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="row gap-y align-items-center">
                    <div class="col-12 col-md-6">
                        <h5><?php echo e($value->title); ?></h5>
                        <p><?php echo $value->description; ?> </p>
                    </div>

                    <div class="col-12 offset-md-1 col-md-5 text-center">
                        <img <?php if($value->image): ?>src="<?php echo e(asset('front-uploads/feature/'.$value->image)); ?>" <?php else: ?> src="<?php echo e(asset('front/img-4.png')); ?>" <?php endif; ?> alt="..." class="shadow-4">
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if((sizeof($featureWithImages)-1) !=  $key): ?><hr class="w-200 my-90"> <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php if(!empty($featureWithIcons)): ?>
    <section class="section bg-gray">
        <div class="container">
            <div class="row gap-y">
                <?php $__currentLoopData = $featureWithIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureWithIcon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="flexbox gap-items-4">
                        <div>
                            <i class="<?php echo e($featureWithIcon->icon); ?> fs-25 pt-4 text-secondary"></i>
                        </div>

                        <div>
                            <h5><?php echo e($featureWithIcon->title); ?></h5>
                            <p><?php echo $featureWithIcon->description; ?> </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\noky\resources\views/front/section/feature.blade.php ENDPATH**/ ?>
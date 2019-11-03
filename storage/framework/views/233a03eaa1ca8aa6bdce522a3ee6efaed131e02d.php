<section class="section" id="section-pricing">
    <div class="container">

        <header class="section-header">
            <h2><?php echo e($detail->price_title); ?></h2>
            <hr>
            <p class="lead"><?php echo e($detail->price_description); ?></p>
        </header>


        <div class="text-center mb-70">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-round btn-outline btn-dark w-150 active">
                    <input type="radio" onchange="planShow('monthly')" name="pricing" value="monthly" autocomplete="off" checked> <?php echo app('translator')->getFromJson('app.monthly'); ?>
                </label>
                <label class="btn btn-round btn-outline btn-dark w-150">
                    <input type="radio" onchange="planShow('yearly')" name="pricing" value="yearly" autocomplete="off"> <?php echo app('translator')->getFromJson('app.annual'); ?>
                </label>
            </div>
        </div>


        

        <section class="pricing-section-2 text-center monthly-packages" id="monthlyPlan">
            <div class="container">
                <div class="row justify-content-center">
    
                    <div class="col-md-2 pick-plan">
                            <div class="pricing pricing-3">
                                <div class="pricing__head boxed" >
                                    <h3><?php echo app('translator')->getFromJson('modules.frontCms.pickPlan'); ?></h3> 
                                </div>
                                
                                <ul>
                                    <li><?php echo app('translator')->getFromJson('app.max'); ?> <?php echo app('translator')->getFromJson('app.menu.employees'); ?></li>
                                    <?php $__currentLoopData = $packageFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $packageFeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <span><?php echo e(ucwords($packageFeature)); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </ul>
                            </div>
                        </div>
                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-2 ">
                            <div class="pricing pricing-3">
                                <?php if($item->recommended): ?>
                                    <div class="pricing__head bg--primary boxed background-color"> <span class="label"><?php echo app('translator')->getFromJson('app.recommended'); ?></span>
                                        <h5><?php echo e(ucwords($item->name)); ?></h5> <span class="h1"><span class="pricing__dollar"><?php echo e($global->currency->currency_symbol); ?></span><?php echo e($item->monthly_price); ?></span>
                                        <p class="type--fine-print"><?php echo app('translator')->getFromJson('modules.frontCms.perMonth'); ?>, <?php echo e($global->currency->currency_code); ?>.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="pricing__head bg--secondary boxed">
                                        <h5><?php echo e(ucwords($item->name)); ?></h5> <span class="h4"><span class="pricing__dollar"><?php echo e($global->currency->currency_symbol); ?></span><?php echo e($item->monthly_price); ?></span>
                                        <p class="type--fine-print"><?php echo app('translator')->getFromJson('modules.frontCms.perMonth'); ?>, <?php echo e($global->currency->currency_code); ?>.</p>
                                    </div>
                                <?php endif; ?>
                                <ul>
                                    <li><?php echo e($item->max_employees); ?> &nbsp;</li>
                                    <?php
                                        $packageModules = (array)json_decode($item->module_in_package);
                                    ?>
                                    <?php $__currentLoopData = $packageFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $packageFeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php if(in_array($packageFeature, $packageModules)): ?>
                                                <i class="fa fa-check-circle module-available"></i>
                                            <?php endif; ?>
                                            &nbsp;
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                
                </div>
            </div>
        </section>
        <section class="pricing-section-2 text-center annual-packages" style="display: none" id="annualPlan">
            <div class="container">
                <div class="row justify-content-center">
    
                    <div class="col-md-2 pick-plan">
                            <div class="pricing pricing-3">
                                <div class="pricing__head boxed" >
                                    <h3><?php echo app('translator')->getFromJson('modules.frontCms.pickPlan'); ?></h3> 
                                </div>
                                
                                <ul>
                                    <li><?php echo app('translator')->getFromJson('app.max'); ?> <?php echo app('translator')->getFromJson('app.menu.employees'); ?></li>
                                    <?php $__currentLoopData = $packageFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $packageFeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <span><?php echo e($packageFeature); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </ul>
                            </div>
                        </div>
    
                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-2 " >
                            <div class="pricing pricing-3">
                                <?php if($item->recommended): ?>
                                    <div class="pricing__head bg--primary boxed background-color"> <span class="label"><?php echo app('translator')->getFromJson('app.recommended'); ?></span>
                                        <h5><?php echo e(ucwords($item->name)); ?></h5> <span class="h1"><span class="pricing__dollar"><?php echo e($global->currency->currency_symbol); ?></span><?php echo e($item->annual_price); ?></span>
                                        <p class="type--fine-print"><?php echo app('translator')->getFromJson('modules.frontCms.perYear'); ?>, <?php echo e($global->currency->currency_code); ?>.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="pricing__head bg--secondary boxed">
                                        <h5><?php echo e(ucwords($item->name)); ?></h5> <span class="h4"><span class="pricing__dollar"><?php echo e($global->currency->currency_symbol); ?></span><?php echo e($item->annual_price); ?></span>
                                        <p class="type--fine-print"><?php echo app('translator')->getFromJson('modules.frontCms.perYear'); ?>, <?php echo e($global->currency->currency_code); ?>.</p>
                                    </div>
                                <?php endif; ?>
                                <ul>
                                    <li><?php echo e($item->max_employees); ?> &nbsp;</li>
                                    <?php
                                        $packageModules = (array)json_decode($item->module_in_package);
                                    ?>
                                    <?php $__currentLoopData = $packageFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $packageFeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php if(in_array($packageFeature, $packageModules)): ?>
                                                <i class="fa fa-check-circle module-available"></i>
                                            <?php endif; ?>
                                            &nbsp;
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                    
    
                </div>
            </div>
        </section>


    </div>
</section><?php /**PATH C:\xampp\htdocs\noky\resources\views/front/section/pricing.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?> #<?php echo e($project->id); ?> - <span class="font-bold"><?php echo e(ucwords($project->project_name)); ?></span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li><a href="<?php echo e(route('admin.projects.index')); ?>"><?php echo e(__($pageTitle)); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('modules.projects.members'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/icheck/skins/all.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/multiselect/css/multi-select.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li ><a href="<?php echo e(route('admin.projects.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.overview'); ?></span></a>
                                </li>

                                <li class="tab-current"><a href="<?php echo e(route('admin.project-members.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.members'); ?></span></a></li>

                                <li><a href="<?php echo e(route('admin.milestones.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></span></a></li>

                                <?php if(in_array('tasks',$modules)): ?>
                                <li><a href="<?php echo e(route('admin.tasks.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.tasks'); ?></span></a></li>
                                <?php endif; ?>

                                <li><a href="<?php echo e(route('admin.files.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.files'); ?></span></a></li>

                                <?php if(in_array('invoices',$modules)): ?>
                                <li><a href="<?php echo e(route('admin.invoices.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.invoices'); ?></span></a></li>
                                <?php endif; ?>

                                <?php if(in_array('timelogs',$modules)): ?>
                                <li><a href="<?php echo e(route('admin.time-logs.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?></span></a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-2" class="show">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?php echo app('translator')->getFromJson('modules.projects.members'); ?></div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo app('translator')->getFromJson('app.name'); ?></th>
                                                                <th><?php echo app('translator')->getFromJson('app.role'); ?></th>
                                                                <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $__empty_1 = true; $__currentLoopData = $project->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo ($member->user->image) ? '<img src="'.asset('user-uploads/avatar/'.$member->user->image).'"
                                                            alt="user" class="img-circle" width="40">' : '<img src="'.asset('default-profile-2.png').'"
                                                            alt="user" class="img-circle" width="40">'; ?>

                                                                    <?php echo e(ucwords($member->user->name)); ?>

                                                                </td>
                                                                <td>
                                                                    <div class="radio radio-info">
                                                                        <input type="radio" name="project_admin" class="assign_role" id="project_admin_<?php echo e($member->user->id); ?>" value="<?php echo e($member->user->id); ?>"
                                                                        <?php if($member->user->id == $project->project_admin): ?> checked <?php endif; ?>
                                                                        >
                                                                        <label for="project_admin_<?php echo e($member->user->id); ?>"> Project Admin </label>
                                                                    </div>
                                                                </td>
                                                                <td><a href="javascript:;" data-member-id="<?php echo e($member->id); ?>" class="btn btn-sm btn-danger btn-rounded delete-members"><i class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.remove'); ?></a></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo app('translator')->getFromJson('messages.noMemberAddedToProject'); ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="white-box">
                                        <h3><?php echo app('translator')->getFromJson('modules.projects.addMemberTitle'); ?></h3>

                                        <?php echo Form::open(['id'=>'createMembers','class'=>'ajax-form','method'=>'POST']); ?>


                                        <div class="form-body">

                                            <?php echo Form::hidden('project_id', $project->id); ?>


                                            <div class="form-group" id="user_id">
                                                <select class="select2 m-b-10 select2-multiple " multiple="multiple"
                                                        data-placeholder="Choose Members" name="user_id[]">
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($emp->id); ?>"><?php echo e(ucwords($emp->name). ' ['.$emp->email.']'); ?> <?php if($emp->id == $user->id): ?>
                                                                (YOU) <?php endif; ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" id="save-members" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?>
                                                </button>
                                            </div>
                                        </div>

                                        <?php echo Form::close(); ?>


                                        <hr>

                                        <h3><?php echo app('translator')->getFromJson('app.add'); ?> <?php echo app('translator')->getFromJson('app.team'); ?></h3>

                                        <?php echo Form::open(['id'=>'saveGroup','class'=>'ajax-form','method'=>'POST']); ?>


                                        <div class="form-body">

                                            <?php echo Form::hidden('project_id', $project->id); ?>


                                            <div class="form-group" id="user_id">
                                                <select class="select2 m-b-10 select2-multiple " multiple="multiple"
                                                        data-placeholder="Choose Team" name="group_id[]">
                                                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($group->id); ?>"><?php echo e(ucwords($group->team_name)); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" id="save-group" class="btn btn-success"><i
                                                            class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?>
                                                </button>
                                            </div>
                                        </div>

                                        <?php echo Form::close(); ?>


                                    </div>
                                </div>
                            </div>

                        </section>

                    </div><!-- /content -->
                </div><!-- /tabs -->
            </section>
        </div>


    </div>
    <!-- .row -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('js/cbpFWTabs.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/multiselect/js/jquery.multi-select.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script type="text/javascript">
//    (function () {
//
//        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
//            new CBPFWTabs(el);
//        });
//
//    })();

    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });

    //    save project members
    $('#save-members').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.project-members.store')); ?>',
            container: '#createMembers',
            type: "POST",
            data: $('#createMembers').serialize(),
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    window.location.reload();
                }
            }
        })
    });

//    add group members
$('#save-group').click(function () {
    $.easyAjax({
        url: '<?php echo e(route('admin.project-members.storeGroup')); ?>',
        container: '#saveGroup',
        type: "POST",
        data: $('#saveGroup').serialize(),
        success: function (response) {
            if (response.status == "success") {
                $.unblockUI();
                window.location.reload();
            }
        }
    })
});



$('body').on('click', '.delete-members', function(){
    var id = $(this).data('member-id');
    swal({
        title: "Are you sure?",
        text: "This will remove the member from the project.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm){
        if (isConfirm) {

            var url = "<?php echo e(route('admin.project-members.destroy',':id')); ?>";
            url = url.replace(':id', id);

            var token = "<?php echo e(csrf_token()); ?>";

            $.easyAjax({
                type: 'POST',
                url: url,
                data: {'_token': token, '_method': 'DELETE'},
                success: function (response) {
                    if (response.status == "success") {
                        $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                        window.location.reload();
                    }
                }
            });
        }
    });
});

$('body').on('click', '.assign_role', function(){
    var userId = $(this).val();
    var projectId = '<?php echo e($project->id); ?>';
    var token = "<?php echo e(csrf_token()); ?>";

    $.easyAjax({
        url: '<?php echo e(route('admin.employees.assignProjectAdmin')); ?>',
        type: "POST",
        data: {userId: userId, projectId: projectId, _token : token},
        success: function (response) {
            if(response.status == "success"){
                $.unblockUI();
            }
        }
    })

});


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/projects/project-member/create.blade.php ENDPATH**/ ?>
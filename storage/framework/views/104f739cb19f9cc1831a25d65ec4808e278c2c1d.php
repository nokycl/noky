<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e($pageTitle); ?> #<?php echo e($project->id); ?> - <span
                        class="font-bold"><?php echo e(ucwords($project->project_name)); ?></span></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li><a href="<?php echo e(route('admin.projects.index')); ?>"><?php echo e($pageTitle); ?></a></li>
                <li class="active"><?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('admin.projects.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.overview'); ?></span></a></li>
                                <?php if(in_array('employees',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.project-members.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.members'); ?></span></a>
                                </li>
                                <?php endif; ?>

                                <li class="tab-current"><a href="<?php echo e(route('admin.milestones.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></span></a></li>

                                <?php if(in_array('tasks',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.tasks.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.tasks'); ?></span></a>
                                </li>
                                <?php endif; ?>


                                <li>
                                    <a href="<?php echo e(route('admin.files.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('modules.projects.files'); ?></span></a>
                                </li>

                                <?php if(in_array('invoices',$modules)): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.invoices.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.invoices'); ?></span></a>
                                </li>
                                <?php endif; ?>

                                <?php if(in_array('timelogs',$modules)): ?>
                                <li ><a
                                            href="<?php echo e(route('admin.time-logs.show', $project->id)); ?>"><span><?php echo app('translator')->getFromJson('app.menu.timeLogs'); ?></span></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-3" class="show">
                            <div class="row">
                                <div class="col-md-12" id="issues-list-panel">
                                    <div class="white-box">
                                        <h2><?php echo app('translator')->getFromJson('modules.projects.milestones'); ?></h2>

                                        <div class="row m-b-10">
                                            <div class="col-md-12">
                                                <a href="javascript:;" id="show-add-form"
                                                   class="btn btn-success btn-outline"><i
                                                            class="fa fa-flag"></i> <?php echo app('translator')->getFromJson('modules.projects.createMilestone'); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo Form::open(['id'=>'logTime','class'=>'ajax-form hide','method'=>'POST']); ?>


                                                <?php echo Form::hidden('project_id', $project->id); ?>


                                                <div class="form-body">
                                                    <div class="row m-t-30">
                                                        
                                                        <div class="col-md-6 ">
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->getFromJson('modules.projects.milestoneTitle'); ?></label>
                                                                <input id="milestone_title" name="milestone_title" type="text"
                                                                       class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                                <div class="form-group">
                                                                    <label><?php echo app('translator')->getFromJson('app.status'); ?></label>
                                                                    <select name="status" id="status" class="form-control">
                                                                        <option value="incomplete"><?php echo app('translator')->getFromJson('app.incomplete'); ?></option>
                                                                        <option value="complete"><?php echo app('translator')->getFromJson('app.complete'); ?></option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->getFromJson('modules.invoices.currency'); ?></label>
                                                                <select name="currency_id" id="currency_id" class="form-control">
                                                                    <option value="">--</option>
                                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->currency_code.' ('.$item->currency_symbol.')'); ?></option>           
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->getFromJson('modules.projects.milestoneCost'); ?></label>
                                                                <input id="cost" name="cost" type="number"
                                                                       class="form-control" value="0" min="0" step=".01">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="row m-t-20">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="memo"><?php echo app('translator')->getFromJson('modules.projects.milestoneSummary'); ?></label>
                                                                <textarea name="summary" id="" rows="4" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-30">
                                                    <button type="button" id="save-form" class="btn btn-success"><i
                                                                class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.save'); ?></button>
                                                    <button type="button" id="close-form" class="btn btn-default"><i
                                                                class="fa fa-times"></i> <?php echo app('translator')->getFromJson('app.close'); ?></button>
                                                </div>
                                                <?php echo Form::close(); ?>


                                                <hr>
                                            </div>
                                        </div>

                                        <div class="table-responsive m-t-30">
                                            <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                                                   id="timelog-table">
                                                <thead>
                                                <tr>
                                                    <th><?php echo app('translator')->getFromJson('app.id'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.projects.milestoneTitle'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('modules.projects.milestoneCost'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                                                    <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

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

    
    <div class="modal fade bs-modal-md in" id="editTimeLogModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>

<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script>
    var table = $('#timelog-table').dataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '<?php echo route('admin.milestones.data', $project->id); ?>',
        deferRender: true,
        language: {
            "url": "<?php echo __("app.datatable") ?>"
        },
        "fnDrawCallback": function (oSettings) {
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        },
        "order": [[0, "desc"]],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'milestone_title', name: 'milestone_title'},
            {data: 'cost', name: 'cost'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'}
        ]
    });


    $('#save-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('admin.milestones.store')); ?>',
            container: '#logTime',
            type: "POST",
            data: $('#logTime').serialize(),
            success: function (data) {
                if (data.status == 'success') {
                    $('#logTime').trigger("reset");
                    $('#logTime').toggleClass('hide', 'show');
                    table._fnDraw();
                }
            }
        })
    });

    $('#show-add-form, #close-form').click(function () {
        $('#logTime').toggleClass('hide', 'show');
    });


    $('body').on('click', '.sa-params', function () {
        var id = $(this).data('milestone-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted milestone!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {

                var url = "<?php echo e(route('admin.milestones.destroy',':id')); ?>";
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
                            table._fnDraw();
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.edit-milestone', function () {
        var id = $(this).data('milestone-id');

        var url = '<?php echo e(route('admin.milestones.edit', ':id')); ?>';
        url = url.replace(':id', id);

        $('#modelHeading').html('<?php echo e(__('app.edit')); ?> <?php echo e(__('modules.projects.milestones')); ?>');
        $.ajaxModal('#editTimeLogModal', url);

    });

    $('body').on('click', '.milestone-detail', function () {
        var id = $(this).data('milestone-id');
        var url = '<?php echo e(route('admin.milestones.detail', ":id")); ?>';
        url = url.replace(':id', id);
        $('#modelHeading').html('<?php echo app('translator')->getFromJson('app.update'); ?> <?php echo app('translator')->getFromJson('modules.projects.milestones'); ?>');
        $.ajaxModal('#editTimeLogModal',url);
    })

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/projects/milestones/show.blade.php ENDPATH**/ ?>
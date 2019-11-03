<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.css')); ?>">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <style>
        .custom-action a {
            margin-right: 15px;
            margin-bottom: 15px;
        }
        .custom-action a:last-child {
            margin-right: 0px;
            float: right;
        }
        @media  all and (max-width: 767px) {
            .custom-action a {
                margin-right: 0px;
            }

            .custom-action a:last-child {
                margin-right: 0px;
                float: none;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse p-t-10 p-b-10">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.dashboard.totalProjects'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-white"></i></li>
                    <li class="text-right"><span id="totalProjects" class="counter text-white"><?php echo e($totalProjects); ?></span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="white-box bg-success p-t-10 p-b-10">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.completedProjects'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-white"></i></li>
                    <li class="text-right"><span id="completedProjects" class="counter text-white"><?php echo e($completedProjects); ?></span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="white-box p-t-10 p-b-10 bg-info">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.inProcessProjects'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-white"></i></li>
                    <li class="text-right"><span id="inProcessProjects" class="counter text-white"><?php echo e($inProcessProjects); ?></span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="white-box p-t-10 p-b-10 bg-danger">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.tickets.overDueProjects'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-layers text-white"></i></li>
                    <li class="text-right"><span id="overdueProjects" class="counter text-white"><?php echo e($overdueProjects); ?></span></li>
                </ul>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group custom-action">
                            <a href="<?php echo e(route('admin.projects.create')); ?>" class="btn btn-outline btn-success btn-sm"><?php echo app('translator')->getFromJson('modules.projects.addNewProject'); ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="javascript:;" id="createProject" class="btn btn-outline btn-info btn-sm"><?php echo app('translator')->getFromJson('modules.projectCategory.addProjectCategory'); ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="<?php echo e(route('admin.projects.gantt')); ?>" class="btn btn-outline btn-danger btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('modules.projects.viewGanttChart'); ?></a>
                            <a href="<?php echo e(route('admin.project-template.index')); ?>"  class="btn btn-outline btn-primary btn-sm"><?php echo app('translator')->getFromJson('app.menu.addProjectTemplate'); ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="<?php echo e(route('admin.projects.archive')); ?>"  class="btn btn-outline btn-info btn-sm"><?php echo app('translator')->getFromJson('app.menu.viewArchive'); ?> <i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a href="javascript:;" onclick="exportData()" class="btn btn-info btn-sm"><i class="ti-export" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('app.exportExcel'); ?></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"><?php echo app('translator')->getFromJson('app.menu.projects'); ?> <?php echo app('translator')->getFromJson('app.status'); ?></label>
                            <select class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson('app.menu.projects'); ?> <?php echo app('translator')->getFromJson('app.status'); ?>" id="status">
                                <option selected value="all"><?php echo app('translator')->getFromJson('app.all'); ?></option>
                                <option value="complete"><?php echo app('translator')->getFromJson('app.complete'); ?></option>
                                <option value="incomplete"><?php echo app('translator')->getFromJson('app.incomplete'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"><?php echo app('translator')->getFromJson('app.clientName'); ?></label>
                            <select class="select2 form-control" data-placeholder="<?php echo app('translator')->getFromJson('app.clientName'); ?>" id="client_id">
                                <option selected value="all"><?php echo app('translator')->getFromJson('app.all'); ?></option>
                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="project-table">
                        <thead>
                        <tr>
                            <th><?php echo app('translator')->getFromJson('app.id'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.projects.projectName'); ?></th>
                            <th><?php echo app('translator')->getFromJson('modules.projects.projectMembers'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.deadline'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.client'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.completion'); ?></th>
                            <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    
    <div class="modal fade bs-modal-md in" id="projectCategoryModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
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
        <!-- /.modal-dialog -->.
    </div>
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
<script src="<?php echo e(asset('plugins/bower_components/custom-select/custom-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<script src="<?php echo e(asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bower_components/counterup/jquery.counterup.min.js')); ?>"></script>

<script>
    var table;
    $(".select2").select2({
        formatNoMatches: function () {
            return "<?php echo e(__('messages.noRecordFound')); ?>";
        }
    });
    $('.select2').val('all');
    $(function() {
        showData();

        $('body').on('click', '.archive', function(){
            var id = $(this).data('user-id');
            swal({
                title: "<?php echo app('translator')->getFromJson('messages.sweetAlertTitle'); ?>",
                text: "<?php echo app('translator')->getFromJson('messages.archiveMessage'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo app('translator')->getFromJson('messages.confirmArchive'); ?>",
                cancelButtonText: "<?php echo app('translator')->getFromJson('messages.confirmNoArchive'); ?>",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "<?php echo e(route('admin.projects.archive-delete',':id')); ?>";
                    url = url.replace(':id', id);

                    var token = "<?php echo e(csrf_token()); ?>";

                    $.easyAjax({
                        type: 'GET',
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

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('user-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted project!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "<?php echo e(route('admin.projects.destroy',':id')); ?>";
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

        $('#createProject').click(function(){
            var url = '<?php echo e(route('admin.projectCategory.create')); ?>';
            $('#modelHeading').html('Manage Project Category');
            $.ajaxModal('#projectCategoryModal',url);
        })

    });

    function initCounter() {
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });
    }

    function showData() {
        var status = $('#status').val();
        var clientID = $('#client_id').val();

        var searchQuery = "?status="+status+"&client_id="+clientID;
       table = $('#project-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: '<?php echo route('admin.projects.data'); ?>'+searchQuery,
            "order": [[ 0, "desc" ]],
            deferRender: true,
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'project_name', name: 'project_name'},
                { data: 'members', name: 'members' },
                { data: 'deadline', name: 'deadline' },
                { data: 'client_id', name: 'client_id' },
                { data: 'completion_percent', name: 'completion_percent' },
                { data: 'action', name: 'action' }
            ]
        });
    }

    $('#status').on('change', function(event) {
        event.preventDefault();
        showData();
    });

    $('#client_id').on('change', function(event) {
        event.preventDefault();
        showData();
    });

    initCounter();

    function exportData(){

        var status = $('#status').val();
        var clientID = $('#client_id').val();

        var url = '<?php echo e(route('admin.projects.export', [':status' ,':clientID'])); ?>';
        url = url.replace(':clientID', clientID);
        url = url.replace(':status', status);
        // alert(url);
        window.location.href = url;
    }

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/projects/index.blade.php ENDPATH**/ ?>
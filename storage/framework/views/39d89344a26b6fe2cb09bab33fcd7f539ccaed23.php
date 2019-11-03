<?php $__env->startSection('page-title'); ?>
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="<?php echo e($pageIcon); ?>"></i> <?php echo e(__($pageTitle)); ?></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo app('translator')->getFromJson('app.menu.home'); ?></a></li>
                <li class="active"><?php echo e(__($pageTitle)); ?></li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-script'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="white-box bg-inverse">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.dashboard.totalLeads'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-docs text-white"></i></li>
                    <li class="text-right"><span id="totalWorkingDays" class="counter text-white"><?php echo e($totalLeads); ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="white-box bg-info">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.dashboard.totalConvertedClient'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-user text-white"></i></li>
                    <li class="text-right"><span class="counter text-white"><?php echo e($totalClientConverted); ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="white-box bg-warning">
                <h3 class="box-title text-white"><?php echo app('translator')->getFromJson('modules.dashboard.totalPendingFollowUps'); ?></h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-calender text-white"></i></li>
                    <li class="text-right"><span class="counter text-white"><?php echo e($pendingLeadFollowUps); ?></span></li>
                </ul>
            </div>
        </div>

        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <a href="<?php echo e(route('admin.leads.create')); ?>" class="btn btn-outline btn-success btn-sm"><?php echo app('translator')->getFromJson('modules.lead.addNewLead'); ?> <i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="javascript:;" id="toggle-filter" class="btn btn-outline btn-danger btn-sm toggle-filter"><i
                                        class="fa fa-sliders"></i> <?php echo app('translator')->getFromJson('app.filterResults'); ?></a>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right hidden-xs">
                        <div class="form-group">
                            <a href="javascript:;" onclick="exportData()" class="btn btn-info btn-sm"><i class="ti-export" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('app.exportExcel'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="row b-b b-t" style="display: none; background: #fbfbfb;" id="ticket-filters">
                    <div class="col-md-12">
                        <h4><?php echo app('translator')->getFromJson('app.filterBy'); ?> <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('modules.lead.client'); ?></label>
                                <select class="form-control selectpicker" name="client" id="client" data-style="form-control">
                                    <option value="all"><?php echo app('translator')->getFromJson('modules.lead.all'); ?></option>
                                    <option value="lead"><?php echo app('translator')->getFromJson('modules.lead.lead'); ?></option>
                                    <option value="client"><?php echo app('translator')->getFromJson('modules.lead.client'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo app('translator')->getFromJson('modules.lead.followUp'); ?></label>
                                <select class="form-control selectpicker" name="followUp" id="followUp" data-style="form-control">
                                    <option value="all"><?php echo app('translator')->getFromJson('modules.lead.all'); ?></option>
                                    <option value="pending"><?php echo app('translator')->getFromJson('modules.lead.pending'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> <?php echo app('translator')->getFromJson('app.apply'); ?></button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> <?php echo app('translator')->getFromJson('app.reset'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                    <thead>
                    <tr>
                        <th><?php echo app('translator')->getFromJson('app.id'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.clientName'); ?></th>
                        <th><?php echo app('translator')->getFromJson('modules.lead.companyName'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.createdOn'); ?></th>
                        <th><?php echo app('translator')->getFromJson('modules.lead.nextFollowUp'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.status'); ?></th>
                        <th><?php echo app('translator')->getFromJson('app.action'); ?></th>
                    </tr>
                    </thead>
                </table>
                    </div>
            </div>
        </div>
    </div>
    <!-- .row -->
    
    <div class="modal fade bs-modal-md in" id="followUpModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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
        <!-- /.modal-dialog -->
    </div>
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer-script'); ?>
    <script src="<?php echo e(asset('plugins/bower_components/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script>
        var table;
        $(function() {
            tableLoad();
            $('#reset-filters').click(function () {
                $('#filter-form')[0].reset();
                $('#filter-form').find('select').selectpicker('render');
                tableLoad();
            })
            var table;
        $('#apply-filters').click(function () {
            tableLoad();
        });
      function tableLoad() {
          var client = $('#client').val();
          var followUp = $('#followUp').val();

           table = $('#users-table').dataTable({
              responsive: true,
              processing: true,
              serverSide: true,
              destroy: true,
              stateSave: true,
              ajax: '<?php echo route('admin.leads.data'); ?>?client='+client+'&followUp='+followUp,
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
                  { data: 'client_name', name: 'client_name' },
                  { data: 'company_name', name: 'company_name' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'next_follow_up_date', name: 'next_follow_up_date' },
                  { data: 'status', name: 'status'},
                  { data: 'action', name: 'action'}
              ]
          });
      }


            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('user-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted lead!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "<?php echo e(route('admin.leads.destroy',':id')); ?>";
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



        });

       function changeStatus(leadID, statusID){
           var url = "<?php echo e(route('admin.leads.change-status')); ?>";
           var token = "<?php echo e(csrf_token()); ?>";

           $.easyAjax({
               type: 'POST',
               url: url,
               data: {'_token': token,'leadID': leadID,'statusID': statusID},
               success: function (response) {
                   if (response.status == "success") {
                       $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
//                        table._fnDraw();
                   }
               }
           });
        }

        $('.edit-column').click(function () {
            var id = $(this).data('column-id');
            var url = '<?php echo e(route("admin.taskboard.edit", ':id')); ?>';
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                type: "GET",
                success: function (response) {
                    $('#edit-column-form').html(response.view);
                    $(".colorpicker").asColorPicker();
                    $('#edit-column-form').show();
                }
            })
        })

        function followUp (leadID) {

            var url = '<?php echo e(route('admin.leads.follow-up', ':id')); ?>';
            url = url.replace(':id', leadID);

            $('#modelHeading').html('Add Follow Up');
            $.ajaxModal('#followUpModal', url);
        }
        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })
        function exportData(){

            var client = $('#client').val();
            var followUp = $('#followUp').val();

            var url = '<?php echo e(route('admin.leads.export', [':followUp', ':client'])); ?>';
            url = url.replace(':client', client);
            url = url.replace(':followUp', followUp);

            window.location.href = url;
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/lead/index.blade.php ENDPATH**/ ?>
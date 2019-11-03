<style>
    .border-right-none{
        border-right:none !important;
    }
    .border-left-none{
        border-left:none !important;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myLargeModalLabel">@if($modalHeader == 'approved') @lang('app.approved') @elseif($modalHeader == 'pending') @lang('app.pending') @else @lang('app.upcoming') @endif @lang('app.menu.leaves') @lang('app.details')</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <td class="border-right-none">Casual</td>
                    <td class="border-left-none"><span class="label-success label">{{ $casualLeaves }}</span></td>
                    <td class="border-right-none">Sick</td>
                    <td  class="border-left-none"><span class="label-danger label">{{ $sickLeaves }}</span></td>
                    <td class="border-right-none">Earned</td>
                    <td  class="border-left-none"><span class="label-info label">{{ $earnedLeaves }}</span></td>
                </tr>
            </table>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="table-responsive">
            <table class="table" id="leave-detail-table" style="">
                <thead style="display:table; width:100%; table-layout:fixed;">
                <tr>
                    <th>@lang('modules.leaves.leaveType')</th>
                    <th>@lang('app.date')</th>
                    <th>@lang('modules.leaves.reason')</th>
                </tr>
                </thead>
                <tbody style="display:block;height:200px;overflow:auto;">
                @forelse($leaves as $key=>$leave)
                    <tr style="display:table; width:100%; table-layout:fixed;">
                        <td>
                            <label>{{ ucwords(str_replace('_', '-', $leave->type_name)) }}</label>
                        </td>
                        <td>
                            {{ $leave->leave_date->format($global->date_format) }}
                        </td>
                        <td>
                            {{ $leave->reason }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('messages.noRecordFound')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
</div>
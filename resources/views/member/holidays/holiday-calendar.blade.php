@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('member.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('member.holidays.index') }}">@lang('app.menu.holiday')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

@endpush

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-1 ">
                        <h3 class="box-title col-md-3">@lang('app.menu.holiday')</h3>
                    </div>
                    <div class="col-md-11 ">
                        <div class="form-group col-md-2 pull-right">
                            <label class="control-label">@lang('app.select') @lang('app.year')</label>
                            <select onchange="getYearData()" class="select2 form-control" data-placeholder="@lang('app.menu.projects') @lang('app.status')" id="year">
                                @forelse($years as $yr)
                                    <option @if($yr == $year) selected @endif value="{{ $yr }}">{{ $yr }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
        <div class="col-md-4 show" id="new-follow-panel" style="">
            <div class="panel panel-default">
                <div class="panel-heading "><i class="ti-calendar"></i> <span id="currentMonthName">New</span> Holidays  <div class="panel-action">
                    </div>
                </div>
                <div class="panel-wrapper collapse in">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Date</th>
                            <th>Occassion</th>
                        </tr>
                        </thead>
                        <tbody id="monthDetailData">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
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
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')

<script>

    var taskEvents = [
        @foreach($holidays as $holiday)
        {
            id: '{{ ucfirst($holiday->id) }}',
            title: function () {
                var reson = '{{ ucfirst($holiday->occassion) }}';
                if(reson){
                    return reson;
                }
                else{
                    return 'Not Define';
                }
            },
            start: '{{ $holiday->date }}',
            end:  '{{ $holiday->date }}',
            className:function(){
                var occassion = '{{ $holiday->occassion }}';
                if(occassion == 'Sunday' || occassion == 'Saturday'){
                    return 'bg-info';
                }else{
                    return 'bg-danger';
                }
            }
        },
        @endforeach
];
    var getEventDetail = function (id) {
        var url = '{{ route('member.holidays.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

     console.log(taskEvents);
    var calendarLocale = '{{ $global->locale }}';

    var date = new Date();
    var y = date.getFullYear();
    var d = date.getDate();
    var m = date.getMonth();

    var year = "{{ $year }}";

    year =  parseInt(year, 10);
    var defaultDate;

    if(y != year){
        defaultDate = new Date(year, m, d);
    }
    else{
        defaultDate = new Date(y, m, d);
    }

</script>

<script src="{{ asset('plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('js/holiday-calendar.js') }}"></script>

<script>
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    var currentMonth = new Date();
    $('#currentMonthName').html(monthNames[currentMonth.getMonth()]);
    var currentMonthData = '';

    setMonthData(currentMonth);
    $('.fc-button-group .fc-prev-button').click(function(){
        var bs = $('#calendar').fullCalendar('getDate');
        var d = new Date(bs);
        setMonthData(d);
    });


    $('.fc-button-group .fc-next-button').click(function(){
        var bs = $('#calendar').fullCalendar('getDate');
        var d = new Date(bs);
        setMonthData(d);
    });

    function setMonthData(d){

        var month_int = d.getMonth();
        var year_int = d.getFullYear();
        var firstDay = new Date(year_int, month_int, 1);

        firstDay = moment(firstDay).format("YYYY-MM-DD");

        $('#currentMonthName').html(monthNames[d.getMonth()]);

        var year = "{{ $year }}";
        var url = "{{ route('member.holidays.calendar-month') }}?startDate="+firstDay+"&year="+year;

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#monthDetailData').html(response.data);
            }
        });
    }

    function getYearData(){
        var year = $('#year').val();
        var url = "{{ route('member.holidays.calendar', ':year') }}";
        url = url.replace(':year', year);
        window.location.href = url;
    }
</script>

@endpush

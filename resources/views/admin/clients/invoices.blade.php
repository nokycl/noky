@extends('layouts.app')

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
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.clients.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.menu.invoices')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection


@section('content')

    <div class="row">


        <div class="col-md-12">
            <div class="white-box">

                <div class="row">
                    <div class="col-xs-6 b-r"> <strong>@lang('modules.employees.fullName')</strong> <br>
                        <p class="text-muted">{{ ucwords($clientDetail->name) }}</p>
                    </div>
                    <div class="col-xs-6"> <strong>@lang('app.mobile')</strong> <br>
                        <p class="text-muted">{{ $clientDetail->mobile ?? 'NA'}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('app.email')</strong> <br>
                        <p class="text-muted">{{ $clientDetail->email }}</p>
                    </div>
                    <div class="col-md-3 col-xs-6"> <strong>@lang('modules.client.companyName')</strong> <br>
                        <p class="text-muted">{{ (count($client->client) > 0) ? ucwords($client->client[0]->company_name) : 'NA'}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('modules.client.website')</strong> <br>
                        <p class="text-muted">{{ $clientDetail->website ?? 'NA' }}</p>
                    </div>
                    <div class="col-md-3 col-xs-6"> <strong>@lang('app.address')</strong> <br>
                        <p class="text-muted">{!!  (count($client->client) > 0) ? ucwords($client->client[0]->address) : 'NA' !!}</p>
                    </div>
                </div>

                {{--Custom fields data--}}
                @if(isset($fields))
                    <div class="row">
                        <hr>
                        @foreach($fields as $field)
                            <div class="col-md-4">
                                <strong>{{ ucfirst($field->label) }}</strong> <br>
                                <p class="text-muted">
                                    @if( $field->type == 'text')
                                        {{$clientDetail->custom_fields_data['field_'.$field->id] ?? ''}}
                                    @elseif($field->type == 'password')
                                        {{$clientDetail->custom_fields_data['field_'.$field->id] ?? ''}}
                                    @elseif($field->type == 'number')
                                        {{$clientDetail->custom_fields_data['field_'.$field->id] ?? ''}}

                                    @elseif($field->type == 'textarea')
                                        {{$clientDetail->custom_fields_data['field_'.$field->id] ?? ''}}

                                    @elseif($field->type == 'radio')
                                        {{ !is_null($clientDetail->custom_fields_data['field_'.$field->id]) ? $clientDetail->custom_fields_data['field_'.$field->id] : '-' }}
                                    @elseif($field->type == 'select')
                                        {{ (!is_null($clientDetail->custom_fields_data['field_'.$field->id]) && $clientDetail->custom_fields_data['field_'.$field->id] != '') ? $field->values[$clientDetail->custom_fields_data['field_'.$field->id]] : '-' }}
                                    @elseif($field->type == 'checkbox')
                                        {{ !is_null($clientDetail->custom_fields_data['field_'.$field->id]) ? $field->values[$clientDetail->custom_fields_data['field_'.$field->id]] : '-' }}
                                    @elseif($field->type == 'date')
                                        {{ isset($clientDetail->dob)?Carbon\Carbon::parse($clientDetail->dob)->format($global->date_format):Carbon\Carbon::now()->format($global->date_format)}}
                                    @endif
                                </p>

                            </div>
                        @endforeach
                    </div>
                @endif

                {{--custom fields data end--}}

            </div>
        </div>

        <div class="col-md-12">

            <section>
                <div class="sttabs tabs-style-line">
                    <div class="white-box">
                        <nav>
                            <ul>
                                <li><a href="{{ route('admin.clients.projects', $client->client[0]->user_id) }}"><span>@lang('app.menu.projects')</span></a>
                                <li class="tab-current"><a href="{{ route('admin.clients.invoices', $client->client[0]->id) }}"><span>@lang('app.menu.invoices')</span></a>
                                </li>
                                <li><a href="{{ route('admin.contacts.show', $client->client[0]->id) }}"><span>@lang('app.menu.contacts')</span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="content-wrap">
                        <section id="section-line-1" class="show">
                            <div class="row">


                                <div class="col-md-12" >
                                    <div class="white-box">
                                        <h2>@lang('app.menu.invoices')</h2>

                                        <ul class="list-group" id="invoices-list">
                                            @forelse($invoices as $invoice)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            @lang('app.invoice') # {{ $invoice->invoice_number }}
                                                        </div>
                                                        <div class="col-md-2">
                                                            {{ $invoice->currency_symbol }} {{ $invoice->total }}
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="{{ route('admin.invoices.download', $invoice->id) }}" data-toggle="tooltip" data-original-title="Download" class="btn btn-inverse btn-circle"><i class="fa fa-download"></i></a>
                                                            <span class="m-l-10">{{ $invoice->issue_date->format('d M, y') }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            No invoice for this client.
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
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

@endsection
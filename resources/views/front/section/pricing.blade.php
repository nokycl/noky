<section class="section" id="section-pricing">
    <div class="container">

        <header class="section-header">
            <h2>{{ $detail->price_title }}</h2>
            <hr>
            <p class="lead">{{ $detail->price_description }}</p>
        </header>


        <div class="text-center mb-70">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-round btn-outline btn-dark w-150 active">
                    <input type="radio" onchange="planShow('monthly')" name="pricing" value="monthly" autocomplete="off" checked> @lang('app.monthly')
                </label>
                <label class="btn btn-round btn-outline btn-dark w-150">
                    <input type="radio" onchange="planShow('yearly')" name="pricing" value="yearly" autocomplete="off"> @lang('app.annual')
                </label>
            </div>
        </div>


        {{-- <div id="monthlyPlan" class="row gap-y text-center">
            @php $color = ''; @endphp @php $btn = 'btn-primary'; @endphp
            @forelse($packages as $package)

                <div class="col-12 col-md-4">
                    <div class="pricing-1">
                        <p class="plan-name">{{ $package->name }}</p>
                        <br>
                        <h2 class="price {{ $color }}">
                            @if($package->monthly_price != 0) <span class="price-unit">{{ $global->currency->currency_symbol }}</span> @endif
                            @if($package->monthly_price == 0) free @else {{ $package->monthly_price }} @endif
                        </h2>

                        <p><small class="opacity-50">{{ $package->description }}</small></p>

                        <small>Max employees {{ $package->max_employees }}</small><br>
                        <br>
                        <p class="text-center py-3"><a class="btn {{ $btn }}" href="{{ route('front.signup.index') }}">Register</a></p>
                    </div>
                </div>
                @if($color == '')
                    @php $color = 'text-success';$btn = 'btn-success'; @endphp
                @else
                    @php $color = ''; $btn = 'btn-primary'; @endphp
                @endif
            @empty

            @endforelse
        </div>
        <div class="row gap-y text-center" style="display: none" id="annualPlan">

            @forelse($packages as $package)
                <div class="col-12 col-md-4">
                    <div class="pricing-1">
                        <p class="plan-name">{{ $package->name }}</p>
                        <br>
                        <h2 class="price {{ $color }}">
                            @if($package->annual_price != 0) <span class="price-unit">{{ $global->currency->currency_symbol }}</span> @endif
                            @if($package->annual_price == 0) free @else {{ $package->annual_price }} @endif
                        </h2>

                        <p><small class="opacity-50">{{ $package->description }}</small></p>

                        <small>Max employees {{ $package->max_employees }}</small><br>
                        <br>
                        <p class="text-center py-3"><a class="btn {{ $btn }}" href="{{ route('front.signup.index') }}">Register</a></p>
                    </div>
                </div>
                @if($color == '')
                    @php $color = 'text-success';$btn = 'btn-success'; @endphp
                @else
                    @php $color = ''; $btn = 'btn-primary'; @endphp
                @endif
            @empty

            @endforelse


        </div> --}}

        <section class="pricing-section-2 text-center monthly-packages" id="monthlyPlan">
            <div class="container">
                <div class="row justify-content-center">
    
                    <div class="col-md-2 pick-plan">
                            <div class="pricing pricing-3">
                                <div class="pricing__head boxed" >
                                    <h3>@lang('modules.frontCms.pickPlan')</h3> 
                                </div>
                                
                                <ul>
                                    <li>@lang('app.max') @lang('app.menu.employees')</li>
                                    @foreach($packageFeatures as $packageFeature)
                                        <li>
                                            <span>{{ ucwords($packageFeature) }}</span>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    @foreach ($packages as $item)
                        <div class="col-md-2 ">
                            <div class="pricing pricing-3">
                                @if($item->recommended)
                                    <div class="pricing__head bg--primary boxed background-color"> <span class="label">@lang('app.recommended')</span>
                                        <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->monthly_price }}</span>
                                        <p class="type--fine-print">@lang('modules.frontCms.perMonth'), {{ $global->currency->currency_code }}.</p>
                                    </div>
                                @else
                                    <div class="pricing__head bg--secondary boxed">
                                        <h5>{{ ucwords($item->name) }}</h5> <span class="h4"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->monthly_price }}</span>
                                        <p class="type--fine-print">@lang('modules.frontCms.perMonth'), {{ $global->currency->currency_code }}.</p>
                                    </div>
                                @endif
                                <ul>
                                    <li>{{ $item->max_employees }} &nbsp;</li>
                                    @php
                                        $packageModules = (array)json_decode($item->module_in_package);
                                    @endphp
                                    @foreach($packageFeatures as $packageFeature)
                                        <li>
                                            @if(in_array($packageFeature, $packageModules))
                                                <i class="fa fa-check-circle module-available"></i>
                                            @endif
                                            &nbsp;
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
    
                
                </div>
            </div>
        </section>
        <section class="pricing-section-2 text-center annual-packages" style="display: none" id="annualPlan">
            <div class="container">
                <div class="row justify-content-center">
    
                    <div class="col-md-2 pick-plan">
                            <div class="pricing pricing-3">
                                <div class="pricing__head boxed" >
                                    <h3>@lang('modules.frontCms.pickPlan')</h3> 
                                </div>
                                
                                <ul>
                                    <li>@lang('app.max') @lang('app.menu.employees')</li>
                                    @foreach($packageFeatures as $packageFeature)
                                        <li>
                                            <span>{{ $packageFeature }}</span>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
    
                    @foreach ($packages as $item)
                        <div class="col-md-2 " >
                            <div class="pricing pricing-3">
                                @if($item->recommended)
                                    <div class="pricing__head bg--primary boxed background-color"> <span class="label">@lang('app.recommended')</span>
                                        <h5>{{ ucwords($item->name) }}</h5> <span class="h1"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->annual_price }}</span>
                                        <p class="type--fine-print">@lang('modules.frontCms.perYear'), {{ $global->currency->currency_code }}.</p>
                                    </div>
                                @else
                                    <div class="pricing__head bg--secondary boxed">
                                        <h5>{{ ucwords($item->name) }}</h5> <span class="h4"><span class="pricing__dollar">{{ $global->currency->currency_symbol }}</span>{{ $item->annual_price }}</span>
                                        <p class="type--fine-print">@lang('modules.frontCms.perYear'), {{ $global->currency->currency_code }}.</p>
                                    </div>
                                @endif
                                <ul>
                                    <li>{{ $item->max_employees }} &nbsp;</li>
                                    @php
                                        $packageModules = (array)json_decode($item->module_in_package);
                                    @endphp
                                    @foreach($packageFeatures as $packageFeature)
                                        <li>
                                            @if(in_array($packageFeature, $packageModules))
                                                <i class="fa fa-check-circle module-available"></i>
                                            @endif
                                            &nbsp;
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
    
                    
    
                </div>
            </div>
        </section>


    </div>
</section>
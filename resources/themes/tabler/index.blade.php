@extends('theme::layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="empty">
                        <div class="empty-img"><img src="{{asset("$themeAssets/illustrations/undraw_quitting_time_dm8t.svg")}}" height="128" alt="">
                        </div>
                        {{--                        TODO 主题配置里配置可动态配置项--}}
                        <p class="empty-title">{{ $theme_index_title ?? __('To provide you with the most professional basic cloud services')}}</p>
                        <p class="empty-subtitle text-muted">
                            {{$theme_index_subtitle  ?? __('Offering the largest network in the world, you can easily scale and easily scale low latency infrastructure solutions no matter where you or your customers are located!')}}
                        </p>
                        <div class="empty-action">
                            <a href="./." class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="3" y1="21" x2="21" y2="21"></line>
                                    <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"></path>
                                    <line x1="5" y1="21" x2="5" y2="10.85"></line>
                                    <line x1="19" y1="21" x2="19" y2="10.85"></line>
                                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                                </svg>
                                {{__('Start')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <!-- Cards with tabs component -->
                <div class="card-tabs ">
                    <!-- Cards navigation -->
                    <ul class="nav nav-tabs">
                        @isset($theme_index_tab_1_title)<li class="nav-item"><a href="#tab-top-1" class="nav-link active" data-bs-toggle="tab">{{$theme_index_tab_1_title}}</a></li>@endisset
                        @isset($theme_index_tab_2_title)<li class="nav-item"><a href="#tab-top-2" class="nav-link" data-bs-toggle="tab">{{$theme_index_tab_2_title}}</a></li>@endisset
                        @isset($theme_index_tab_3_title)<li class="nav-item"><a href="#tab-top-3" class="nav-link" data-bs-toggle="tab">{{$theme_index_tab_3_title}}</a></li>@endisset
                        @isset($theme_index_tab_4_title)<li class="nav-item"><a href="#tab-top-4" class="nav-link" data-bs-toggle="tab">{{$theme_index_tab_4_title}}</a></li>@endisset
                    </ul>
                    <div class="tab-content">
                        @isset($theme_index_tab_1_title)
                            <div id="tab-top-1" class="card tab-pane active show">
                                <div class="card-body">
                                    <div class="card-title">{{$theme_index_tab_1_title}}</div>
                                    <p>
                                        {!! $theme_index_tab_1_content !!}
                                    </p>
                                </div>
                            </div>
                        @endisset
                        @isset($theme_index_tab_2_title)
                            <div id="tab-top-2" class="card tab-pane">
                                <div class="card-body">
                                    <div class="card-title">{{$theme_index_tab_2_title}}</div>
                                    <p>
                                        {!! $theme_index_tab_2_content !!}
                                    </p>
                                </div>
                            </div>
                        @endisset
                        @isset($theme_index_tab_3_title)
                            <div id="tab-top-3" class="card tab-pane">
                                <div class="card-body">
                                    <div class="card-title">{{$theme_index_tab_3_title}}</div>
                                    <p>
                                        {!! $theme_index_tab_3_content !!}
                                    </p>
                                </div>
                            </div>
                        @endisset
                        @isset($theme_index_tab_4_title)
                            <div id="tab-top-4" class="card tab-pane">
                                <div class="card-body">
                                    <div class="card-title">{{$theme_index_tab_4_title}}</div>
                                    <p>
                                        {!! $theme_index_tab_4_content !!}
                                    </p>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection

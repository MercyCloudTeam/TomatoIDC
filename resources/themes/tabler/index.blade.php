@extends('theme::layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="empty">
                        <div class="empty-img"><img src="{{asset("$themeAssets/illustrations/undraw_quitting_time_dm8t.svg")}}" height="128" alt="">
                        </div>
                        <p class="empty-title">No results found</p>
                        <p class="empty-subtitle text-muted">
                            Try adjusting your search or filter to find what you're looking for.
                        </p>
                        <div class="empty-action">
                            <a href="./." class="btn btn-primary">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                                Search again
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
                        <li class="nav-item"><a href="#tab-top-1" class="nav-link active" data-bs-toggle="tab">Tab 1</a></li>
                        <li class="nav-item"><a href="#tab-top-2" class="nav-link" data-bs-toggle="tab">Tab 2</a></li>
                        <li class="nav-item"><a href="#tab-top-3" class="nav-link" data-bs-toggle="tab">Tab 3</a></li>
                        <li class="nav-item"><a href="#tab-top-4" class="nav-link" data-bs-toggle="tab">Tab 4</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane active show">
                            <div class="card-body">
                                <div class="card-title">Content of tab #1</div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #2 -->
                        <div id="tab-top-2" class="card tab-pane">
                            <div class="card-body">
                                <div class="card-title">Content of tab #2</div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #3 -->
                        <div id="tab-top-3" class="card tab-pane">
                            <div class="card-body">
                                <div class="card-title">Content of tab #3</div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                        <!-- Content of card #4 -->
                        <div id="tab-top-4" class="card tab-pane">
                            <div class="card-body">
                                <div class="card-title">Content of tab #4</div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias aliquid distinctio dolorem expedita, fugiat hic magni molestiae molestias odit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection

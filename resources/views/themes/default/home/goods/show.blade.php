@extends('themes.default.layouts.home')

@section('content')

    <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
         style="min-height: 600px; background-image: url({{asset('assets/themes/argon/img/server-1235959.jpg')}}); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-12 col-md-10">
                    <h1 class="display-2 text-white">心动不如行动!</h1>
                    <p class="text-white mt-0 mb-5">一个虚拟主机,圆你一个网站梦立即订购吧！</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
@endsection

@section('container-fluid')
    @if(!empty($goodsCategories))
        @foreach($goodsCategories as $categories )
            <div class="row mt-5">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-transparent">
                            <h3 class="mb-0">{{$categories->title}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($categories->getGood->count())
                                    @foreach($categories->getGood as $item)
                                        @if($item->display == 1 && !empty($item->status))
                                            <div class="col-lg-3  text-center" style="margin: 3rem 0">
                                                <h2 class="card-title mb-4">{{$item->title}}</h2>
                                                <h5 class="card-subtitle mb-2">{{$item->subtitle}}</h5>
                                                <p class="card-text">{!! $item->description !!}</p>
                                                <a href="{{route('good.buy',['id'=>$item->id])}}"
                                                   class="btn btn-primary">立即购买</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="row mt-5">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0">商品</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(!empty($goods))
                            @foreach($goods  as $good)
                                <div class="col-lg-3  text-center" style="margin: 3rem 0">
                                    <h2 class="card-title mt-4">{{$good->title}}</h2>
                                    <h5 class="card-subtitle mb-2">{{$good->subtitle}}</h5>
                                    <p class="card-text ">{!! $good->description!!}</p>
                                    <a href="{{route('good.buy',['id'=>$good->id])}}" class="btn btn-primary">立即购买</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

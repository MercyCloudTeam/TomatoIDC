@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">公告</h3>
                </div>
                <div class="card-body">
                    <h1 class="text-center">{{$new->title}}</h1>
                    <h4 class="text-center">{{$new->subtitle}}</h4>
                    <p>{{$new->description}}</p>
                </div>
                <div class="card-footer py-4">
                    <a href="{{route('new.show')}}" class="btn btn-primary">返回列表</a>
                </div>
            </div>
        </div>
    </div>
@endsection

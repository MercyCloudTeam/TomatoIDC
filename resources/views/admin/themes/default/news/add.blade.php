@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">新建新闻</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('admin.new.add')}}">
                        {{csrf_field()}}
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="维护公告" value="{{old('title')}}" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">副标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="关于华南机房的维护" value="{{old('subtitle')}}" name="subtitle">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>描述</label>
                                        <textarea rows="4" class="form-control form-control-alternative"
                                                  name="description"
                                                  placeholder="时间地点.....">{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="发布">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">新建工单</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('work.order.add')}}">
                        {{csrf_field()}}
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="无法连接虚拟主机需要处理" value="{{old('title')}}" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">订单</label>
                                        <select class="custom-select" id="inputGroupSelect0312" name="order_no">
                                            @if(!empty($order = Auth::user()->order))
                                                @foreach($order as $item)
                                                    <option value="{{$item->no}}">{{$item->good->title}}-{{$item->no}}</option>
                                                @endforeach
                                            @endif
                                                <option value="" selected>不选择订单</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">优先级</label>
                                        <select class="custom-select" id="daw" name="priority">
                                            <option value="3" >
                                                高
                                            </option>
                                            <option value="2" >
                                                中
                                            </option>
                                            <option value="1" selected>
                                                低
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>描述</label>
                                        <textarea rows="4" class="form-control form-control-alternative" name="content"
                                                  placeholder="请描述一下你遇到的问题,附上商品订单号....">{{old('content')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="新建工单">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

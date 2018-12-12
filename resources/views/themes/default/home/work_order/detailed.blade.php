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
                            <h3 class="mb-0">工单详细</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="mt--3 mb-4">{{$workOrder->title}}</h2>
                    <span class="alert-inner--text"><strong>{{$workOrder->user->name}}
                            : </strong>{{$workOrder->content}}</span> <br>
                    @if(!empty($reply))
                        @foreach($reply as $item)
                            @if($item->user->admin_authority==1)
                                <div class="mt-3 text-right">
                                    <h3><span class="alert-inner--text">{{$item->content}}</span><strong> :
                                            管理员 </strong></h3>
                                </div>
                            @else
                                <div class="mt-3">
                                    <h3><span class="alert-inner--text"><strong>{{$item->user->name}}
                                                : </strong>{{$item->content}}</span></h3>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <hr class="my-4"/>
                    <h6 class="heading-small text-muted mb-4">回复工单</h6>
                    <form method="post" action="{{route('work.order.reply')}}">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$workOrder->id}}" name="id">
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-last-name">内容</label>
                                <textarea rows="4" class="form-control form-control-alternative"
                                          name="content">{{old('content')}}</textarea>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="回复">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

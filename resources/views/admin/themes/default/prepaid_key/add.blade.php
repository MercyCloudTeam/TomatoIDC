@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">生成卡密</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('admin.prepaid.key.add')}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">卡密信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">数量</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="生成多少个卡密" value="{{old('num')}}" name="num">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">金额</label>
                                        <input type="text" name="account" class="form-control form-control-alternative"
                                               value="{{old('account')}}" placeholder="卡密金额">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">有效天数</label>
                                        <input type="text" name="deadline" class="form-control form-control-alternative"
                                               value="{{old('deadline')}}" placeholder="卡密要在限定日期使用(不填为永久)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="生成">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

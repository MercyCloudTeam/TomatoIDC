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
                            <h3 class="mb-0">添加商品分组</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{url('/admin/good/categories/edit')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$categories->id}}">
                        <h6 class="heading-small text-muted mb-4">基础信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">分组标题</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="分组标题"
                                               value="{{old('title') ? old('title'): $categories->title  }}"
                                               name="title">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">分组简介</label>
                                        <input type="text" name="subtitle" class="form-control form-control-alternative"
                                               value="{{old('subtitle') ? old('subtitle'):$categories->subtitle}}"
                                               placeholder="可为空">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">排序</label>
                                        <input type="text" name="level" class="form-control form-control-alternative"
                                               value="{{old('level') ? old('level'): $categories->level}}"
                                               placeholder="值越大越靠前">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">显示</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="display">
                                            <option value="1" {{ (old('display') ? old('display'): $categories->display) == 1 ? "selected" :"" }}>
                                                显示
                                            </option>
                                            <option value="0" {{ (old('display') ? old('display'): $categories->display) == 0 ? "selected" :"" }}>
                                                隐藏
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <h6 class="heading-small text-muted mb-4">更多信息</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-last-name">分组描述</label>
                                <textarea rows="4" name="content" class="form-control form-control-alternative"
                                          placeholder="可为空">{{old('content')?old('content'):$categories->content}}</textarea>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="新增">
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

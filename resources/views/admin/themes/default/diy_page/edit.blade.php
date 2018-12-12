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
                            <h3 class="mb-0">编辑页面</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{action('DiyPageController@diyPageEditAction')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-username">Hash</label>
                                    <input type="text" class="form-control form-control-alternative"
                                           placeholder="短链" value="{{old('hash')?old('hash'):$page->hash}}"
                                           name="hash">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>内容(HTML代码会直接解析，请之行注意，防止XSS攻击的产生)</label>
                                    <textarea rows="4" class="form-control form-control-alternative"
                                              name="content"
                                              placeholder="<p>Hello World</p>">{{old('content')?old('content'):$page->content}}</textarea>
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

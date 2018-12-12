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
                            <h3 class="mb-0">添加商品</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{url('/admin/good/edit')}}">
                        <input type="hidden" name="id" value="{{$goods->id}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">基础信息</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">商品标题</label>
                                        <input type="text" class="form-control form-control-alternative" name="title"
                                               value="{{old('title') ? old('title'):$goods->title}}" placeholder="商品名称">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">价格</label>
                                        <input type="text" class="form-control form-control-alternative" name="price"
                                               value="{{old('price')? old('price') :$goods->price}}"
                                               placeholder="{{$currencyUnit}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">排序</label>
                                        <input type="text" name="level" class="form-control form-control-alternative"
                                               value="{{old('level') ? old('level'): $goods->level}}"
                                               placeholder="值越大越靠前">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">显示</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="display">
                                            <option value="1" {{ (old('display') ? old('display'): $goods->display) == 1 ? "checked" :"" }}>
                                                显示
                                            </option>
                                            <option value="0" {{ (old('display') ? old('display'): $goods->display) == 0 ? "checked" :"" }}>
                                                隐藏
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">服务器</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="server">
                                            <option value="">不配置服务器</option>
                                            @if(!empty($servers))
                                                @foreach($servers as $server)
                                                    <option
                                                            value="{{$server->id}}"
                                                            {{old('server') ? (old('server') == $server->id ? "selected" : "") : ($goods->server_id == $server->id ? "selected" : "")}}
                                                    >{{$server->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">商品分组</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="categories">
                                            <option value="">未分组</option>
                                            @if(!empty($goods_categories))
                                                @foreach($goods_categories as $category)
                                                    <option
                                                            value="{{$category->id}}"
                                                            {{old('categories') ? (old('categories') == $category->id ? "selected" : "") : ($goods->categories_id == $category->title ? "selected" : "")}}

                                                    >{{$category->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">商品配置</label>
                                        <select class="custom-select" name="configure" id="inputGroupSelect02">
                                            <option value="">不配置商品</option>
                                            @if(!empty($goodsConfigure))
                                                @foreach($goodsConfigure as $configure)
                                                    <option
                                                            value="{{$configure->id}}"
                                                            {{old('configure') ? (old('configure') == $configure->id ? "selected" : "") : ($goods->configure_id == $configure->id ? "selected" : "")}}
                                                    >{{$configure->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">商品组内升级</label>
                                        <select class="custom-select" id="wad">
                                            <option value="">未完成</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">库存</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               name="inventory"
                                               value="{{old('purchase_limit')?old('purchase_limit'):$goods->inventory}}"
                                               placeholder="商品库存，不填则为无限"
                                               oninput="value=value.replace(/[^\d]/g,'')">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">限购</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               name="purchase_limit"
                                               value="{{old('purchase_limit')?old('purchase_limit'):$goods->purchase_limit}}"
                                               placeholder="每个用户限购多少个，不填/0则为无限"
                                               oninput="value=value.replace(/[^\d]/g,'')">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">输入域名</label>
                                        <select class="custom-select" id="inputGroupSelewct02" name="domain_config">
                                            <option value="0" {{old('domain_config')?'selected':$goods->domain_config ?'selected':''}}>不需要</option>
                                            <option value="1" {{old('domain_config')?'selected':$goods->domain_config ?'selected':''}} >需要</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <h6 class="heading-small text-muted mb-4">更多信息</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-last-name">商品简介</label>
                                <textarea rows="4" class="form-control form-control-alternative" name="subtitle"
                                          placeholder="商品的简介/副标题(可为空)">{{old('subtitle')?old('subtitle'):$goods->subtitle}}</textarea>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-last-name">商品描述</label>
                                <textarea rows="4" class="form-control form-control-alternative" name="description"
                                          placeholder="商品的描述/内容(可为空)">{{old('description')?old('description'):$goods->description}}</textarea>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="编辑">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

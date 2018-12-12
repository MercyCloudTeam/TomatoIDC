@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">商品列表</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">商品名</th>
                            <th scope="col">价格</th>
                            <th scope="col">状态</th>
                            <th scope="col">分组</th>
                            <th scope="col">操作</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($goods))
                            @foreach($goods as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$item->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$item->price}} {{$currencyUnit}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                        {{$item->status}}
                      </span>
                                    </td>

                                    <td>
                                        {{$item->categories_id}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.good.edit',['id'=>$item->id])}}">编辑</a>
                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-goods-{{$item->id}}').submit();"
                                                   href="">删除</a>

                                                <form id="del-goods-{{$item->id}}"
                                                      action="{{ route('admin.good.del') }}" method="POST"
                                                      style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <a href="{{route('admin.good.add')}}" class="btn btn-primary">新增商品</a>
                    <button type="button" class="btn btn-secondary">新增自定义配置商品</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row  mt-5">
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">商品分组</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">分组名</th>
                            <th scope="col">商品数量</th>
                            <th scope="col">隐藏</th>
                            <th scope="col">排序</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($goods_categories))
                            @foreach($goods_categories as $categories)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$categories->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$categories->getGood->count()}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                              {{$categories->display ?"显示":"隐藏"}}
                      </span>
                                    </td>

                                    <td>
                                        {{$categories->level}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.good.categories.edit',['id'=>$categories->id])}}">编辑</a>
                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-goods-categories-{{$categories->id}}').submit();"
                                                   href="">删除</a>

                                                <form id="del-goods-categories-{{$categories->id}}"
                                                      action="{{ route('admin.good.categories.del') }}" method="POST"
                                                      style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$categories->id}}">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <a href="{{route('admin.good.categories.add')}}" class="btn btn-primary">新增分组</a>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">商品配置</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">分组名</th>
                            <th scope="col">商品数量</th>
                            <th scope="col">时长</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($goodsConfigure))
                            @foreach($goodsConfigure as $configure)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$configure->title}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$configure->getGood->count()}}
                                    </td>
                                    <td>
                      <span class="badge badge-dot mr-4">
                          {{$configure->time}}
                      </span>
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.good.configure.edit',['id'=>$configure->id])}}">编辑</a>
                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-goods-configure-{{$configure->id}}').submit();"
                                                   href="">删除</a>

                                                <form id="del-goods-configure-{{$configure->id}}"
                                                      action="{{ route('admin.good.configure.del') }}" method="POST"
                                                      style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$configure->id}}">
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{--<a href="{{route('admin.good.configure.add')}}" class="btn btn-primary">新增配置</a>--}}
                    <a href="{{route('admin.good.configure.add',['type'=>'virtual_host'])}}" class="btn btn-primary">新增空间配置</a>
                    <a href="{{route('admin.good.configure.add',['type'=>'virtual_private_server'])}}" class="btn btn-neutral">新增VPS配置</a>
                    <a href="" onclick="swal('未完成','该功能未完成','error')" class="btn btn-success">新增代理配置</a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">自定义页面</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">短链</th>
                            <th scope="col">内容</th>
                            {{--<th scope="col">最后更新于</th>--}}
                            {{--<th scope="col">创建于</th>--}}
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($pages))
                            @foreach($pages as $item)
                                <tr>
                                    <th scope="row">
                                        <a href="{{route('diy_page',[$item->hash])}}">{{$item->hash}}</a>
                                    </th>
                                    <td>
                                        {{substr($item->content,0,64)}}
                                    </td>
                                    {{--<td>--}}
                                    {{--                                        {{$item->updated_at}}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                    {{--                                        {{$item->created_at}}--}}
                                    {{--</td>--}}
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.diy.page.edit', ['hash'=>$item->hash])  }}">编辑</a>

                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-diy-page-{{$item->hash}}').submit();"
                                                   href="">删除</a>

                                                <form id="del-diy-page-{{$item->hash}}" action="{{ route('admin.diy.page.del') }}"
                                                      method="POST" style="display: none;">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="hash" value="{{$item->hash}}">
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
                    <a href="{{route('admin.diy.page.add')}}" class="btn btn-primary">新页面</a>
                    @if(!empty($news))
                        <nav aria-label="" class="mt-5">
                            {{ $news->links() }}
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

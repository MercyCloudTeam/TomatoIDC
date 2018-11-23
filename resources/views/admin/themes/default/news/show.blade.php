@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">新闻公告</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">标题</th>
                            <th scope="col">副标题</th>
                            <th scope="col">最后更新于</th>
                            <th scope="col">创建于</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($news))
                            @foreach($news as $item)
                                <tr>
                                    <th scope="row">
                                        {{$item->title}}
                                    </th>
                                    <td>
                                        {{$item->subtitle}}
                                    </td>
                                    <td>
                                        {{$item->updated_at->format('M d , Y')}}
                                    </td>
                                    <td>
                                        {{$item->created_at->format('M d , Y')}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.new.edit',['id'=>$item->id])}}">编辑</a>
                                                <a class="dropdown-item" onclick="event.preventDefault();
                                                        document.getElementById('del-news-{{$item->id}}').submit();"
                                                   href="">删除</a>

                                                <form id="del-news-{{$item->id}}" action="{{ route('admin.new.del') }}"
                                                      method="POST" style="display: none;">
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
                    <a href="{{route('admin.new.add')}}" class="btn btn-primary">写公告</a>
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

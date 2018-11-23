@extends('themes.default.layouts.home')
@section('content')
    @include('themes.default.layouts.header')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">公告新闻</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">标题</th>
                            <th scope="col">副标题</th>
                            <th scope="col">最后更新于</th>
                            <th scope="col">创建于</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($news))
                            @foreach($news as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <a href="{{route('new.post',['id'=>$item->id])}}"
                                                   class="mb-0 text-sm">{{$item->title}}</a>
                                            </div>
                                        </div>
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
                                </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
                <div class="card-footer py-4">
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

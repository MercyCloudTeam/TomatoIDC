@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">卡密管理</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">卡密</th>
                            <th scope="col">金额</th>
                            <th scope="col">状态</th>
                            <th scope="col">使用者</th>
                            <th scope="col">到期时间</th>
                            <th scope="col">生成时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($keys))
                            @foreach($keys as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$item->key}}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        {{$item->account}} {{$currencyUnit}}
                                    </td>
                                    <td>
                                            @switch($item->status)
                                                @case(1)
                                                未使用
                                                @break
                                                @case(2)
                                                已使用
                                                @break
                                            @endswitch
                                    </td>
                                    <td>
                                        @if(!empty($item->user_id))
                                        {{$item->user->name}}
                                            @endif
                                    </td>
                                    <td>
                                        {{$item->deadline}}
                                    </td>
                                    <td>
                                        {{$item->created_at}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if(session('key'))
                        <script>
                            swal(
                                'Success!',

                                '@foreach(session('key') as $item){{$item}} \n @endforeach',

                                'success'
                            )
                        </script>
                @endif
                <div class="card-footer py-4">
                    @if(!empty($keys))
                        <nav aria-label="" class="mb-4">
                            {{ $keys->links() }}
                        </nav>
                    @endif
                    <a href="{{route('admin.prepaid.key.add')}}" class="btn btn-primary">生成卡密</a>
                </div>
            </div>
        </div>
    </div>
@endsection

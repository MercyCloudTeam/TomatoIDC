@extends('admin.themes.default.layouts.app')

@section('content')
    @include('admin.themes.default.layouts.card')
@endsection

@section('container-fluid')
    <div class="row" id="show">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">费用配置</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">时间</th>
                            <th scope="col">价格</th>
                            <th scope="col">备注</th>
                            <th scope="col" class="text-center">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if($goods->price !== 0 && $goods->price != 9999 )
                            <tr>
                                <td>一次性</td>
                                <td>{{$goods->price}}</td>
                                <td></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" onclick="edit_page('{{$goods->id}}','disposable')"
                                                class="btn btn-primary btn-sm">修改
                                        </button>
                                        <button type="button" onclick="del_charging('{{$goods->id}}','disposable',this)"
                                                class="btn btn-warning btn-sm">删除
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif


                        @if($goods->month_price  !== 0 && !empty($goods->month_price))
                            <tr>
                                <td>固定月缴</td>
                                <td>{{$goods->month_price}}</td>
                                <td></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" onclick="edit_page('{{$goods->id}}','month_price')"
                                                class="btn btn-primary btn-sm">修改
                                        </button>
                                        <button type="button"
                                                onclick="del_charging('{{$goods->id}}','month_price',this)"
                                                class="btn btn-warning btn-sm">删除
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @if(!empty($goods->charging))
                            @foreach($goods->charging as $item)
                                <tr>
                                    <td>{{$item->time}} {{$item->unit}}</td>
                                    <td>{{$item->money}}</td>
                                    <td>{{$item->content}}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" onclick="edit_page('{{$item->id}}','multicycle')"
                                                    class="btn btn-primary btn-sm">修改
                                            </button>
                                            <button type="button"
                                                    onclick="del_charging('{{$item->id}}','multicycle',this)"
                                                    class="btn btn-warning btn-sm">删除
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <button type="button" onclick="add_configure()" class="btn btn-primary">新增费用配置</button>
                </div>
            </div>
        </div>
    </div>
    {{--编辑计费--}}
    <div class="row" id="edit-form" style="display: none">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">编辑计费规则</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="edit-form" action="{{route('admin.good.charging.edit')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$goods->id}}">
                        <div class="pl-lg-4" id="multicycle_edit" style="display: none">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="5" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">时间</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="30" value="{{old('time')}}" name="time">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">时间单位</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="unit">
                                            <option value="day">天</option>
                                            <option value="month">月</option>
                                            <option value="year">年</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="30天限时套餐" value="{{old('content')}}" name="content">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4" id="disposable_edit" style="display: none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="一次性付费价格" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4" id="month_price_edit" style="display: none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="每月付费多少" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="编辑">
                        <button type="button" onclick="show()" class="btn btn-secondary">列表</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{--编辑计费结束--}}

    {{--新镇计费--}}
    <div class="row" id="form" style="display: none">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-0">新建计费规则</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" id="add-form" action="{{route('admin.good.charging.add')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$goods->id}}">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">计费方式</label>
                                        <select class="custom-select" id="charging" onchange="add_from_select()"
                                                id="inputGroupSelect02" name="type">
                                            <option value="">未选择-重选请刷新</option>
                                            <option value="multicycle">包年包月</option>
                                            <option value="disposable">一次性付费</option>
                                            {{--<option value="disposable">按量付费</option>--}}
                                            <option value="month_price">固定月缴</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4" id="multicycle" style="display: none">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="5" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">时间</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="30" value="{{old('time')}}" name="time">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">时间单位</label>
                                        <select class="custom-select" id="inputGroupSelect02" name="unit">
                                            <option value="day">天</option>
                                            <option value="month">月</option>
                                            <option value="year">年</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>备注</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="30天限时套餐" value="{{old('content')}}" name="content">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4" id="disposable" style="display: none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="一次性付费价格" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4" id="month_price" style="display: none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">价格</label>
                                        <input type="text" class="form-control form-control-alternative"
                                               placeholder="每月付费多少" value="{{old('price')}}" name="price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.themes.default.layouts.errors')
                        <input type="submit" class="btn btn-primary" value="新增">
                        <button type="button" onclick="show()" class="btn btn-secondary">列表</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{--新镇计费end--}}
    <script>
        function add_configure() {
            document.getElementById('show').style.display = "none";
            document.getElementById('form').style.display = "block";
        }

        function show() {
            document.getElementById('form').style.display = "none";
            document.getElementById('show').style.display = "block";
        }


        function add_from_select() {
            var obj = document.getElementById("charging");
            var status = obj.selectedIndex;
            if (status == 1) {
                // document.getElementById('money_price').style.display = "none";
                document.getElementById('multicycle').style.display = "block";
                $('#month_price').remove();
                $('#disposable').remove();
                // document.getElementById('disposable').style.display = "none";
            }
            if (status == 2) {
                // document.getElementById('money_price').style.display = "none";
                // document.getElementById('multicycle').style.display = "none";
                $('#month_price').remove();
                $('#multicycle').remove();
                document.getElementById('disposable').style.display = "block";
            }
            if (status == 3) {
                document.getElementById('month_price').style.display = "block";
                // document.getElementById('multicycle').style.display = "none";
                // document.getElementById('disposable').style.display = "none";

                $('#multicycle').remove();
                $('#disposable').remove();
                // document.getElementById('disposable').style.display = "none";
            }
        }

        function del_charging(id, type, obj) {
            obj.setAttribute('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{route('admin.good.charging.del')}}',
                dataType: 'json',
                async: true,
                data: {
                    "id": id,
                    "type": type
                },
                success: function (data) {
                    // obj.removeAttribute("disabled");
                    obj.innerHTML = "删除成功";
                    console.log(data);
                    swal('成功', '操作成功', 'success')
                },
                error: function (data) {
                    if (data.status != 200) {
                        swal('失败', '出现奇怪的错误了', 'error');
                        console.log(data);
                        obj.removeAttribute("disabled");
                    }
                    // console.log(data);
                }
            });
        }

        function edit_page(id, type) {
            swal('测试出现BUG','暂不开放此功能，请删除再新镇，李姐万岁','error')
            //
            // if (type == 'disposable') {
            //     document.getElementById('show').style.display="none";
            //     document.getElementById('edit-form').style.display="block";
            //     $('#multicycle_edit').remove();
            //     $('#month_price_edit').remove();
            //     document.getElementById('disposable_edit').style.display="block";
            // }
            // if (type == 'multicycle'){
            //     document.getElementById('show').style.display="none";
            //     document.getElementById('edit-form').style.display="block";
            //     $('#month_price_edit').remove();
            //     $('#disposable_edit').remove();
            //     document.getElementById('multicycle_edit').style.display="block";
            // }
            // if (type == 'month_price'){
            //     document.getElementById('show').style.display="none";
            //     document.getElementById('edit-form').style.display="block";
            //     $('#multicycle_edit').remove();
            //     $('#disposable_edit').remove();
            //     document.getElementById('month_price_edit').style.display="block";
            // }
        }
    </script>

    @if ($errors->any())
        <script>
            swal({
                type: 'error',
                title: '错误',
                html: '填写的信息有错误',
            });
            add_configure()
        </script>
    @endif
@endsection

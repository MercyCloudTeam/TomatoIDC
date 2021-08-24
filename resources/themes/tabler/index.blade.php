@extends('theme::layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div id="carousel-indicators" class="carousel slide" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#carousel-indicators" data-bs-slide-to="0" class=""></li>
                                <li data-bs-target="#carousel-indicators" data-bs-slide-to="1" class="active" aria-current="true"></li>
                                <li data-bs-target="#carousel-indicators" data-bs-slide-to="2" class=""></li>
                                <li data-bs-target="#carousel-indicators" data-bs-slide-to="3" class=""></li>
                                <li data-bs-target="#carousel-indicators" data-bs-slide-to="4" class=""></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt="" src="./static/photos/8c13ad59f739558c.jpg">
                                </div>
                                <div class="carousel-item active">
                                    <img class="d-block w-100" alt="" src="./static/photos/8fdeb4785d2b82ef.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt="" src="./static/photos/9f36332564ca271d.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt="" src="./static/photos/35b88fc04a518c1b.jpg">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" alt="" src="./static/photos/36e273986ed577b8.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    @include('theme::common.price')
@endsection
@section('script')

@endsection

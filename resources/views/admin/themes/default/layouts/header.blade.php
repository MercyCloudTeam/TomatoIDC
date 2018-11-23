<!-- Header -->
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
     style="min-height: 600px; background-image: url({{asset('assets/themes/argon/img/computer-1149148.jpg')}}); background-size: cover; background-position: center top;">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
                <p class="text-white" style="font-size: 1rem">欢迎回来</p>
                <h1 class="display-2 text-white">{{Auth::user()->name}}</h1>
                <p class="text-white mt-0 mb-5">祝你开心每一天！</p>
            </div>
        </div>
    </div>
</div>

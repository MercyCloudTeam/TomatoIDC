@extends('themes.default.layouts.layout')

@section('content')
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">邮箱验证</h1>
                        <p class="text-lead text-light">请前往邮箱查看验证邮件</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted">
                            未收到邮件?
                        </div>
                        <div class="text-center">
                            <button id="sendMail" onclick="sendMail()" class="btn btn-primary my-4 ">发送邮件</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var countdown=60;
        function setTime(val) {
            if (countdown == 0) {
                val.removeAttribute("disabled");
                val.innerHTML = "重新发送";
                countdown = 60;
            } else {
                val.setAttribute("disabled", true);
                val.innerHTML = "重新发送(" + countdown + ")";
                countdown--;
                setTimeout(function () {
                    setTime(val)
                }, 1000)
            }
        }

        function sendMail() {
            setTime(document.getElementById('sendMail'));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{route('user.email.validate.action')}}',
                dataType: 'json',
                async: 'false',    //同步
                success: function (data) {
                },
                error: function (data) {
                    if (data.status !=200) {
                        swal('错误','请休息一会','error');
                        console.log(data);
                    }
                    // console.log(data);
                }
            });
        }
    </script>
@endsection
<footer class="footer footer-transparent d-print-none">
    <div class="container">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="{{route('policy.show')}}" class="link-secondary">{{__('Policy')}}</a></li>
                    <li class="list-inline-item"><a href="{{route('terms.show')}}" class="link-secondary">{{__('Terms')}}</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        @if(isset($theme_copyright) &&  (bool)$theme_copyright !== false ) {{__('Theme Design from')}} <a class="link-secondary" href="https://github.com/tabler/tabler">tabler</a> @endif
                        @if(isset($site_power_by) && (bool)$site_power_by !== false ) <a class="link-secondary" href="">{{__('Powered by HStack')}}</a> @endif  <br>
                        Copyright &copy; {{date('Y')}}
                        <a href="." class="link-secondary">{{env('APP_NAME')}}</a>.
                        All rights reserved.
                    </li>
                    {{--                    <li class="list-inline-item">--}}
                    {{--                        <a href="" class="link-secondary" rel="noopener">v1.0.0</a>--}}
                    {{--                    </li>--}}
                </ul>
            </div>
        </div>
    </div>
</footer>

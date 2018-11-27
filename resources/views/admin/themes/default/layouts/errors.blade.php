@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" style="margin-top: 2rem" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif

@if(session('status'))
    @if(session('status') == 'success')
        <script>
            swal(
                'Success!',
                '操作成功!',
                'success'
            )
        </script>
    @else
        <script>
            swal({
                title: '失败',
                text: '操作失败',
                type: 'error',
            })
        </script>
    @endif
@endif
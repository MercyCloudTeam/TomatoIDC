@if ($errors->any())
<script>
    swal({
        type: 'error',
        title: '错误',
        text: @foreach ($errors->all() as $error)
                '{{ $error }}',
              @endforeach
        footer: '<a href="{{$websiteKfUrl}}" >无法解决这个问题,联系客服?</a>'
    })
</script>
@endif

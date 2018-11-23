@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" style="margin-top: 2rem" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif

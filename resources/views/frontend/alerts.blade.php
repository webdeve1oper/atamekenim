@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    @if(is_array($message))
        @foreach($message as $mess)
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            @if(is_array($mess))
                @foreach($mess as $m)
                    @if(is_array($m))
                            @foreach($m as $m2)
                                <strong>{{ $m2 }}</strong>
                            @endforeach
                        @else
                            <strong>{{ $m }}</strong>
                    @endif
                @endforeach
            @else
                <strong>{{ $mess }}</strong>
            @endif

        </div>
        @endforeach
    @else
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Пожалуйста проверьте правильность заполнения формы
    </div>
@endif

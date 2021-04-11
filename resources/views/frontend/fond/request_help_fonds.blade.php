@foreach($relatedFonds as $relatedFond)
    <div class="col-4">
        <img src="{{$relatedFond->logo ?? '/img/no-photo.png'}}" alt="">
        <h5>{!! $relatedFond->title !!}</h5>
    </div>
@endforeach
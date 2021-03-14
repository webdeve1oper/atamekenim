<div class="row">
    <div class="col-sm-6">
        <p class="name">Ими гордится страна</p>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                За все время
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">За все время</a>
                <a class="dropdown-item" href="#">За все время</a>
                <a class="dropdown-item" href="#">За все время</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="paginationBlock">
            @if(method_exists($fonds,'links'))
                @if($fonds->lastPage() > 1)
                    <ul class="pagination">
                        @for ($i = 1; $i <= $fonds->lastPage(); $i++)
                            <li class="page-item {{ ($fonds->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $fonds->url($i) }}">{{$i}}</a>
                            </li>
                        @endfor
                        <li class="page-item">
                            <a class="page-link arrows" href="{{ $fonds->url(1) }}" rel="prev" aria-label="pagination.previous">‹</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link arrows" href="{{ $fonds->url($fonds->currentPage()+1) }}" rel="next" aria-label="pagination.next">›</a>
                        </li>
                    </ul>
                @endif
            @endif
        </div>
    </div>
    <div class="col-sm-12">
        <div class="organizationsList">
            @foreach($fonds as $key=> $fond)
                <div class="item">
                    <ul>
                        <li><p class="number">{{$key+1}}</p></li>
                        <li>
                            @if($fond->logo)
                                <img src="{{$fond->logo}}" alt="" class="logotype">
                            @else
                                <img src="/img/no-photo.png" alt="" class="logotype">
                            @endif
                        </li>
                        <li><a href="/fond/{{$fond->id}}" class="name">{{$fond->title}}</a></li>
                        <li><p>5 000 000 тг</p></li>
                        <li><p>@foreach($fond->baseHelpTypes()->get() as $help){{$help->name_ru}}, @endforeach</p></li>
                        <?php $city = $fond->city; ?>
                        <li><p>@if($city)г. {{$city->title_ru}}@endif</p></li>
                        <li><p>Отзывы (0)</p></li>
                        {{--<li><p class="green">95%</p></li>--}}
                    </ul>
                </div>
            @endforeach

        </div>
    </div>
</div>
<script>
    $('.paginationBlock .pagination a').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, $('#formSearch').serialize(), function(data){
            $('#fond_lists').html(data);
        });
    });
</script>
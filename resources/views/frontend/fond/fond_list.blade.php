<div class="col-sm-12">
    @foreach($fonds as $fond)
        <div class="organizationBigBlock">
            <div class="row">
                <div class="col-sm-2">
                    @if($fond->logo)
                        <img src="{{$fond->logo}}" alt="" class="logotype">
                    @else
                        <img src="/img/no-photo.png" alt="" class="logotype">
                    @endif
                </div>
                <div class="col-sm-6">
                    {{$registered_at = \Carbon\Carbon::parse($fond->created_at)}}
                    <p class="name">{{$fond->title }} <span>Общественное объединение</span> @if($registered_at > \Carbon\Carbon::today()->subDays(30))<span class="tagNew">Новая</span>@endif</p>
                    <div class="mobileBlockInfo d-table d-sm-none">
                        <p class="greyText">Рейтинг: <span class="green">95</span></p>
                        <p class="greyText">Сумма сбора: <span class="blue">3.5 млрд. тг.</span></p>
                        <a href="" class="miniInfo">Отзывы: {{$fond->reviews()->count()}}</a>
                        <p class="miniInfo">{{$fond->helpsByStatus('finished')->count()}} закрытых заявок</p>
                    </div>
                    <ul class="first">
                        <li>
                            <p>Основная деятельность: <a href="">@foreach($fond->baseHelpTypes as $i => $help)@if($i==2) @break @endif{{$help['name_'.app()->getLocale()]}},@endforeach ...</a></p>
                        </li>
                        <li>
                            <p>Регион работы: <a href="">Весь Казахстан</a></p>
                        </li>
                    </ul>
                    <ul class="second">
                        <li>
                            <p>Дата создания организации: <span>{{\Carbon\Carbon::parse($fond->foundation_date)->format('d-m-Y')}}</span></p>
                        </li>
                        <li>
                            <p>Дата регистрации на портале: <span>{{$registered_at->diffForHumans()}}</span></p>
                        </li>
                    </ul>
                    <p class="missionText">Миссия ОО «Менің Атамекенім»^ осуществляет проекты, направленные на формирование культуры благотворительности и меценатства среди населения Республики Казахстан...</p>
                </div>
                <div class="col-sm-2 miniStatusBlock">
                    <p class="greyText">Рейтинг: <span class="green">95</span></p>
                    <a href="" class="miniInfo">Отзывы: {{$fond->reviews()->count()}}</a>
                </div>
                <div class="col-sm-2 bigStatusBlock">
                    <p class="greyText">Сумма сбора: <span class="blue">3.5 млрд. тг.</span></p>
                    <p class="miniInfo">{{$fond->helpsByStatus('finished')->count()}} закрытых заявок</p>
                </div>

                <div class="col-sm-2"></div>
                <div class="col-sm-6">
                    <a href="{{route('innerFond', [$fond->id])}}" class="btn-default">Подробнее о фонде <span class="miniArrow">›</span></a>
                    <button class="btn-default blue" @if(Auth::user()) onclick="$('#helpfond input#fond_id').val({{$fond->id}}); $('#helpCallback').modal()" @else onclick="window.location = '{{route('login')}}'" @endif> Подать заявку на получение помощи</button>
                </div>
                <div class="col-sm-4">
                    <a href="{{route('innerFond', [$fond->id])}}" class="btn-default red"><img src="/img/help.svg" alt=""> Подробнее о фонде <span class="miniArrow">›</span></a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="col-sm-6">
    <div class="paginationBlock">
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
    </div>
</div>

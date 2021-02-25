<div class="col-sm-12">
    @foreach($helps as $help)
        <div class="organizationBigBlock humanInfo">
            <div class="row">
                <div class="col-sm-2">
                    <img src="/img/avatar.jpg" alt="" class="logotype">
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-9 infoBlock">
                            @if(Auth::guard('fond')->check())
                                <p class="name">{{$help->user->first_name}},  {{\Carbon\Carbon::parse($help->user->born)->age }} лет</p>
                            @else
                                <p class="name">{{$help->user->gender=='male'?'Мужчина':$help->user->gender=='female'?'Женщина':'Не указано'}},  {{\Carbon\Carbon::parse($help->user->born)->age ?? 'не указано' }} лет</p>
                            @endif
                            <p>

                                @foreach($help->baseHelpTypes()->get() as $baseHelp)
                                    <a href="">{{$baseHelp->name_ru}},</a>
                                @endforeach
                                @foreach($help->addHelpTypes()->get() as $baseHelp)
                                    <a href="">{{$baseHelp->name_ru}},</a>
                                @endforeach
                            </p>
                            <p>{!! mb_substr($help->body, 0,100) !!}</p>
                            <p>Закрытых заявок: <span>{{$help->user->helpsByStatus('finished')->count()}}</span></p>
                        </div>
                        <div class="col-sm-3 rightBlock">
                            <p class="greyText red"><span>Кризисный 70 баллов</span></p>
                        </div>
                        <div class="col-sm-9"><a href="" class="btn-default">Подробнее <span class="miniArrow">›</span></a></div>
                        @if($help->status != 'finished')
                            <div class="col-sm-3 rightBlock"><button class="btn-default blue">Поддержать</button></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="col-sm-6">
    <div class="paginationBlock">
        <ul class="pagination">
            @if($helps->lastPage() > 1)
                <ul class="pagination">
                    @for ($i = 1; $i <= $helps->lastPage(); $i++)
                        <li class="page-item {{ ($helps->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $helps->url($i) }}">{{$i}}</a>
                        </li>
                    @endfor
                    <li class="page-item">
                        <a class="page-link arrows" href="{{ $helps->url(1) }}" rel="prev" aria-label="pagination.previous">‹</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link arrows" href="{{ $helps->url($helps->currentPage()+1) }}" rel="next" aria-label="pagination.next">›</a>
                    </li>
                </ul>
            @endif
        </ul>
    </div>
</div>
<div class="col-sm-6">

</div>

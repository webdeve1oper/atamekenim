@if(count($fondsByPoints)>0)
    <div class="row mt-5">
        @foreach($fondsByPoints as $key => $fondsByPoint)
            <?php
            if($key == 0){
                $coincidence = 100;
            }else{
                $coincidence = round($fondsByPoint['points'] / $fondsByPoints[0]['points'] * 100);
                if($coincidence < 45){
                    continue;
                }
            }
            ?>
            <div class="organizationBigBlock col-sm-4 mb-4">
                <div class="col-12 card p-3">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <b>Соответсвие:</b> {{  $coincidence }}%
                        </div>
                        <div class="col-sm-4 offset-sm-4">
                            @if($fondsByPoint['logo'])
                                <img src="{{$fondsByPoint['logo']}}" height="200" alt="" class="logotype">
                            @else
                                <img src="/img/no-photo.png" alt="" class="logotype">
                            @endif
                        </div>
                        <div class="col-sm-10 offset-sm-1 mt-3">
                            <?php $registered_at = \Carbon\Carbon::parse($fondsByPoint['created_at']); ?>
                            <p class="name">{{$fondsByPoint['title_'.lang()] ?? $fondsByPoint['title_ru']}} <span>Общественное объединение</span></p>
                            <div class="mobileBlockInfo d-table d-sm-none">
                                <p class="greyText">Рейтинг: <span class="green">95</span></p>
                                <p class="greyText">Сумма сбора: <span class="blue">3.5 млрд. тг.</span></p>
                            </div>
                            <ul class="second">
                                <li>
                                    <p>Дата создания организации: <span>{{\Carbon\Carbon::parse($fondsByPoint['foundation_date'])->format('d-m-Y')}}</span></p>
                                </li>
                                <li>
                                    <p>Дата регистрации на портале: <span>{{$registered_at->diffForHumans()}}</span></p>
                                </li>
                            </ul>
                            <p class="missionText">{!! mb_substr(strip_tags($fondsByPoint['about_ru']), 0, 150) !!}...</p>
                        </div>

                        <div class="col-sm-8">
                            <a href="{{route('innerFond', [$fondsByPoint['id']])}}" class="btn-default">{{trans('fonds.more-org')}} <span class="miniArrow">›</span></a>
                        </div>
                        <div class="col-sm-4">
                            <input class="custom" type="checkbox" onchange="if($(this).is(':checked')){help_fond.push({{$fondsByPoint['id']}});$('#help_fond').val(help_fond)}else{
                                var index = help_fond.indexOf({{$fondsByPoint['id']}});
                                if (index > -1) {
                                    help_fond.splice(index, 1);
                                }$('#help_fond').val(help_fond);
                                }">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12 text-center">
            <button class="btn btn-default" onclick="$('#request_help').submit()">
                Отправить
            </button>
        </div>
    </div>
    @else
    <div class="col-sm-12">
            <div class="organizationBigBlock">
                <h4>К сожалению ничего не найдено</h4>
            </div>
    </div>
    @endif
<style>
    .organizationsInBlock .organizationBigBlock img.logotype{
        width: 80px;
        height: initial;
        margin: auto;
    }

</style>

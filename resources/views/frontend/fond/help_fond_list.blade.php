@if(count($fondsByPoints)>0)
    <div class="col-sm-12">
        @foreach($fondsByPoints as $fondsByPoint)
            <div class="organizationBigBlock">
                <div class="row">
                    <div class="col-sm-2">
                        @if($fondsByPoint['logo'])
                            <img src="{{$fondsByPoint['logo']}}" alt="" class="logotype">
                        @else
                            <img src="/img/no-photo.png" alt="" class="logotype">
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <?php $registered_at = \Carbon\Carbon::parse($fondsByPoint['created_at']); ?>
                        <p class="name">{{$fondsByPoint['title_'.lang()]??$fondsByPoint['title_ru']}} <span>Общественное объединение</span></p>
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

                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <a href="{{route('innerFond', [$fondsByPoint['id']])}}" class="btn-default">{{trans('fonds.more-org')}} <span class="miniArrow">›</span></a>
                        <button class="btn-default blue" @if(Auth::user()) onclick="$('#helpfond input#fond_id').val({{$fondsByPoint['id']}}); $('#helpCallback').modal()" @else onclick="window.location = '{{route('login')}}'" @endif> {{trans('fonds.req-help')}}</button>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('innerFond', [$fondsByPoint['id']])}}" class="btn-default red"><img src="/img/help.svg" alt=""> {{trans('fonds.supp-org')}} <span class="miniArrow">›</span></a>
                    </div>
                </div>
            </div>
        @endforeach
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

@if(count($fonds)>0)
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
                        <?php $registered_at = \Carbon\Carbon::parse($fond->created_at); ?>
                        <p class="name">{{$fond['title_'.lang()]??$fond['title_ru']}} <span>Общественное объединение</span> @if($registered_at > \Carbon\Carbon::today()->subDays(30))<span class="tagNew">Новая</span>@endif</p>
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
{{--                                <p>Регион работы: @if(array_key_exists('region_id', $fond->region))<a href="#" onclick="$('#regions{{$fond->region['region_id']}}').attr('checked', true);$('#fonds_filter').submit();">{{$fond->region['title_ru']}}</a>@endif</p>--}}
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
                        <p class="missionText">{!! mb_substr(strip_tags($fond->about_ru), 0, 150) !!}...</p>
                    </div>
                    <div class="col-sm-2 miniStatusBlock">
                        {{--<p class="greyText">Рейтинг: <span class="green">95</span></p>--}}
                        <a href="" class="miniInfo">Отзывы: {{$fond->reviews()->count()}}</a>
                    </div>
                    <div class="col-sm-2 bigStatusBlock">
                        {{--<p class="greyText">Сумма сбора: <span class="blue">3.5 млрд. тг.</span></p>--}}
                        <p class="miniInfo">{{$fond->helpsByStatus('finished')->count()}} закрытых заявок</p>
                    </div>

                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <a href="{{route('innerFond', [$fond->id])}}" class="btn-default">{{trans('fonds.more-org')}} <span class="miniArrow">›</span></a>
{{--                        <button class="btn-default blue" @if(Auth::user()) onclick="$('#helpfond input#fond_id').val({{$fond->id}}); $('#helpCallback').modal()" @else onclick="window.location = '{{route('login')}}'" @endif> {{trans('fonds.req-help')}}</button>--}}
                        <a class="btn-default blue" href="{{route('request_help')}}"> {{trans('fonds.req-help')}}</a>
                    </div>
                    <div class="col-sm-4">
{{--                        <a href="{{route('innerFond', [$fond->id])}}" class="btn-default red"><img src="/img/help.svg" alt=""> {{trans('fonds.supp-org')}} <span class="miniArrow">›</span></a>--}}
                    </div>
                </div>
            </div>
        @endforeach
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
    <div class="col-sm-6 rightBlock">
        <a href="{{route('registration_fond')}}" class="btn-default blue">{{trans('fonds.reg-reestr')}}</a>
{{--        <button class="btn-default">{{trans('fonds.more-analytics')}}</button>--}}
    </div>
    @else
    <div class="col-sm-12">
            <div class="organizationBigBlock">
                <h4>К сожалению ничего не найдено</h4>
            </div>
    </div>
    @endif

    <script>
        $(' .total').text({{$fonds->total()}});
        $('.paginationBlock .pagination a').on('click', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            $('.preloader').show();
            $.get(url, $('#fonds_filter').serialize(), function(data){
                $('.preloader').hide();
                $('#fond_lists').html(data);
            });
        });
    </script>
<style>
    .organizationsInBlock .organizationBigBlock img.logotype{
        width: 80px;
        height: initial;
        margin: auto;
    }
</style>

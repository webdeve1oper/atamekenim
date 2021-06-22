<?php
$fondRegions = $project->regions()->get();
if ($fondRegions) {
    $fondRegions = $fondRegions->toArray();
    $fondRegions = array_column($fondRegions, 'region_id');
}
$fondcities = $project->cities()->get();
if ($fondcities) {
    $fondcities = $fondcities->toArray();
    $fondcities = array_column($fondcities, 'city_id');
}
$fonddistricts = $project->districts()->get();
if ($fonddistricts) {
    $fonddistricts = $fonddistricts->toArray();
    $fonddistricts = array_column($fonddistricts, 'district_id');
}
?>
@foreach($regions as $region)
    <!--Регионы-->
    @if(count($region['districts'])>0)
        <div class="optionBlock">
            <a class="toggleButton" onclick="$(this).siblings('.inOptionBlock').toggle();$(this).toggleClass('opened');"><i class="fas fa-chevron-down"></i></a>
            <div class="inputBlock @if(in_array($region->region_id, $fondRegions)) active @endif" id="region_{{$region->region_id}}"><input id="{{$region->region_id}}"
                                                                                                                                            @if(in_array($region->region_id, $fondRegions)) checked
                                                                                                                                            @endif value="{{$region->region_id}}" type="checkbox"
                                                                                                                                            name="region[]"><span class="regionText">{{$region->title_ru}}</span></div>
            <div class="inOptionBlock">
                <!--Район-->
                @foreach($region['districts'] as $district)
                    @if(count($district['cities'])>0)
                        <div class="optionBlock">
                            <a class="toggleButton" onclick="$(this).siblings('.thirdInOptionBlock').toggle();$(this).toggleClass('opened');"><i class="fas fa-chevron-down"></i></a>
                            <div class="inputBlock @if(in_array($district->district_id, $fonddistricts)) active @endif" id="district_{{$district->district_id}}"
                                 onclick="$('.inputBlock.active#region_{{$region->region_id}}').trigger('click')"><input id="{{$district->district_id}}" value="{{$district->district_id}}"
                                                                                                                         @if(in_array($district->district_id, $fonddistricts)) checked @endif type="checkbox"
                                                                                                                         name="district[]"><span class="districtText">{{$district->text}}</span></div>
                            <div class="inOptionBlock thirdInOptionBlock">
                                <!--Город/Село-->
                                @foreach($district['cities'] as $city)
                                    <div class="optionBlock">
                                        <div class="inputBlock @if(in_array($city->city_id, $fondcities)) active @endif" onclick="$('.inputBlock.active#region_{{$region->region_id}}').trigger('click');$('.inputBlock.active#district_{{$district->district_id}}').trigger('click');"
                                             id="city_{{$city->city_id}}"><input id="{{$city->city_id}}" @if(in_array($city->city_id, $fondcities)) checked @endif value="{{$city->city_id}}" type="checkbox"
                                                                                 name="city[]"><span class="cityText">{{$city->title_ru}}</span></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="optionBlock">
                            <div class="inputBlock @if(in_array($district->district_id, $fonddistricts)) active @endif" onclick="$('.inputBlock.active#region_{{$district->district_id}}').trigger('click')"
                                 id="district_{{$district->district_id}}"><input id="{{$district->district_id}}" value="{{$district->district_id}}" @if(in_array($district->district_id, $fonddistricts)) checked
                                                                                 @endif type="checkbox" name="district[]"><span class="districtText">{{$district->text}}</span></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else

        <div class="optionBlock">
            <div class="inputBlock @if(in_array($region->region_id, $fondRegions)) active @endif" id="region_{{$region->region_id}}">
                <input id="{{$region->region_id}}" @if(in_array($region->region_id, $fondRegions)) checked @endif  value="{{$region->region_id}}" type="checkbox" name="region[]"><span class="regionText">{{$region->title_ru}}</span></div>
        </div>
    @endif
@endforeach

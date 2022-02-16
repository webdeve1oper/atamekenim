<script>
    var json = {!! $regions->toJson() !!};
    var jsonHelps = {!! $baseHelpTypes->toJson() !!};
    var scenarios = {!! json_encode($scenarios) !!};
    var destinations = null;
    var addHelpTypes = null;
    var cashHelpTypes = null;
    var whoNeedHelp = null;
    var region = null;
    var city = null;
    var district = null;
    var cashHelpSize = null;
    var helpUrgencyDate = null;
    @if($help)
    destinations = {!! json_encode($help->destinations()->pluck('id')) !!};
    addHelpTypes = {!! json_encode($help->addHelpTypes()->pluck('id')) !!};
    cashHelpTypes = {!! json_encode($help->cashHelpTypes()->pluck('id')) !!};
    whoNeedHelp = {{$help->whoNeedHelp->id}};
    region = {{$help->region->region_id}};
    city = {!! $help->city->city_id??'""' !!};
    district = {!! $help->district->district_id??'""' !!};
    cashHelpSize = {!! $help->cashHelpSize->cash_help_size_id??'""' !!};
    helpUrgencyDate = {!! $help->urgency_date??'""' !!};
    @else
    @if(old('destinations'))
         destinations = {!! json_encode(old('destinations')) !!};
    @endif
    @if(old('addHelpTypes'))
         addHelpTypes = {!! json_encode(old('addHelpTypes')) !!};
    @endif
    @if(old('cashHelpTypes'))
         cashHelpTypes = {!! json_encode(old('cashHelpTypes')) !!};
    @endif
    @if(old('whoNeedHelp'))
         whoNeedHelp = {{old('whoNeedHelp') }};
    @endif
    @if(old('region'))
         region = {{old('region') }};
    @endif
    @if(old('city'))
        city = {{old('city') }};
    @endif
    @if(old('district'))
        district = {{old('district') }};
    @endif
    @if(old('cashHelpSize'))
        cashHelpSize = {{old('cashHelpSize') }};
    @endif
    @endif

    $('#destionations').select2({
        width: '100%',
        placeholder: 'Адресат помощи'
    });
    $('#regions').select2({
        width: '100%',
        placeholder: 'Область'
    });
    $('#districts').select2({
        width: '100%',
        placeholder: 'Район'
    });
    $('#cities').select2({
        width: '100%',
        placeholder: 'Город/Село'
    });
    $('#cashHelpTypes').select2({
        width: '100%',
        placeholder: 'Виды оказываемой помощи'
    });
    $('#cashHelpSizes').select2({
        width: '100%',
        placeholder: 'Виды оказываемой помощи'
    });
    $('#helpUrgencyDate').select2({
        width: '100%',
        placeholder: 'Виды оказываемой помощи'
    });
    $('#baseHelpTypes').select2({
        width: '100%',
        placeholder: 'Сфера необходимой помощи',
        minimumResultsForSearch: -1
    });
    $('#baseHelp').select2({
        width: '100%',
        placeholder: 'Выберите сектор помощи',
        minimumResultsForSearch: -1
    });
    $('#addHelp').select2({
        width: '100%',
        placeholder: 'Выберите подробный сектор помощи',
        minimumResultsForSearch: -1
    });

    $('#who_need_help').change(function () {
        var scenario_id = $('#who_need_help').children('option:selected').val();
        var firstDestinations = [];
        var secondDestinations = [];
        var thirdDestinations = [];
        var fourDestinations = [];
        var scenario_index = 0;
        scenarios.forEach(function (value, index) {
            if (value.id == scenario_id) {
                scenario_index = index;
            }
        });
        $('#destinations1').empty();
        $('#destinations2').empty();
        $('#destinations3').empty();
        $('#destinations4').empty();
        for (let [key, value] of Object.entries(scenarios[scenario_index].destinations)) {
            if (value.parent_id == 0) {
                firstDestinations.push({id: value.id, text: value.name_ru});
            }
            if (value.parent_id == 1) {
                secondDestinations.push({id: value.id, text: value.name_ru});
            }
            if (value.parent_id == 2) {
                thirdDestinations.push({id: value.id, text: value.name_ru});
            }
            if (value.parent_id == 3) {
                fourDestinations.push({id: value.id, text: value.name_ru});
            }
        }

        if(firstDestinations.length>0){
            $('.destinations1').show();
            $('#destinations1').select2({data: firstDestinations, allowClear: true});
        }else{
            $('.destinations1').hide();
        }

        if(secondDestinations.length>0){
            $('.destinations2').show();
            $('#destinations2').select2({data: secondDestinations, allowClear: true});
        }else{
            $('.destinations2').hide();
        }

        if(thirdDestinations.length>0){
            $('.destinations3').show();
            $('#destinations3').select2({data: thirdDestinations, allowClear: true});
        }else{
            $('.destinations3').hide();
        }

        if(fourDestinations.length>0){
            $('.destinations4').show();
            $('#destinations4').select2({data: fourDestinations, allowClear: true});
        }else{
            $('.destinations4').hide();
        }

        var datas2 = [];
        $('#baseHelpTypes').empty();
        datas2.push({id: '0', text: ''});
        for (let [key, value] of Object.entries(scenarios[scenario_index].add_help_types)) {
            if(value.id != 7){
                datas2.push({id: value.id, text: value.name_ru + ' ('+value.description_ru+')'});
            }
        }
        $('#baseHelpTypes').select2({data: datas2, allowClear: true, minimumResultsForSearch: -1});
    });


    $('#regions').change(function () {
        var ind = $('#regions').children('option:selected').val();
        var datas = [];
        json.forEach(function (value, index) {
            if (value.region_id == ind) {
                ind = index;
            }
        });

        $('#districts').empty();
        datas.push({id: '0', text: ''});
        for (let [key, value] of Object.entries(json[ind].districts)) {
            datas.push({id: value.district_id, text: value.text});
        }


        if(datas.length > 1){
            $('.districts').show();
            $('#districts').select2({data: datas, allowClear: true});
        }else{
            $('.districts').hide();
            $('#districts').select2({data: [{id: '0', text: ''}], allowClear: true});
            $('.districts option').first().prop('selected', true);
            $('.cities').hide();
            $('.cities option').first().prop('selected', true);
        }
    });

    $('#districts').change(function () {
        var region_id = $('#regions').children('option:selected').val();
        var district_id = $('#districts').children('option:selected').val();
        var datas = [];

        json.forEach(function (value, index) {
            if (value.region_id == region_id) {
                region_id = index;
                value.districts.forEach(function (v, i) {
                    if (v.district_id == district_id) {
                        district_id = i;
                    }
                });
            }
        });

        $('#cities').empty();
        datas.push({id: 0, text: '-'});
        for (let [key, value] of Object.entries(json[region_id].districts[district_id].cities)) {
            datas.push({id: value.city_id, text: value.title_ru});
        }
        if(datas.length > 1){
            $('.cities').show();
            $('#cities').select2({data: datas, allowClear: true});
        }else{
            $('.cities').hide();
            $('#districts').select2({data: [{id: '0', text: ''}], allowClear: true});
        }

    });

    $(document).ready(function () {
        $("#who_need_help option:first").change();
        @if($help or count(old())>0)
        // Кто нуждается
        if(whoNeedHelp){
            $("#who_need_help option[value='"+whoNeedHelp+"']").prop('selected', true);
            $("#who_need_help option[value='"+whoNeedHelp+"']").change();
        }

        // Выборка 4 destinations
        if(destinations){
            $(destinations).each(function (index, value) {
                $("select[name=\"destinations[]\"] option[value='"+value+"']").prop('selected', true);
                $("select[name=\"destinations[]\"] option[value='"+value+"']").change();
            });
        }
        if(addHelpTypes){
// Отметьте сферу необходимой помощи
            $(addHelpTypes).each(function (index, value) {
                $("select#baseHelpTypes option[value='"+value+"']").prop('selected', true);
                $("select#baseHelpTypes option[value='"+value+"']").change();
            });
        }

        // Отметьте вид необходимой помощи
        if(cashHelpTypes){
            $(cashHelpTypes).each(function (index, value) {
                $("select#cashHelpTypes option[value='"+value+"']").prop('selected', true);
                $("select#cashHelpTypes option[value='"+value+"']").change();
            });
        }

        // Выбор региона
        if(region){
            $("select#regions option[value='"+region+"']").prop('selected', true);
            $("select#regions option[value='"+region+"']").change();
        }

        if(cashHelpTypes){
            // Выбор района
            $("select#districts option[value='"+district+"']").prop('selected', true);
            $("select#districts option[value='"+district+"']").change();
        }

        if(city){
            // Выбор города
            $("select#cities option[value='"+city+"']").prop('selected', true);
            $("select#cities option[value='"+city+"']").change();
        }

        if(cashHelpSize){
            // Сумма помощи
            $("select#cashHelpSizes option[value='"+cashHelpSize+"']").prop('selected', true);
            $("select#cashHelpSizes option[value='"+cashHelpSize+"']").change();
        }

        if(helpUrgencyDate){
// Сумма помощи
            $("select#helpUrgencyDate option[value='"+helpUrgencyDate+"']").prop('selected', true);
            $("select#helpUrgencyDate option[value='"+helpUrgencyDate+"']").change();
        }

        @endif
    });
</script>

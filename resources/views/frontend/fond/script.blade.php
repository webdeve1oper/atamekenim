<script>
    var json = {!! $regions->toJson() !!};
    var jsonHelps = {!! $baseHelpTypes->toJson() !!};
    var scenarios = {!! json_encode($scenarios) !!};

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
            datas2.push({id: value.id, text: value.name_ru + ' ('+value.description_ru+')'});
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

    });
</script>

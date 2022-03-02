<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<div class="col-12">
    <hr>
    <form action="" class="filter">
        <div class="row">
            <div class="col-3">
                <p>Место нахождение</p>
                <select class="form-control" name="region[]" id="region" multiple>
                    <?php $request_input = app('request')->input('region'); ?>
                    @foreach($regions as $region)
                        <option value="{{$region->region_id}}" @if($request_input) @if(in_array($region->region_id, app('request')->input('region'))) selected @endif @endif>{{$region->text}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <p>Сфера</p>
                <select class="form-control" name="baseHelpTypes[]" id="baseHelpTypes" multiple>
                    <?php $request_input = app('request')->input('baseHelpTypes'); ?>
                    @foreach($baseHelpTypes as $baseHelpType)
                        <option value="{{$baseHelpType->id}}" @if($request_input) @if(in_array($baseHelpType->id, app('request')->input('baseHelpTypes'))) selected @endif @endif>{{$baseHelpType->name_ru}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <p>Вид помощи </p>
                <select class="form-control" name="cashHelpTypes[]" id="cashHelpTypes" multiple>
                    <?php $request_input = app('request')->input('cashHelpTypes'); ?>
                    @foreach($cashHelpTypes as $cashHelpType)
                        <option value="{{$cashHelpType->id}}" @if($request_input) @if(in_array($cashHelpType->id, app('request')->input('cashHelpTypes'))) selected @endif @endif>{{$cashHelpType->name_ru}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3 mb-3">
                <p>Срочность</p>
                <select class="form-control" name="urgency_date[]" id="urgency_date" multiple>
                    <option value="1" @if(app('request')->input('urgency_date')) @if(in_array(1, app('request')->input('urgency_date'))) selected @endif @endif>{{trans('fonds.flow-month-1')}}</option>
                    <option value="2" @if(app('request')->input('urgency_date')) @if(in_array(2, app('request')->input('urgency_date'))) selected @endif @endif>{{trans('fonds.flow-month-3')}}</option>
                    <option value="3" @if(app('request')->input('urgency_date')) @if(in_array(3, app('request')->input('urgency_date'))) selected @endif @endif>{{trans('fonds.flow-month-6')}}</option>
                    <option value="4" @if(app('request')->input('urgency_date')) @if(in_array(4, app('request')->input('urgency_date'))) selected @endif @endif>{{trans('fonds.flow-year')}}</option>
                </select>
            </div>
            <div class="col-3">
                <p>Период начало</p>
                <input type="date" class="form-control" value="{{app('request')->input('date_from')}}" name="date_from">
            </div>
            <div class="col-3">
                <p>Период конец</p>
                <input type="date" class="form-control" value="{{app('request')->input('date_to')}}" name="date_to">
            </div>
            <div class="col-3">
                <p>&nbsp;</p>
                <input type="submit" value="Поиск" class="btn btn-primary">
            </div>
        </div>
    </form>
    <hr>
</div>
<style>
.filter p{
    margin-bottom: 4px;
}
</style>
<script>
    $('#region').select2({
        width: '100%',
        placeholder: 'Место нахождение'
    });
    $('#baseHelpTypes').select2({
        width: '100%',
        placeholder: 'Сфера'
    });
    $('#cashHelpTypes').select2({
        width: '100%',
        placeholder: 'Вид помощи'
    });
    $('#urgency_date').select2({
        width: '100%',
        placeholder: 'Срочность'
    });
</script>

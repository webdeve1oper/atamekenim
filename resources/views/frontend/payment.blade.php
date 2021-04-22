<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="display: none;">
<form action="https://ecom.jysanbank.kz:8462/ecom/api" method="POST" id="payment">
    <input type="hidden" name="ORDER" value="{{$orderId}}">
    <input type="name" value="ФИО" class="form-control">
    <input type="hidden" name="CURRENCY" value="KZT">
    <input type="hidden" name="MERCHANT" value="atamekenim.kz">
    <input type="hidden" name="TERMINAL" value="12200005">
    <input type="hidden" name="AMOUNT" value="{{$amount}}">
    <input type="hidden" name="LANGUAGE" value="ru">
    <input type="hidden" name="CLIENT_ID" value="{{$orderId}}">
    <input type="hidden" name="DESC" value="test">
    <input type="hidden" name="DESC_ORDER" value="">
    <input type="hidden" name="EMAIL" value="">
    <input type="hidden" name="BACKREF" value="https://www.google.kz">
    <input type="hidden" name="Ucaf_Flag" value="">
    <input type="hidden" name="Ucaf_Authentication_Data" value="">
    <input type="hidden" name="crd_pan" value="">
    <input type="hidden" name="crd_exp" value="">
    <input type="hidden" name="crd_cvc" value="">
    <input type="hidden" name="P_SIGN" value="{{$vSign}}">
    <input type="hidden" name="DESC_ORDER" value="Помощь фонду {{$fond['title_ru']}}">
    <button class="btn-default red" type="submit">
        <img src="/img/help.svg" alt=""> {{trans('fonds-page.supp-org')}}
    </button>
</form>
<script>
    document.getElementById("payment").submit();
</script>
</body>
</html>

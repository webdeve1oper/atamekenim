<div class="modal fade" id="cloudpayments">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Поддержать организацию</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="donation_cloudpayments_fond">
                {{--<form id="donation_cloudpayments_fond" action="{{route('donation_cloudpayments_fond')}}" method="POST">--}}
                    @csrf
                    <div class="inputBlock">
                        <input type="hidden" name="fond_id" value="{{$fond->id}}">
                        <div class="form-group mb-4">
                            <label for="">Введите Ваше ФИО:</label>
                            <input type="name" value="ФИО" class="form-control">
                        </div>
                        <input type="text" name="amount" value="">
                    </div>
                    <input type="hidden" name="DESC_ORDER" value="Помощь фонду {{$fond['title_'.app()->getLocale()] ?? $fond['title_ru']}}">
                    <button class="btn-default red" onclick="payHandler();javascript:void(null);">
                        <img src="/img/help.svg" alt=""> {{trans('fonds-page.supp-org')}}
                    </button>
                {{--</form>--}}
            </div>
        </div>
    </div>
</div>
<script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
<script type="text/javascript">
        function payHandler() {
            var widget = new cp.CloudPayments();
            var receipt = {
                Items: [//товарные позиции
                    {
                        label: 'Наименование товара 3', //наименование товара
                        price: 10.00, //цена
                        quantity: 1.00, //количество
                        amount: 10.00, //сумма
                        vat: 0, //ставка НДС
                        method: 0, // тег-1214 признак способа расчета - признак способа расчета
                        object: 0, // тег-1212 признак предмета расчета - признак предмета товара, работы, услуги, платежа, выплаты, иного предмета расчета
                    }
                ],
                taxationSystem: 0, //система налогообложения; необязательный, если у вас одна система налогообложения
                email: 'web@conversion.kz', //e-mail покупателя, если нужно отправить письмо с чеком
                phone: '', //телефон покупателя в любом формате, если нужно отправить сообщение со ссылкой на чек
                isBso: false, //чек является бланком строгой отчетности
                amounts:
                    {
                        electronic: 900.00, // Сумма оплаты электронными деньгами
                        advancePayment: 0.00, // Сумма из предоплаты (зачетом аванса) (2 знака после запятой)
                        credit: 0.00, // Сумма постоплатой(в кредит) (2 знака после запятой)
                        provision: 0.00 // Сумма оплаты встречным предоставлением (сертификаты, др. мат.ценности) (2 знака после запятой)
                    }
            };

            var data = {};
            data.cloudPayments = {recurrent: { interval: 'Day', period: 1, customerReceipt: receipt}}; //создание ежемесячной подписки

            widget.charge({ // options
                    publicId: '{{config('services.cloud_payments.public_id')}}', //id из личного кабинета
                    description: 'Подписка на ежемесячные платежи', //назначение
                    amount: 10, //сумма
                    currency: 'KZT', //валюта
                    invoiceId: '2', //номер заказа  (необязательно)
                    accountId: 'web2@conversion.kz', //идентификатор плательщика (обязательно для создания подписки)
                    data: data
                },
                function (options) { // success
                    console.log(options);
                    //действие при успешной оплате
                },
                function (reason, options) { // fail
                    //действие при неуспешной оплате
                });
        };

</script>


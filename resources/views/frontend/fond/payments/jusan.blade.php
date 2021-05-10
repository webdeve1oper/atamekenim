<div class="modal fade" id="jusan">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Поддержать организацию</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('donation_to_fond')}}" method="POST">
                    @csrf
                    <div class="inputBlock">
                        <input type="hidden" name="fond_id" value="{{$fond->id}}">
                        <div class="form-group mb-4">
                            <label for="">Введите Ваше ФИО:</label>
                            <input type="name" value="ФИО" class="form-control">
                        </div>
                        <input type="hidden" name="amount" value="">
                    </div>
                    <input type="hidden" name="DESC_ORDER" value="Помощь фонду {{$fond['title_'.app()->getLocale()] ?? $fond['title_ru']}}">
                    <button class="btn-default red" type="submit">
                        <img src="/img/help.svg" alt=""> {{trans('fonds-page.supp-org')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-header .close{
        position: absolute;
        right: 22px;
    }
    .modal-title{
        margin: auto;
    }
    .inputBlock label:hover{
        cursor: pointer;
    }
    .otherOrganizations .block img{
        width: 19%;
    }
    .otherOrganizations .block{
        margin-bottom: 30px;
        background-color: #fcfcff;
        padding: 15px;
    }
    .otherOrganizations .block p{
        font-size: 12px;
    }
    .inputBlock .label.active{
        background-color: #dcd1ca!important;
    }
</style>
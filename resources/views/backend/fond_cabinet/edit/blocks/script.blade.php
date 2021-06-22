<script>
    var options = {
        toolbar: [
            {name: 'clipboard', items: ['Cut', 'Copy', 'Undo', 'Redo']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']},
            {name: 'others', items: ['-']},
        ]
    };
    CKEDITOR.replace('mission_ru', options);
    CKEDITOR.replace('mission_kz', options);
    CKEDITOR.replace('about_ru', options);
    CKEDITOR.replace('about_kz', options);

    function deleteRequisite(id) {
        let sure = confirm("Уверены что хотите удалить?");
        if(sure){
            $.ajax({
                url: '/ru/cabinet/fond/requisite/delete/' + id,
                method: 'post',
                data: {'_token': '{{csrf_token()}}'},
                success: function () {
                    $('#requisite_item_' + id).remove();
                }
            });
        }
    }
    function deleteOffice(id) {
        let sure = confirm("Уверены что хотите удалить?");
        if(sure) {
            $.ajax({
                url: '/ru/cabinet/fond/office/delete/' + id,
                method: 'post',
                success: function () {
                    $('#office_item_' + id).remove();
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function () {
        var inputss = $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').clone();
        inputss.find('input').remove();
        $('.regionsBlock').html(inputss);
        $('.regionsOpenBlock input[type="checkbox"]').click(function () {
            var inputs = $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').clone();
            inputs.find('input').remove();
            $('.regionsBlock').html(inputs);
            $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
            $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
            $('.regionsBlock .inputBlock').click(function () {
                var id = $(this).attr("id");
                $('.regionsOpenBlock #' + id).find('input').prop("checked", false);
                $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
                $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
                $(this).remove();
            });
        });
        $('.regionsBlock .inputBlock').click(function () {
            var id = $(this).attr("id");
            if ($('.regionsOpenBlock').is(':visible')) {
                $('.regionsOpenBlock').show();
            }
            $('.regionsOpenBlock #' + id).find('input').prop("checked", false);
            $('.regionsOpenBlock input[type="checkbox"]').parents('.inputBlock').removeClass("active");
            $('.regionsOpenBlock input[type="checkbox"]:checked').parents('.inputBlock').addClass("active");
            $(this).remove();
        });
    });
</script>
<script>
    ymaps.ready(function(){
        init('0');
        @foreach($offices as $i=> $office)
        init('{{$office->id}}', '{{$office->longitude}}', '{{$office->latitude}}');
        @endforeach
    });

    function init(id, longitude = null, latitude = null) {
        var mapId = 'map'+id;
        var myPlacemark,
            myMap = new ymaps.Map(mapId, {
                zoom: longitude == '' ? 15 : 5,
                center: [longitude == ''? 51.16029659526363 : longitude, latitude == '' ? 71.41972787147488:latitude],
                controls: ['searchControl']
            }, {
                searchControlProvider: 'yandex#search'
            });

            myPlacemark = createPlacemark([longitude == ''? 51.16029659526363 : longitude, latitude == '' ? 71.41972787147488:latitude]);
        myMap.geoObjects.add(myPlacemark);
        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords, id);
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords, id) {
            console.log('#longitude'+id);
            var longitude = $('#longitude'+id);
            var latitude = $('#latitude'+id);
            longitude.val(coords[0]);
            latitude.val(coords[1]);
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
            });
        }
    }
</script>

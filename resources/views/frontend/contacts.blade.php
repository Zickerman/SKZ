@extends('welcome')
@section('content')

    <div class="wrapper flex-grow-1 main_catalog_gradient">
        <div class="container mt-4 pt-4">
            <div class="row">
                <div class="col-md-4">
                    <h2>Рабочие часы</h2>
                    <p>Понедельник - Пятница: 9:00 - 18:00</p>
                    <h2>Email</h2>
                    <p>skz-s@yandex.ru</p>
                    <h2>Телефон</h2>
                    <p>+7 (35333) 6-15-66</p>
                </div>
                <div class="col-md-4">
                    <h2>Реквизиты:</h2>
                    <p>ОРГН 1155658022485<br>
                        ИНН 5643022105/КПП 564301001<br>
                        БИК 045354885<br>
                        Кор/счет 30101810400000000885<br>
                        Р/счет 40703810520000000012<br>
                        ОАО «БАНК ОРЕНБУРГ» г.ОРЕНБУРГ</p>
                </div>
                <div class="col-md-4">
                    <h2>Адрес</h2>
                    <p>462100 Оренбургская обл., п.Саракташ, ул.Калинина, 5</p>
                </div>
                <div class="col-md-12 mt-4">
                    <div style="width: 100%; height: 400px;">
                        <iframe
                            width="100%" height="100%" loading="lazy" sandbox="allow-same-origin allow-scripts"
                            src="https://yandex.ru/map-widget/v1/?um=constructor%3A890f1f44ae9d25ae6c203b1b6cbabd2cded92b92694323a56ba8116d2357ecb7&amp;source=constructor"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

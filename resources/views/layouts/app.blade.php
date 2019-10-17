<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>


</head>
<body class="fixed-sn white-skin">
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <div id="app">

        @include('includes.header')

        <main>
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/addons/datatables.min.js') }}"></script>
    @yield('page-scripts')
    <!--Initializations-->
    <script>
        // SideNav Initialization
        $(".button-collapse").sideNav();

        var container = document.querySelector('.custom-scrollbar');
        Ps.initialize(container, {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });

        // Data Picker Initialization
        $('.datepicker').pickadate({
            max: new Date(),
            monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь',
                'Ноябрь', 'Декабрь'],
            monthsShort: ['Янв', 'Фвр', 'Мрт', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Снт', 'Окт',
                'Нбр', 'Дбр'],
            weekdaysFull: ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'],
            weekdaysShort: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
            today: 'Сегодня',
            clear: 'Очистить',
            close: 'Закрыть',
            formatSubmit: 'yyyy-mm-dd'
        });

        // Material Select Initialization
        $(document).ready(function () {
            //$('.mdb-select').material_select();
        });

        // Tooltips Initialization
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(document).ready(function () {
            $('#dt').DataTable({
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
                order: [[ 3, 'desc' ]]
            });
            $('#dt_wrapper').find('label').each(function () {
                $(this).parent().append($(this).children());
            });
            $('#dt_wrapper .dataTables_filter').find('input').each(function () {
                $('input').attr("placeholder", "Поиск");
                $('input').removeClass('form-control-sm');
            });
            $('#dt_wrapper .dataTables_length').addClass('d-flex flex-row');
            $('#dt_wrapper .dataTables_filter').addClass('md-form');
            $('#dt_wrapper select').removeClass(
                'custom-select custom-select-sm form-control form-control-sm');
            $('#dt_wrapper select').addClass('mdb-select');
            $('#dt_wrapper .mdb-select').materialSelect();
            $('#dt_wrapper .dataTables_filter').find('label').remove();

            $('.datepicker').pickadate();
        });

    </script>

</body>
</html>

@extends('layouts.app')

@section('content')

    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card-body">

            <table id="dt" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Тип
                    </th>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Дата
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($ballances as $item)

                    <tr>
                        <td>{{ $item->ballance_type->name }}</td>
                        <td>{{ $item->sum }} грн</td>
                        <td>{{ $item->month_name }} {{ $item->year }}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    </section>
    <!--/Section: Button icon-->

@endsection
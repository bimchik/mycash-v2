@extends('layouts.app')

@section('content')



    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card-body">

            <table id="dt" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Название
                    </th>
                    <th class="th-sm">Кол-во
                    </th>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Категория
                    </th>
                    <th class="th-sm">Место покупки
                    </th>
                    <th class="th-sm">Дата
                    </th>
                </tr>
                </thead>
                <tbody>

                @php ($sum = 0)

                @foreach($data as $item)


                    @if($item->commun_bill == true)
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $item->total_price }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td></td>
                            <td>{{ $item->created_at }}</td>

                        </tr>
                    @else
                        <tr>
                            <td>{{ $item->loctag->tag->name }}</td>
                            <td>{{ $item->qty }} {{ $item->loctag->tag->unit }}</td>
                            <td>{{ $item->total_price }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->loctag->location->name }}, {{ $item->loctag->location->address }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endif

                    @php ($sum += $item->total_price)

                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4">Общая Сумма
                    </th>
                    <th>{{ $sum }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>

    </section>
    <!--/Section: Button icon-->
@endsection

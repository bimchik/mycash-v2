@extends('layouts.app')

@section('content')

    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card-body">

            <table id="dt" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Оплачено
                    </th>
                    <th class="th-sm">Дата
                    </th>
                    <th class="th-sm">Сохранен
                    </th>
                    <th class="th-sm">Оплачен
                    </th>
                    <th class="th-sm">Действия
                    </th>
                </tr>
                </thead>
                <tbody>

                @php ($sum = 0)



                @foreach($bills as $bill)

                    <tr>
                        <td>{{ $bill->total_sum }}</td>
                        <td>{{ $bill->payed_sum }}</td>
                        <td>{{ $bill->monthName }} {{ $bill->created_at->format('Y') }}</td>
                        <td>{{ $bill->status_save }}</td>
                        <td>{{ $bill->status_pay }}</td>
                        <td>
                            <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0" rec_id="{{ $bill->id }}">Удалить</button></span>
                            <span class="table-edit"><a href="/commun/bill/{{ $bill->id }}" type="button" class="btn btn-success btn-rounded btn-sm my-0">Просмотреть</a></span>

                        </td>
                    </tr>

                    @php ($sum += $bill->total_sum)

                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">Общая Сумма
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

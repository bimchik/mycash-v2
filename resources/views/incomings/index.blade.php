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
                <th class="th-sm">Категория
                </th>
                <th class="th-sm">Дата
                </th>
            </tr>
            </thead>
            <tbody>

            @php ($sum = 0)

            @foreach($data as $item)

            <tr>
                <td>{{ $item->price }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>

            @php ($sum += $item->price)

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

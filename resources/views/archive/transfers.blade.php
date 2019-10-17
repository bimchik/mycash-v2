@extends('layouts.app')

@section('content')



    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card-body">

            <table id="dt" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Из
                    </th>
                    <th class="th-sm">В
                    </th>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Дата
                    </th>
                </tr>
                </thead>
                <tbody>


                @foreach($transfers as $item)


                        <tr>
                            <td>{{ $item->from_ball->ballance_type->name }}</td>
                            <td>{{ $item->to_ball->ballance_type->name }}</td>
                            <td>{{ $item->sum }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    </section>
    <!--/Section: Button icon-->
@endsection

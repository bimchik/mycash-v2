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
                    <th class="th-sm">Пользователь
                    </th>
                    <th class="th-sm">Данные
                    </th>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Дата
                    </th>
                </tr>
                </thead>
                <tbody>


                @foreach($data as $item)

                    @if($item->operation_type == 'incoming')
                        @php($type = "<i class='fas fa-plus-circle mr-2 text-success'></i> Доход")
                        @php($sum = $item->price)
                        @php($idata = '<ul class="list-gorup"><li class="list-group-item">Категория: <span class="float-right font-weight-bold">'.$item->category->name.'</span></li></ul>')
                    @elseif($item->operation_type == 'spending')

                        @php($type = "<i class='fas fa-minus-circle mr-2 text-danger'></i> Расход")
                        @php($sum = $item->total_price)
                        @php($location = "")
                        @if($item->loctag->location !== null)
                            @php($location = $item->loctag->location->name . ", " . $item->loctag->location->address)
                        @endif
                        @php($idata = '
                            <ul class="list-gorup">
                                <li class="list-group-item">
                                    Категория: <span class="float-right font-weight-bold">'.$item->category->name.'</span>
                                </li>
                                <li class="list-group-item">
                                    Продукт: <span class="float-right font-weight-bold">'.$item->loctag->tag->name.', '.$item->qty.''.$item->loctag->tag->unit.'</span>
                                </li>
                                <li class="list-group-item">
                                    Место покупки: <span class="float-right font-weight-bold">'.$location.'</span>
                                </li>
                             </ul>
                        ')
                    @elseif($item->operation_type == 'transfer')
                        @php($type = "<i class='fas fa-exchange-alt mr-2 text-warning'></i> Перевод средств")
                        @php($sum = $item->sum)
                        @php($idata = '
                            <ul class="list-gorup">
                                <li class="list-group-item">
                                    Из: <span class="float-right font-weight-bold">'.$item->from_ball->ballance_type->name.'</span>
                                </li>
                                <li class="list-group-item">
                                    В: <span class="float-right font-weight-bold">'.$item->to_ball->ballance_type->name.'</span>
                                </li>
                             </ul>
                        ')
                        @php($account = $item->from_ball->account->user->name . " | " . $item->from_ball->account->user->email)
                    @endif

                    <tr>
                        <td>{!! $type !!}</td>
                        <td>{{ $item->from_ball->account->user->name }} | {{ $item->from_ball->account->user->email }}</td>
                        <td>{!! $idata !!}</td>
                        <td>{{ $sum }} грн</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    </section>
    <!--/Section: Button icon-->

@endsection
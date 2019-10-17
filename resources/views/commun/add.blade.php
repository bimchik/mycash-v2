@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--Section: Button icon-->
<section class="section mb-5">



        @if($data->isEmpty())

            <a href="/commun/fields" class="btn btn-success"><i class="fa fa-plus"></i> Добавить поля</a>

        @else
        <form method="post" action="{{ route('commun.bills.store') }}" id="billForm">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $currYear }}">
        <!-- Table with panel -->
        <div class="card card-cascade narrower">

            <!--Card image-->
            <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                <div>
                    <button type="button" class="btn btn-outline-white btn-rounded btn-sm px-2" id="chkAll" title="Отметить все">
                        <i class="fas fa-check-circle mt-0"></i>
                    </button>
                </div>

                <a href="" class="white-text mx-3">Платеж за {{ $monthName }} {{ $currYear }}</a>

                <div>
                    <button type="submit" name="saveData" value="1" id="saveData" class="btn btn-outline-white btn-rounded btn-sm px-2">
                        <i class="fas fa-pencil-alt mt-0"></i>
                    </button>
                    <button type="submit" name="pay" value="1" class="btn btn-outline-white btn-rounded btn-sm px-2">
                        <i class="fas fa-shopping-cart mt-0"></i>
                    </button>
                </div>

            </div>
            <!--/Card image-->

            <div class="px-4">

                <div class="table-wrapper">

            <table id="dtFields" class="table table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Отметить для оплаты
                    </th>
                    <th class="th-sm">Название
                    </th>
                    <th class="th-sm">Тариф
                    </th>
                    <th class="th-sm">Предыдущие показания
                    </th>
                    <th class="th-sm">Текущие показания
                    </th>
                    <th class="th-sm">Сумма
                    </th>
                    <th class="th-sm">Статус
                    </th>
                </tr>
                </thead>
                <tbody>


                @foreach($data as $item)
                    @php($disabled = "")
                    @php($required = "")
                    @if($item->calcBy !== "numCount")
                        @php($disabled = "disabled")
                    @else
                        @php($required = "required")
                    @endif

                    @php($item_sum = "0.00")
                    @if($item->calcBy == "fixed")
                        @php($item_sum = $item->tariff_price)
                    @elseif($item->calcBy == "numPeople")
                        @php($item_sum = $item->tariff_price * $item->people_count)
                    @elseif($item->calcBy == "numSpace")
                        @php($item_sum = $item->tariff_price * $item->space_count)
                    @endif

                    

                    @if($item->status == 0)
                        @php($status = '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Не оплачено</span>')
                    @elseif($item->status == 0)
                        @php($status = '<span class="text-success"><i class="fas fa-check-circle"></i> Оплачено</span>')
                    @endif

                    <tr>
                        <td class="text-center"><input type="checkbox" class="form-check-input" name="for_pay[]" value="{{ $item->id }}" id="checkbox-{{ $item->id }}">
                            <label class="form-check-label" for="checkbox-{{ $item->id }}" class="mr-2 label-table"></label>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td><input type="number" step="0.01" class="item_tariff"  name="item_tariff-{{ $item->id }}" value="{{ $item->tariff_price }}" disabled></td>
                        <td><input type="number" class="last_val" name="last_val-{{ $item->id }}" value="{{ $item->current_count_value }}" {{ $disabled }}></td>
                        <td><input type="number" class="next_val"  name="next_val-{{ $item->id }}" autocomplete="off" value="" {{ $disabled }}></td>
                        <td><input type="number" step="0.01" class="item_sum" name="sum-{{ $item->id }}" autocomplete="off" value="{{ $item_sum }}"></td>
                        <td>{!! $status !!}</td>

                        <input type="hidden" name="field_id[]" value="{{ $item->id }}">
                    </tr>


                @endforeach

                </tbody>
            </table>
                </div>

            </div>


        </div>
    <!-- Table with panel -->

        </form>
        @endif
</section>
<!--/Section: Button icon-->
    <script>
        $(document).ready(function () {

            var clicked = false;
            $("#chkAll").on("click", function() {
                $("input[type=checkbox]").prop("checked", !clicked);
                clicked = !clicked;
            });

            $('#dtFields').on('change keyup','.next_val',function () {
                var nxt_val = $(this).val();
                var lst_val = $(this).closest('td').prev().find('.last_val').val();
                var tariff = $(this).closest('td').prev().prev().find('.item_tariff').val();

                var sum = "0,00";

                if (nxt_val != "undefined") {

                    sum = (nxt_val - lst_val) * tariff;

                }
                $(this).closest('td').next().find('.item_sum').val(sum);
             });

       });
    </script>
@endsection
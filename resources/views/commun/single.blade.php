@extends('layouts.app')

@section('content')

    <!--Section: Button icon-->
    <section class="section mb-5">


        <form method="post" action="{{ route('commun.bills.store') }}" id="billForm" autocomplete="false">
        @csrf

            <input type="hidden" name="billId" value="{{ $data->id }}">
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
                        <button type="submit" name="pay" value="1" class="btn btn-outline-white btn-rounded btn-sm px-2">
                            <i class="fas fa-pencil-alt mt-0"></i>
                        </button>
                        <button type="submit" name="saveData" value="1" class="btn btn-outline-white btn-rounded btn-sm px-2">
                            <i class="fas fa-shopping-cart mt-0"></i>
                        </button>
                    </div>

                </div>
                <!--/Card image-->

                <div class="px-4">

                    <div class="table-wrapper">

                        <table id="dtFields" class="table table-striped" cellspacing="0" width="100%">
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

                            @php($t_sum = "0.00")

                            @foreach($data->billItems as $item)

                                @php($disabled = "")
                                @php($required = "")
                                @if($item->field->calcBy !== "numCount")
                                    @php($disabled = "disabled")
                                @else
                                    @php($required = "required")
                                @endif

                                @if($item->field->calcBy == "fixed")
                                    @php($item_sum = $item->field->tariff_price)
                                @elseif($item->field->calcBy == "numPeople")
                                    @php($item_sum = $item->field->tariff_price * $item->field->people_count)
                                @elseif($item->field->calcBy == "numSpace")
                                    @php($item_sum = $item->field->tariff_price * $item->field->space_count)
                                @endif

                                @if($item->status_save == 0)

                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input" name="for_pay[]" value="{{ $item->field->id }}" id="checkbox-{{ $item->field->id }}">
                                            <label class="form-check-label" for="checkbox-{{ $item->field->id }}" class="mr-2 label-table"></label>
                                        </td>
                                        <td>{{ $item->field->name }}</td>
                                        <td><input type="number" step="0.01" class="item_tariff"  name="item_tariff-{{ $item->field->id }}" value="{{ $item->field->tariff_price }}" disabled></td>
                                        <td><input type="number" class="last_val" name="last_val-{{ $item->field->id }}" value="{{ $item->field->current_count_value }}" {{ $disabled }}></td>
                                        <td><input type="number" class="next_val"  name="next_val-{{ $item->field->id }}" autocomplete="off" value="" {{ $disabled }} {{ $required }}></td>
                                        <td><input type="number" step="0.01" class="item_sum" name="sum-{{ $item->field->id }}" autocomplete="off" value="{{ round($item_sum,2) }}"></td>
                                        <td><span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Не оплачено</span></td>
                                    </tr>
                                    <input type="hidden" name="field_id[]" value="{{ $item->field->id }}">
                                @elseif($item->status_save == 1 && $item->status_pay == 0)

                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input" name="for_pay[]" value="{{ $item->field->id }}" id="checkbox-{{ $item->field->id }}">
                                            <label class="form-check-label" for="checkbox-{{ $item->field->id }}" class="mr-2 label-table"></label>
                                        </td>
                                        <td>{{ $item->field->name }}</td>
                                        <td><input type="number" step="0.01" class="item_tariff"  name="item_tariff-{{ $item->field->id }}" value="{{ $item->field->tariff_price }}" disabled></td>
                                        <td><input type="number" class="last_val" name="last_val-{{ $item->field->id }}" value="{{ $item->last_val }}" {{ $disabled }}></td>
                                        <td><input type="number" class="next_val"  name="next_val-{{ $item->field->id }}" autocomplete="off" value="{{ $item->next_val }}" {{ $disabled }} {{ $required }}></td>
                                        <td><input type="number" step="0.01" class="item_sum" name="sum-{{ $item->field->id }}" autocomplete="off" value="{{ round($item->sum,2) }}"></td>
                                        <td><span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Не оплачено</span></td>
                                    </tr>
                                    <input type="hidden" name="field_id[]" value="{{ $item->field->id }}">

                                @elseif($item->status_save == 1 && $item->status_pay == 1)

                                    <tr>
                                        <td class="text-center">
                                        </td>
                                        <td>{{ $item->field->name }}</td>
                                        <td>{{ $item->field->tariff_price }}</td>
                                        <td>{{ $item->last_val }}
                                            <input type="hidden" name="last_val-{{ $item->field->id }}" value="{{ $item->last_val }}"></td>
                                        <td>{{ $item->next_val }}
                                            <input type="hidden" name="next_val-{{ $item->field->id }}" value="{{ $item->next_val }}"></td>
                                        <td>{{ $item->sum }}
                                            <input type="hidden" name="sum-{{ $item->field->id }}" value="{{ round($item->sum,2) }}"></td>
                                        <td><span class="text-success"><i class="fas fa-check-circle"></i> Оплачено</span></td>
                                    </tr>
                                    <input type="hidden" name="field_id[]" value="{{ $item->field->id }}">

                                @else
                                    <tr>
                                        <td colspan="8">Error!</td>
                                    </tr>
                                @endif

                            @endforeach

                            @if($fields !== null)
                            @foreach($fields as $item)
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
                                    <td><input type="number"  class="item_sum" name="sum-{{ $item->id }}"  value="{{ round($item_sum,2) }}"></td>
                                    <td>{!! $status !!}</td>

                                    <input type="hidden" name="field_id[]" value="{{ $item->id }}">
                                </tr>


                            @endforeach
                            @endif

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6">Сумма для оплаты</th>
                                    <th>{{ $total_sum }}</th>
                                </tr>
                                <tr>
                                    <th colspan="6">Оплачено</th>
                                    <th>{{ $data->payed_sum }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>


            </div>
            <!-- Table with panel -->

        </form>
    </section>
    <!--/Section: Button icon-->
    <script>
        $(document).ready(function () {

            var clicked = false;
            $("#chkAll").on("click", function() {
                $("input[type=checkbox]").prop("checked", !clicked);
                clicked = !clicked;
            });

            $('#dtFields').on('keyup','.next_val',function (e) {
                var nxt_val = $(e.target).val();
                var lst_val = $(e.target).closest('td').prev().find('.last_val').val();
                var tariff = $(e.target).closest('td').prev().prev().find('.item_tariff').val();

                var sum = "0,00";

                if (nxt_val != "undefined") {

                    sum = (nxt_val - lst_val) * tariff;

                }
                $(e.target).closest('td').next().find('.item_sum').val(sum);
            });



        });
    </script>
@endsection
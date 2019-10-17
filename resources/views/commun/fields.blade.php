@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card-body">

            <table id="dtFields" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">Название
                    </th>
                    <th class="th-sm">Тариф
                    </th>
                    <th class="th-sm">Расчет
                    </th>
                    <th class="th-sm">Текущие показания
                    </th>
                    <th class="th-sm">Кол-во человек
                    </th>
                    <th class="th-sm">Площадь
                    </th>
                    <th class="th-sm">Действия
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($fields as $item)

                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->tariff_price }}</td>
                        <td>
                             @if($item->calcBy == "numCount")
                                По показателям счетчика
                             @elseif($item->calcBy == "fixed")
                                Фиксированное значение
                             @elseif($item->calcBy == "numPeople")
                                По кол-ву человек
                            @elseif($item->calcBy == "numSpace")
                                По жилой/отпливаемой площади
                             @endif
                        </td>
                        <td>{{ $item->current_count_value }}</td>
                        <td>{{ $item->people_count }}</td>
                        <td>{{ $item->space_count }}</td>
                        <td>
                            <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0" rec_id="{{ $item->id }}">Удалить</button></span>
                            <span class="table-edit"><button type="button" class="btn btn-success btn-rounded btn-sm my-0" rec_id="{{ $item->id }}">Изменить</button></span>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    </section>
    <!--/Section: Button icon-->



    <!--Section: Inputs-->
    <section class="section card mb-5">

        <div class="card-body">

            <!--Section heading-->

            <h5 class="pb-5">Добавить поле счета</h5>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-4">


                    <form action="{{ route('commun.fields.store') }}" method="post" id="addForm">
                        @csrf

                        <div class="md-form">
                            <input type="text" name="name" id="form1" class="form-control" required>
                            <label for="form1"  class="">Название</label>
                        </div>
                        <div class="md-form">
                            <input type="number" step="0.01" name="tariff_price" id="form2" class="form-control" required>
                            <label for="form2"  class="">Тариф</label>
                        </div>
                        <div class="md-form">

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="has_count" name="calcBy" value="numCount" autocomplete="false">
                                <label class="form-check-label" for="has_count">По показателям счетчика</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="is_fixed" name="calcBy" value="fixed" autocomplete="false">
                                <label class="form-check-label" for="is_fixed">Фиксированное значение</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="has_people" name="calcBy" value="numPeople" autocomplete="false">
                                <label class="form-check-label" for="has_people">По кол-ву человек</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="has_space" name="calcBy" value="numSpace" autocomplete="false">
                                <label class="form-check-label" for="has_space">По площади</label>
                            </div>

                        </div>
                        <div class="md-form" id="curr_val_input" style="display: none">
                            <input type="number" name="current_count_value" id="current_count_value" class="form-control">
                            <label for="current_count_value"  class="">Текущие показания</label>
                        </div>
                        <div class="md-form" id="people_count_block" style="display: none">
                            <input type="number" name="people_count" id="people_count" class="form-control">
                            <label for="people_count" class="">Кол-во человек</label>
                        </div>
                        <div class="md-form" id="space_count_block" style="display: none">
                            <input type="number" step="0.01" name="space_count" id="space_count" class="form-control">
                            <label for="space_count" class="">Жилая/отапливаемая площадь</label>
                        </div>
                        <div class="md-form">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="for_prev_month" name="for_prev_month" value="1" autocomplete="false">
                                <label class="form-check-label" for="for_prev_month">Учитывать с предыдущего месяца</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>

                </form>


            </div>
            <!--Grid column-->

            </div>

        </div>
        <!--Grid row-->

        </div>

    </section>
    <!--Section: Inputs-->

    <script>

    $(document).ready(function () {


        var calcBy = $('input[name=calcBy]:checked','#addForm').val();


        if(calcBy == 'numCount'){
            $('#curr_val_input').show();
        } else if(calcBy == 'numPeople'){
            $('#people_count_block').show();
        } else if(calcBy == 'numSpace'){
            $('#space_count_block').show();
        }

        $('#addForm').on('change', 'input[name=calcBy]',function () {
            var val = $(this).val();
            if(val == 'numCount'){
                $('#people_count_block').hide();
                $('#space_count_block').hide();
                $('#curr_val_input').show();
            } else if(val == 'numPeople'){
                $('#curr_val_input').hide();
                $('#space_count_block').hide();
                $('#people_count_block').show();
            } else if(val == 'fixed'){
                $('#curr_val_input').hide();
                $('#space_count_block').hide();
                $('#people_count_block').hide();
            } else if(val == 'numSpace'){
                $('#curr_val_input').hide();
                $('#people_count_block').hide();
                $('#space_count_block').show();
            }
        });

        $('#dtFields').on('click', '.table-remove button', function (e) {
            var rec_id = $(this).attr('rec_id');
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({

                type: 'DELETE',

                url: '/commun/fields/' + rec_id,

                data: {

                    "id": rec_id,

                    "_token": token,

                },

                success: function (data) {

                    $(e.target).closest('tr').remove();

                }

            });
        });
    });

    </script>

@endsection

@extends('layouts.app')

@section('content')


    <!--Section: Button icon-->
    <section class="section card mb-5">
        <div class="card card-cascade narrower">

            <!--Card image-->
            <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                <div class="md-form">
                    <input placeholder="Выбрать дату" name="listDate" type="text" id="date-picker-example" class="form-control datepicker">
                    <label for="date-picker-example"></label>
                </div>

                <a href="" class="white-text mx-3">Создание нового списка покупок</a>

                <div>
                    <a id="addItem" href="#" class="btn btn-outline-white btn-rounded btn-sm px-2" data-toggle="modal" data-target="#centralModalSm">
                        <i class="fas fa-plus mt-0"></i>
                    </a>
                </div>

            </div>
            <!--/Card image-->

            <div class="px-4">

                <div class="table-wrapper">

                    <table id="buyFields" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="th-sm">
                            </th>
                            <th class="th-sm">Название
                            </th>
                            <th class="th-sm">Кол-во
                            </th>
                            <th class="th-sm">Место
                            </th>
                            <th class="th-sm">Общая сумма
                            </th>
                            <th class="th-sm">Действия
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            @if(isset($data) && $data !== null)

                                @foreach($data->listItems as $item)

                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input" name="for_pay[]" value="{{ $item->id }}" id="checkbox-{{ $item->id }}">
                                            <label class="form-check-label" for="checkbox-{{ $item->id }}" class="mr-2 label-table"></label>
                                        </td>
                                        <td><input type="text" class="form-control" name="tag" value="{{ $item->tag->name }}"></td>
                                        <td>
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input type="number" step="0.001" class="form-control mr-2" name="qty" value="{{ $item->qty }}" aria-describedby="passwordHelpInline">
                                                    <span id="passwordHelpInline" class="text-muted">{{ $item->tag->unit }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->location !== null)
                                                <div class="form-row">
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="location" value="{{ $item->location->name }}" aria-describedby="passwordHelpBlock">
                                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                                            Название места покупки
                                                        </small>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="address" value="{{ $item->location->address }}" aria-describedby="passwordHelpBlock2">
                                                        <small id="passwordHelpBlock2" class="form-text text-muted">
                                                            Адрес
                                                        </small>
                                                    </div>

                                                </div>
                                            @else
                                                <div class="form-row">
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="location" value="" aria-describedby="passwordHelpBlock">
                                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                                            Название места покупки
                                                        </small>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="address" value="" aria-describedby="passwordHelpBlock2">
                                                        <small id="passwordHelpBlock2" class="form-text text-muted">
                                                            Адрес
                                                        </small>
                                                    </div>

                                                </div>
                                            @endif
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control" name="total_price" value="{{ $item->payed_sum }}"></td>
                                        <td>
                                            <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 mr-2" rec_id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></button></span>
                                            <span class="table-edit"><button type="button" class="btn btn-success btn-rounded btn-sm my-0" rec_id="{{ $item->id }}"><i class="fas fa-pencil-alt"></i></button></span>
                                        </td>
                                    </tr>

                                @endforeach

                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- Central Modal Small -->
    <div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <!-- Change class .modal-sm to change the size of the modal -->
        <div class="modal-dialog modal-fluid" role="document">

            <form action="{{ route('buylists.add') }}" method="post" autocomplete="off">
                <input type="hidden" name="list_id" value="{{ $data->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title w-100" id="myModalLabel">Добавление нового элемента</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        @csrf

                        <div class="input-group mb-3">

                            <select class="browser-default custom-select" name="cat" aria-describedby="button-addon2" required>
                                <option value="" selected>Выбрать категорию</option>
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <a href="/category/add/spendings" class="btn btn-md btn-default m-0 px-3 py-2 z-depth-0 waves-effect" id="button-addon2"><i class="fas fa-plus mr-1"></i> Добавить категорию
                                </a>
                            </div>
                        </div>


                        <div class="form-row mb-4 mt-5">
                            <div class="col">
                                <input type="text" name="tag" id="tag" class="form-control" placeholder="Название" required>
                                <div id="tagList"></div>

                                <input type="hidden" name="tag_id" id="tag_id" value="">
                            </div>
                            <div class="col">
                                <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" placeholder="Стоимость за ед.">

                            </div>
                            <div class="col">
                                <input type="number" step="0.01" name="total_price" id="total_price" class="form-control" placeholder="Общая стоимость">

                            </div>

                        </div>



                        <div class="form-row mb-4">

                            <div class="col">
                                <input type="number" step="0.01" name="qty" id="qty" class="form-control" placeholder="Кол-во">

                            </div>
                            <div class="col">
                                <select class="browser-default custom-select" name="tag_unit" id="tag_unit">
                                    <option value="" selected>Выбрать еденицу измерения</option>
                                    <option value="mg">мг.</option>
                                    <option value="g">г.</option>
                                    <option value="kg">кг.</option>
                                    <option value="t">т.</option>
                                    <option value="ml">мл.</option>
                                    <option value="l">л.</option>
                                    <option value="mm">мм.</option>
                                    <option value="sm">см.</option>
                                    <option value="m">м.</option>
                                    <option value="km">км.</option>
                                    <option value="sht">шт.</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-5">
                            <div class="col">

                                <input type="text" name="location" id="location" class="form-control" placeholder="Место покупки">
                                <div id="locationList">
                                </div>
                                <input type="hidden" name="location_id" id="location_id" value="">
                            </div>

                            <div class="col">

                                <input type="text" name="address" id="address" class="form-control" placeholder="Адрес">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Central Modal Small -->


    <script>
        $(document).ready(function(){

            $('#tag').on('keyup',function(){

                var query = $(this).val();
                if(query != '')
                {

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('buylists.fetch') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){

                            $('#tagList').fadeIn();
                            $('#tagList').html(data);
                        },
                        error:function (data) {
                            console.log(data);
                        }
                    });
                }
            });

            $('#location').on('keyup',function(){

                var query = $(this).val();
                if(query != '')
                {

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('spendings.fetchLoc') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){

                            $('#locationList').fadeIn();
                            $('#locationList').html(data);
                        },
                        error:function (data) {
                            console.log(data);
                        }
                    });
                }
            });

            $(document).on('click', 'li.tag', function(){
                var el_unit = $(this).attr('el-unit');
                var tag_id = $(this).attr('tag-id');
                var loc_id = $(this).attr('loc-id');
                var tag_price = $(this).attr('tag-price')
                var tag_name = $(this).attr('tag-name');
                var loc_name = $(this).attr('loc-name');
                var loc_addr = $(this).attr('loc-addr');
                $('#tag_unit').val(el_unit);
                $('#tag_id').val(tag_id);
                $('#location_id').val(loc_id);
                $('#tag').val(tag_name);
                $('#unit_price').val(tag_price);
                $('#location').val(loc_name);
                $('#address').val(loc_addr);
                $('#tagList').fadeOut();
            });

            $(document).on('click', 'li.location', function(){

                var loc_id = $(this).attr('loc-id');

                var loc_name = $(this).attr('loc-name');
                var loc_addr = $(this).attr('loc-addr');

                $('#location_id').val(loc_id);

                $('#location').val(loc_name);
                $('#address').val(loc_addr);
                $('#locationList').fadeOut();
            });

            $('#qty').on('keyup',function(){

                var qty = $(this).val();
                if(qty != '')
                {

                    var u_price = $('#unit_price').val();

                    var t_price = u_price * qty;

                    $('#total_price').val(t_price);

                }
            });



        });
    </script>

@endsection
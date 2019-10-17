@extends('layouts.app')

@section('content')


    <!--Section: Inputs-->
    <section class="section card mb-5">

        <div class="card-body">

            <!--Section heading-->

            <h5 class="pb-5">Расход</h5>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-4">


                    <form action="{{ route('spendings.store') }}" method="post" autocomplete="off">
                        @csrf


                        <fieldset class="mb-5">
                            <legend>Общие параметры</legend>
                        <div class="form-group">
                            <input placeholder="Выбрать дату" type="text" name="date" id="date-picker-example" class="form-control datepicker">

                        </div>
                        <div class="form-row">
                            <div class="col">
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
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <select class="browser-default custom-select" name="ballance_type_id" aria-describedby="button-addon2" required>
                                        <option value="" selected>Выбрать вид средств</option>
                                        @foreach ($ballance_types as $type)
                                            <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <a href="/settings/ballancetypes" class="btn btn-md btn-default m-0 px-3 py-2 z-depth-0 waves-effect" id="button-addon2"><i class="fas fa-plus mr-1"></i> Добавить вид средств
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </fieldset>


                        <fieldset class="mb-5">

                            <legend>Продукт</legend>

                        <div class="form-group">
                            <div class="form-row mb-4">
                                <div class="col">
                                    <input type="text" name="tag" id="tag" class="form-control" placeholder="Название" required>
                                    <div id="tagList">
                                    </div>
                                    <input type="hidden" name="tag_id" id="tag_id" value="">
                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" name="total_price" id="total_price" class="form-control" placeholder="Общая стоимость" required>

                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" name="qty" id="qty" class="form-control" placeholder="Кол-во" required>

                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select" name="tag_unit" id="tag_unit" required>
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
                        </div>

                        </fieldset>

                        <fieldset class="mb-5">
                            <legend>Локация</legend>

                        <div class="form-group">
                            <input type="text" name="location" id="location" class="form-control" placeholder="Место покупки" required>
                            <div id="locationList">
                            </div>

                            <input type="hidden" name="location_id" id="location_id" value="">
                        </div>
                        <div class="form-group">
                            <input type="text" name="address" id="address" class="form-control" placeholder="Адрес"  required>


                        </div>

                        </fieldset>

                        <button type="submit" class="btn btn-primary">Добавить</button>

                </form>
                </div>

            </div>
            <!--Grid column-->


        </div>
        <!--Grid row-->

        </div>

    </section>
    <!--Section: Inputs-->

    <script>
        $(document).ready(function(){

            $('#tag').on('keyup',function(e){

                e.preventDefault();
                var query = $(this).val();
                if(query != '')
                {

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('spendings.fetch') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            console.log(data);
                            if(data !== 'undefined' && data !== null) {
                                $('#tagList').fadeIn();
                                $('#tagList').html(data);
                            }
                        },
                        error:function (data) {
                            console.log(data);
                        }
                    });
                }
            });

            $('#location').on('keyup',function(e){

                e.preventDefault();

                var query = $(this).val();
                if(query != '')
                {

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('spendings.fetchLoc') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if(data !== 'undefined' && data !== null) {
                                $('#locationList').fadeIn();
                                $('#locationList').html(data);
                            }
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
                var tag_name = $(this).attr('tag-name');
                var loc_name = $(this).attr('loc-name');
                var loc_addr = $(this).attr('loc-addr');
                $('#tag_unit').val(el_unit);
                $('#tag_id').val(tag_id);
                $('#location_id').val(loc_id);
                $('#tag').val(tag_name);
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

        });
    </script>


@endsection
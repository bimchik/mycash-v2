@extends('layouts.app')

@section('content')

    <!--Section: Inputs-->
    <section class="section card mb-5">

        <div class="card-body">

            <!--Section heading-->

            <h5 class="pb-5">Доход</h5>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-4">


                        <form action="{{ route('incomings.add') }}" method="post">
                            @csrf
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
                                            <a href="/category/add/incomings" class="btn btn-md btn-default m-0 px-3 py-2 z-depth-0 waves-effect" id="button-addon2"><i class="fas fa-plus mr-1"></i> Добавить категорию
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
                            <div class="form-group">
                                <input type="number" step="0.01" name="price" id="form1" class="form-control" placeholder="Сумма" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>


                </div>
                <!--Grid column-->


            </div>
            <!--Grid row-->

        </div>

    </section>
    <!--Section: Inputs-->


@endsection
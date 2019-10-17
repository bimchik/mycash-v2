@extends('layouts.app')

@section('content')

    <!--Section: Inputs-->
    <section class="section card mb-5">

        <div class="card-body">

            <!--Section heading-->

            <h5 class="pb-5">Создание категории</h5>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-4">

                    <div class="md-form">
                        <form action="{{ route('categories.add') }}" method="post">
                            @csrf
                            <input type="text" name="name" id="form1" class="form-control">
                            <label for="form1"  class="">Название категории</label>
                            <input type="hidden" name="section" value="{{ $section }}">
                            @if($section == 'spendings')
                            <div class="md-form">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="commun_bill" name="commun_bill" value="1" autocomplete="false">
                                    <label class="form-check-label" for="commun_bill">Коммунальные платежи</label>
                                </div>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </form>
                    </div>

                </div>
                <!--Grid column-->


            </div>
            <!--Grid row-->

        </div>

    </section>
    <!--Section: Inputs-->


@endsection
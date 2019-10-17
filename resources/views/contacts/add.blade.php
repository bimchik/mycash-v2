@extends('layouts.app')

@section('content')

    <!--Section: Button icon-->
    <section>

        <div class="row">

            <div class="col text-center">
                <form class="form-inline mr-auto" method="post" action="/contacts/search" id="search-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="search-input" class="form-control mr-sm-2" name="search_contact" type="text" placeholder="Найти контакт" aria-label="Найти контакт">
                    <button class="btn btn-unique btn-rounded btn-sm my-0" type="submit">Поиск</button>
                </form>
            </div>

        </div>
        @if(isset($results) && !empty($results))
        <div class="row my-5">
            @foreach($results as $result)
            <div class="col-md-3">

                <div class="card testimonial-card">

                    <!-- Background color -->
                    <div class="card-up indigo lighten-1"></div>

                    <!-- Avatar -->
                    <div class="avatar mx-auto white">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%2810%29.jpg" class="rounded-circle" alt="woman avatar">
                    </div>

                    <!-- Content -->
                    <div class="card-body">
                        <!-- Name -->
                        <h4 class="card-title">{{ $result['name'] }}</h4>
                        <h5 class="card-title">{{ $result['email'] }}</h5>
                        <hr>
                        <!-- Quotation -->
                        <p>
                            <form method="post" action="/contacts/store">
                                @csrf
                                <input type="hidden" name="contact_id" value="{{ $result['account']['id'] }}">
                                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Добавить контакт</button>
                            </form>
                        </p>
                    </div>

                </div>

            </div>
            @endforeach
        </div>

        @endif

    </section>
    <!--/Section: Button icon-->

@endsection

@section('page-scripts')

@endsection


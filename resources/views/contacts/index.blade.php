@extends('layouts.app')

@section('content')



    <!--Section: Button icon-->
    <section>

        <div class="row">
            <div class="col text-center">
                <a href="/contacts/add" class="btn btn-success"><i class="fas fa-plus"></i> Добавить контакт</a>
            </div>
        </div>
        <!--Grid row-->
        <div class="row mb-5">



            @if(isset($contacts))
                @foreach($contacts as $contact)

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
                                <h4 class="card-title">{{ $contact->user->name }}</h4>
                                <h5 class="card-title">{{ $contact->user->email }}</h5>
                                <hr>
                                <!-- Quotation -->
                                <p>

                                </p>
                            </div>

                        </div>

                    </div>

                @endforeach


            @endif

        </div>

    </section>
    <!--/Section: Button icon-->


@endsection

@section('page-scripts')

@endsection


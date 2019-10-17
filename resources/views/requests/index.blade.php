@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <nav class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-tome-tab" data-toggle="tab" href="#nav-tome" role="tab"
                   aria-controls="nav-tome" aria-selected="true">Входящие</a>
                <a class="nav-item nav-link" id="nav-fromme-tab" data-toggle="tab" href="#nav-fromme" role="tab"
                   aria-controls="nav-fromme" aria-selected="false">Исходящие</a>
            </nav>
        </div>
    </div>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-tome" role="tabpanel" aria-labelledby="nav-tome-tab">
            <div class="row mb-5">
                    @if(!auth()->user()->account->requestsToMe()->isEmpty())
                        @foreach(auth()->user()->account->requestsToMe() as $contact)

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
                                        <form method="post" action="/requests/accept">
                                            @csrf
                                            <input type="hidden" name="req_id" value="{{ $contact->id }}">
                                            <button type="submit" class="btn btn-success btn-block"><i class="fas fa-check mr-2"></i> Подтвердить</button>
                                        </form>
                                        </p>
                                        <p>
                                        <form method="post" action="/requests/cancel">
                                            @csrf
                                            <input type="hidden" name="req_id" value="{{ $contact->id }}">
                                            <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-times mr-2"></i> Отклонить</button>
                                        </form>
                                        </p>
                                    </div>

                                </div>

                            </div>

                        @endforeach
                    @endif
            </div>
        </div>
        <div class="tab-pane fade" id="nav-fromme" role="tabpanel" aria-labelledby="nav-fromme-tab">
            <div class="row mb-5">

                @if(!auth()->user()->account->requestsMe()->isEmpty())
                    @foreach(auth()->user()->account->requestsMe() as $contact)

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
                                    <form method="post" action="/requests/cancel">
                                        @csrf
                                        <input type="hidden" name="req_id" value="{{ $contact->id }}">
                                        <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-times mr-2"></i> Отменить</button>
                                    </form>
                                    </p>
                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

            </div>

        </div>
    </div>

@endsection
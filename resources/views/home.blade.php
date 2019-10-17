@extends('layouts.app')

@section('content')



    <!--Section: Button icon-->
    <section>

        <!--Grid row-->
        <div class="row mb-5">


            @if(!$ball_arr->isEmpty() || !$shareBall->isEmpty())
                @if(!$ball_arr->isEmpty())
                @foreach($ball_arr as $ball)
                    <div class="col">
                    <!--Card-->
                        <div class="card text-center">

                            <div class="card-header pt-3">
                                <h4 class="card-header-title">{{ $ball->ballance_type->name }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        Баланс за {{ $ball->month_name }} {{ $ball->year }}
                                        <br><br>
                                        <span class="ballance-sum
                                                    @if($ball->sum >= 0)
                                                        text-success
                                                    @else
                                                        text-danger
                                                    @endif
                                        ">{{ $ball->sum }}</span>
                                        грн
                                    </div>
                                    <div class="col text-muted">Прошлый месяц<br><br>
                                        <span class="last-month-ball">
                                            @php($ball_sum = "0,00")
                                            @foreach($prev_ball_arr as $prev)
                                                @if($prev->ballance_type->id == $ball->ballance_type_id)
                                                    @php($ball_sum=$prev->sum)
                                                @endif
                                            @endforeach
                                            {{ $ball_sum }}
                                        </span>
                                        грн
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="/allops/{{$ball->ballance_type->id}}" class="btn btn-outline-success btn-block"><i class="fas fa-plus mr-2"></i> Доход</a>
                                    </div>
                                    <div class="col">
                                        <a href="/allops/{{$ball->ballance_type->id}}" class="btn btn-outline-danger btn-block"><i class="fas fa-minus mr-2"></i> Расход</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="/allops/{{$ball->ballance_type->id}}" class="btn btn-outline-default btn-block"><i class="fas fa-hand-holding-usd mr-2"></i> Все операции</a>
                                    </div>
                                    @if($ball_arr->count() > 1)
                                        <div class="col">
                                            <a class="btn btn-outline-primary ballId btn-block" data-id="{{$ball->ballance_type->id}}" ><i class="fas fa-exchange-alt mr-2"></i> Перенести</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/.Card-->
                    </div>

                @endforeach

                @endif

                    @if(!$shareBall->isEmpty())
                        @foreach($shareBall as $ball)
                            <div class="col">
                                <!--Card-->
                                <div class="card text-center">

                                    <div class="card-header pt-3">
                                        <h4 class="card-header-title">{{ $ball->ballance_type->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                Баланс за {{ $ball->month_name }} {{ $ball->year }}
                                                <br><br>
                                                <span class="ballance-sum
                                                    @if($ball->sum >= 0)
                                                        text-success
                                                    @else
                                                        text-danger
                                                    @endif
                                                        ">{{ $ball->sum }}</span>
                                                грн
                                            </div>
                                            <div class="col text-muted">Прошлый месяц<br><br>
                                                <span class="last-month-ball">
                                            @php($ball_sum = "0,00")
                                                    @foreach($prev_shareBall as $prev)
                                                        @if($prev->ballance_type->id == $ball->ballance_type_id)
                                                            @php($ball_sum=$prev->sum)
                                                        @endif
                                                    @endforeach
                                                    {{ $ball_sum }}
                                        </span>
                                                грн
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/allops/{{$ball->ballance_type->id}}" class="btn btn-outline-default"><i class="fas fa-hand-holding-usd mr-2"></i> Все операции</a>
                                        @if($ball_arr->count() > 1)
                                            <a class="btn btn-outline-primary ballId" data-id="{{$ball->ballance_type->id}}" ><i class="fas fa-exchange-alt mr-2"></i> Перенести</a>
                                        @endif
                                    </div>
                                </div>
                                <!--/.Card-->
                            </div>

                        @endforeach

                    @endif

            @else

                <div class="col text-center">
                    <a href="/settings/ballancetypes" class="btn btn-success"><i class="fas fa-plus"></i> Добавить тип средств</a>
                </div>

            @endif

        </div>
        <!--Grid row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5 p-5">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </section>
    <!--/Section: Button icon-->

    <!-- Modal -->
    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('transfers.transfer') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Перенос средств</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="form-row mb-3 mt-3">
                                <div class="col">
                                    <select class="browser-default custom-select" id="ballId" name="from_ball_type" required>
                                        <option value="" selected>Выбрать вид средств</option>
                                        @foreach ($ball_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select" name="to_ball_type" id="to_ball" required>
                                        <option value="" selected>Выбрать вид средств</option>
                                        @foreach ($ball_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <input type="number" step="0.01" class="form-control" name="trans_sum" placeholder="Сумма" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Перенести</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script>
        //bar
        var spend_name = new Array();
        var spend_val = new Array();

        @foreach($spend_arr as $sp)

            var name = "{{ $sp->category->name }}";
            var val = "{{ $sp->sum }}";

            spend_name.push(name);
            spend_val.push(val);

        @endforeach

        var ctxB = document.getElementById("barChart").getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: spend_name,
                datasets: [{
                    label: '# Расходы',
                    data: spend_val,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true
            }
        });

        $(document).on("click", ".ballId", function (e) {
            var ballId = $(e.target).data('id');

            $('#to_ball option[value='+ballId+']').remove();
            $(".modal-body #ballId").val( ballId );
            $('#transferModal').modal('show');
        });

    </script>
@endsection


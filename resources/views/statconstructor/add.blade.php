@extends('layouts.app')

@section('content')

<div class="section card md-5">

    <form>

        <div class="card-header">
            <h4 class="card-header-title">Конструктор статистики</h4>
        </div>

        <div class="card-body">

            <fieldset>
                <legend>Общие настройки</legend>
            </fieldset>

            <div class="form-row">

                <div class="col">
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col">
                    <select class="browser-default custom-select" name="type_chart" required>
                        <option value="" selected>Выбрать тип статистики</option>
                        <option value="line">line</option>
                        <option value="radar">radar</option>
                        <option value="bar">bar</option>
                        <option value="hor_bar">hor_bar</option>
                        <option value="pie">pie</option>
                        <option value="polar">polar</option>
                        <option value="doughnat">doughnat</option>
                    </select>
                </div>

            </div>

        </div>

        <div class="card-footer">

        </div>

    </form>

</div>

@endsection
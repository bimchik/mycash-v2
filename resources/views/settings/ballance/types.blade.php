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
                    <th class="th-sm">Возможность трансфера средств
                    </th>
                    <th class="th-sm">Возможность отрицательного баланса
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($ballance_types as $type)

                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->can_transfer }}</td>
                        <td>{{ $type->can_minus }}</td>
                        <td>
                            @if($type->shareContacts !== null)
                            <ul>
                                @foreach($type->shareContacts as $cont)
                                    <li>{{ $cont->user->name }} | {{ $cont->user->email }}</li>
                                @endforeach
                            </ul>
                            @endif
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

            <h5 class="pb-5">Добавить тип средств</h5>

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-4">


                    <form action="{{ route('ballancetypes.store') }}" method="post" id="addForm">
                        @csrf

                        <div class="md-form">
                            <input type="text" name="name" id="form1" class="form-control" required>
                            <label for="form1"  class="">Название</label>
                        </div>
                        <div class="md-form">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="can_transfer" name="can_transfer" value="1" autocomplete="false" checked>
                                <label class="form-check-label" for="can_transfer">Возможность трансфера средств</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="can_minus" name="can_minus" value="1" autocomplete="false">
                                <label class="form-check-label" for="can_minus">Возможность отрицательного баланса</label>
                            </div>
                        </div>
                            <select class="mdb-select md-form" multiple searchable="Поиск.." name="contacts[]" autocomplete="false" selectAllLabel=Все контакты optionsSelectedLabel="контактов">
                                <option value="" disabled selected>Доступен для</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}" data-icon="https://mdbootstrap.com/img/Photos/Avatars/avatar-1.jpg" class="rounded-circle">
                                        {{ $contact->user->name }} ( {{ $contact->user->email }} )
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn-save btn btn-primary btn-sm">Выбрать</button>

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

@endsection

@section('page-scripts')
<script>
    $(document).ready(function() {
        $('.mdb-select').materialSelect();
    });
</script>
@endsection
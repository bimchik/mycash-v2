<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg scrolling-navbar double-nav">
    <!-- SideNav slide-out button -->
    <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse black-text"><i class="fas fa-bars"></i></a>
    </div>
    <!-- Breadcrumb-->


    <div class="info-top mr-3 ml-5"><a href="#" class="btn btn-rounded btn-outline-primary waves-effect">Баланс: <strong class="font-weight-bold">{{ $ball_total->sum }} грн</strong>
        </a></div>
    <div class="info-top mr-3">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="/incomings/add" class="btn btn-success btn-rounded waves-effect"><i class="fas fa-plus mr-2"></i></a>
            <a href="/category/incomings" class="btn btn-success btn-rounded waves-effect">Доход: <strong class="font-weight-bold">{{ $inc_sum }} грн</strong></a>
        </div>
    </div>
    <div class="info-top">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="/spendings/add" class="btn btn-danger btn-rounded waves-effect"><i class="fas fa-minus mr-2"></i></a>
            <a href="/category/spendings" class="btn btn-danger btn-rounded waves-effect">Расход: <strong class="font-weight-bold">{{ $spend_sum }} грн</strong></a>
        </div>
    </div>

    <!--Navbar links-->
    <ul class="nav navbar-nav nav-flex-icons ml-auto">

        <!-- Dropdown -->
        <li class="nav-item dropdown notifications-nav">
            <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <span class="badge red">3</span> <i class="fas fa-bell"></i>
                <span class="d-none d-md-inline-block">Уведомления</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-money mr-2" aria-hidden="true"></i>
                    <span>New order received</span>
                    <span class="float-right"><i class="far  fa-clock" aria-hidden="true"></i> 13 min</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-money mr-2" aria-hidden="true"></i>
                    <span>New order received</span>
                    <span class="float-right"><i class="far  fa-clock" aria-hidden="true"></i> 33 min</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-line-chart mr-2" aria-hidden="true"></i>
                    <span>Your campaign is about to end</span>
                    <span class="float-right"><i class="far  fa-clock" aria-hidden="true"></i> 53 min</span>
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect" href="#" id="userDropdown" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i> <span class="clearfix d-none d-sm-inline-block">Профиль</span></a>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/logout">Выход</a>
                <a class="dropdown-item" href="#">Данные аккаунта</a>
            </div>
        </li>

    </ul>
    <!--/Navbar links-->
</nav>
<!-- /.Navbar -->
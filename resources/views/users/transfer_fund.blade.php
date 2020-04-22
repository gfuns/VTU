@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - Transfer Fund')

<!-- MAIN CONTENT -->
<div class="main-content bg-fixed-bottom" >

    <!-- Navbar section -->
    <nav class="navbar navbar-expand-md navbar-light d-none d-md-flex" id="topbar">
        <div class="container-fluid dashboard-nav-pad">
            <!-- Form -->
            <form class="form-inline mr-4 d-none d-md-flex">
                <div class="input-group input-group-flush input-group-merge">
                    <!-- Input -->

                </div>
            </form>

            <!-- User -->
            <div class="navbar-user">
                <!-- Dropdown -->
                <div class="dropdown">
                  <!-- Toggle -->
                  <span href="#" class="avatar avatar-sm avatar-online dropdown-toggle" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{asset("img/user-default.jpg")}}" alt="..." class="rounded-circle" width="40px">
              </span>

              <!-- Menu -->
              <div class="dropdown-menu dropdown-menu-right">
                  <a href="/settings/profile" class="dropdown-item">Profile</a>
                  <a href="/settings/profile" class="dropdown-item">Settings</a>
                  <hr class="dropdown-divider">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">Logout</a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
</nav>
<!-- Navbar section end -->


<div class="container-fluid" style="min-height: 900px;">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-6">

            <div class="row d-md-none">
                <div class="col-12">
                    <div class="search-bar rounded p-3 p-lg-4 mt-4 z-index-20">
                        <form id="service-form" action="#">
                            <div class="row">
                                <div class="col-lg-4 d-flex align-items-center form-group">
                                    <input type="search" name="search" placeholder="What do you want to do?"
                                    class="form-control border-0 shadow-0 text-black" disabled style="background-color: #fff;">
                                </div>
                                <div class="col-md-6 col-lg-3 d-flex align-items-center form-group no-divider">
                                    <select id="service-categories-field" onchange="onServiceCategorySelected()" title="Select Service"
                                    data-style="btn-form-control" class="selectpicker">
                                    <option value="airtime" class="text-black">Airtime</option>
                                    <option value="data" class="text-black">Data</option>
                                    <option value="power" class="text-black">Power</option>
                                    <option value="cable" class="text-black">Cable</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 d-flex align-items-center form-group no-divider">
                                <select  onchange="onServiceSelected()" id="services-field"
                                data-style="btn-form-control" class="selectpicker">
                            </select>
                        </div>
                        <div class="col-lg-2 form-group mb-0">
                            <button type="submit" class="btn btn-dark btn-block h-100" style="letter-spacing: .3em;">CONTINUE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>            
    <!-- Header -->
    <div class="header mt-md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        My Account
                    </h6>

                    <!-- Title -->
                    <h1 class="header-title">
                        Transfer Fund
                    </h1>

                </div>
            </div> <!-- / .row -->
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Title -->
                            <h6 class="card-title text-uppercase text-muted mb-2">
                                Wallet Balance
                            </h6>
                            <!-- Heading -->
                            <span class="h2 mb-0">&#8358;{{number_format($wallet->balance, 2)}}</span>
                        </div>

                        <div class="btn-group">
                            <a href="/fund-account" class="btn btn-success btn-sm">Top Wallet</a>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
    </div>
    <!-- Form -->

    <form method="post" action="" class="mb-4">
       @csrf
       <div class="col-12 card card-body">
        <div class="row">
            <div class="col-6 col-md-6">
                <!-- Last name -->
                <div class="form-group">
                    <label>
                        Username
                    </label>
                    <input type="text" name="username" class="form-control " value="" placeholder="Username">


                </div>
            </div>

            <div class="col-6 col-md-6">
                <!-- Phone -->
                <div class="form-group">
                    <label>
                        Amount In Naira:
                    </label>
                    <input type="number" name="amount" class="form-control mb-3 " placeholder="Amount">


                </div>
            </div>
        </div>
    </div> <!-- / .row -->

    <div class="row">
        <div class="col-12 col-md-12">
            <button type="submit" class="btn btn-warning btn-block">Transfer</button>
        </div>

    </div> <!-- / .row -->

</form>

</div>
</div> <!-- / .row -->
</div>
</div>

@endsection
@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - Cable subscription')


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
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        Cable Subscription
                    </h6>
                    <!-- Title -->
                    <h1 class="header-title">
                        Cable Subscription
                    </h1>
                </div>

                <div class="col-md-3 d-none d-sm-none d-md-block">
                    <div class="text-right">
                        <img src="{{asset("img/gotv.png")}}" width="30px">
                        <img src="{{asset("img/dstv.png")}}" width="30px">
                        <img src="{{asset("img/startimes.png")}}" width="30px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-2">
        <div class="col-4 card p-0">
            <a href="/cable-subscription/gotv">
                <div class="card-body text-center">
                    <img src="{{asset("img/gotv.png")}}" class="service_img_cable">
                </div>
            </a>
        </div>

        <div class="col-4 card p-0">
            <a href="/cable-subscription/dstv">
                <div class="card-body text-center">
                    <img src="{{asset("img/dstv.png")}}" class="service_img_cable">
                </div>
            </a>
        </div>

        <div class="col-4 card p-0">
            <a href="/cable-subscription/startimes">
                <div class="card-body text-center">
                    <img src="{{asset("img/startimes.png")}}" class="service_img_cable">
                </div>
            </a>
        </div>
    </div>
</div>
</div> <!-- / .row -->
</div>
</div>

@endsection
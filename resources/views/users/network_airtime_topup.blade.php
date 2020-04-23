@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - '.ucwords($param).' Airtime Topup')

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
                <div class="col-9">
                    <!-- Pretitle -->
                    <h6 class="header-pretitle">
                        Airtime Topup
                    </h6>
                    <!-- Title -->
                    <h1 class="header-title">
                        {{ucwords($param)}} Airtime Topup
                    </h1>
                </div>
                <div class="col-3">
                    <div class="text-right">
                        @if($param == "airtel")
                        <img src="{{asset("img/airtel-airtime.png")}}" width="60px">
                        @elseif($param == "mtn")
                        <img src="{{asset("img/mtn.png")}}" width="60px">
                        @elseif($param == "glo")
                        <img src="{{asset("img/glo-airtime.png")}}" width="60px">
                        @elseif($param == "9mobile")
                        <img src="{{asset("img/9mobile-airtime.png")}}" width="60px">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{route("airtimetopup.initiate")}}">
                @csrf
                <input type="hidden" name="biller" value="{{$param}}" class="form-control">
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <div style="display: flex; align-items: baseline">
                            <label style="margin-right: 4px">Phone Number</label>
                            <span class="mr-1 ml-1">|</span>
                            <div class="dropdown">
                                <a href="#" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Choose Beneficiaries
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                {{-- <option value="08188664322">Gabriel</option>
                                <option value="09033446622">Jessica</option>
                                <option value="09033446622">Jessica</option>
                                <option value="09033446622">Jessica</option>
                                <option value="09033446622">Jessica</option>
                                <option value="09033446622">Jessica</option>
                                <option value="09033446622">Jessica</option> --}}
                            </div>
                        </div>
                    </div>
                    <input type="text" name="phone" id="phone-field" value="{{Auth::user()->phone}}" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Phone Number" required="required" autocomplete="off">
                    @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif

                    <h5 class="mt-2" id="save-beneficiary-toggle">
                        <li class="fa fa-address-card"></li>
                        Save as Beneficiary
                    </h5>
                    <div id="beneficiary-name-container">
                        <input type="text" name="beneficiary_name" id="beneficiary-name-field"
                        class="form-control" placeholder="Beneficiary Name">
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label>Amount<br/>&nbsp;</label>
                    <input type="number" name="amount" value="" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="Amount" required="required" min="100" max="50000" autocomplete="off">
                    @if ($errors->has('amount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif

                </div>
            </div>
            <div class="form-row">
                <div class="col-12 col-md-6 mb-3">
                    <label>Email</label>
                    <input type="text" name="email" value="{{Auth::user()->email}}" class="form-control " placeholder="Email" autocomplete="off">


                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label>Voucher Code <small class="text-muted">(Optional)</small></label>
                    <input type="text" name="voucher" class="form-control " placeholder="Voucher Code">


                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary lift btn-block">
                    Proceed now
                </button>
            </div>
        </form>
    </div>
</div>
</div>
</div> <!-- / .row -->
</div>
</div>

@endsection
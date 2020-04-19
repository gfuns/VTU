@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - '.$label)

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
                    <img src="https://ceepay.ng/img/user-default.jpg" alt="..." class="rounded-circle" width="40px">
                </span>

                <!-- Menu -->
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="https://ceepay.ng/settings/profile" class="dropdown-item">Profile</a>
                    <a href="https://ceepay.ng/settings/profile" class="dropdown-item">Settings</a>
                    <hr class="dropdown-divider">
                    <a href="https://ceepay.ng/logout"
                    onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                    class="dropdown-item">Logout</a>
                    <form id="frm-logout" action="https://ceepay.ng/logout" method="POST"
                    style="display: none;"> <input type="hidden" name="_token" value="4BqwgV9S9XGkekRKPc7r01Lg5aTMM52itKzwogtf">
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
                        Power Subscription
                    </h6>
                    <!-- Title -->
                    <h1 class="header-title">
                        {{$label}}
                    </h1>
                </div>
                <div class="col-3">
                    <div class="text-right">
                        @if($param == "aedc-electric")
                        <img src="{{asset("img/aedc-electricity.png")}}" width="60px">
                        @elseif($param == "eko-electric")
                        <img src="{{asset("img/ekedc.png")}}" width="60px">
                        @elseif($param == "ikeja-electric")
                        <img src="{{asset("img/ikeja.png")}}" width="60px">
                        @elseif($param == "jos-electric")
                        <img src="{{asset("img/jos-electricity.png")}}" width="60px">
                        @elseif($param == "kano-electric")
                        <img src="{{asset("img/kano-electricity.png")}}" width="60px">
                        @elseif($param == "portharcourt-electric")
                        <img src="{{asset("img/phed-electricity.png")}}" width="60px">
                        @elseif($param == "ibadan-electric")
                        <img src="{{asset("img/ibedc-electricity.png")}}" width="60px">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <form method="post" action="">
                @csrf        
                <div class="form-row">
                    <div class="col-12 col-md-6 mb-3">
                        <label>Meter Type</label>
                        <select name="meter_type" class="form-control ">
                            <option value="postpaid">Postpaid Meter</option>
                            <option value="prepaid">Prepaid Meter</option>
                        </select>


                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div style="display: flex; align-items: baseline">
                            <label style="margin-right: 4px">Meter</label>
                            <span class="mr-1 ml-1">|</span>
                            <div class="dropdown">
                                <a href="#" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Choose Beneficiaries
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            </div>
                        </div>
                    </div>
                    <input type="text" id="meter-field" name="meter_number"
                    value=""
                    class="form-control "
                    placeholder="Meter Number" required>


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
                    <label>Phone Number</label>
                    <input type="text" name="phone"
                    value="+2347037382623"
                    class="form-control " placeholder="Phone Number"
                    required>


                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label>Amount</label>
                    <input type="number" id="amount-field" name="amount" value=""
                    class="form-control " placeholder="Amount" required>


                </div>
            </div>
            <div class="form-row">
                <div class="col-12 col-md-6 mb-3">
                    <label>Email</label>
                    <input type="text" name="email"
                    value="emalinerosemiller@gmail.com"
                    class="form-control " placeholder="Email">


                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label>Voucher Code <small class="text-muted">(Optional)</small></label>
                    <input type="text" name="voucher" class="form-control "
                    placeholder="Voucher Code">


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
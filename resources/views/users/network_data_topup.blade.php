@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - '.ucwords($param).' Data Topup')

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
                        Data Topup
                    </h6>
                    <!-- Title -->
                    <h1 class="header-title">
                        {{ucwords($param)}} Data Topup
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
        <form method="post" action="">
            @csrf
            <div class="form-row">
                <div class="col-12 col-md-12 mb-3">
                    <label>Choose Plan</label>
                    @if($param == "airtel")
                    <select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
                    <option value="airt-50" data-amount="49.99">Airtel Data Bundle - 50 Naira - 20MB  - 1Day
                    ( ₦49.99 )</option>
                    <option value="airt-100" data-amount="99.00">Airtel Data Bundle - 100 Naira - 1Day ( ₦99.00 )</option>
                    <option value="airt-200" data-amount="199.03">Airtel Data Bundle - 200 Naira - 200MB - 3Days
                    ( ₦199.03 )</option>
                    <option value="airt-300" data-amount="299.02">Airtel Data Bundle - 300 Naira - 350MB - 7 Days
                    ( ₦299.02 )</option>
                    <option value="airt-500" data-amount="499.00">Airtel Data Bundle - 500 Naira - 750MB - 14 Days
                    ( ₦499.00 )</option>
                    <option value="airt-1500" data-amount="1499.01">Airtel Data Bundle - 1,500 Naira - 2.5GB + 1GB Night Plan - 30 Days
                    ( ₦1,499.01 )</option>
                    <option value="airt-2000" data-amount="1999.00">Airtel Data Bundle - 2,000 Naira - 3.5GB - 30 Days
                    ( ₦1,999.00 )</option>
                    <option value="airt-3000" data-amount="2999.02">Airtel Data Bundle - 3,000 Naira - 5.5GB - 30 Days
                    ( ₦2,999.02 )</option>
                    <option value="airt-4000" data-amount="3999.01">Airtel Data Bundle - 4,000 Naira - 7.5GB + 2GB Night Plan - 30 Days
                    ( ₦3,999.01 )</option>
                    <option value="airt-5000" data-amount="4999.00">Airtel Data Bundle - 5,000 Naira - 10GB + 2GB Night Plan - 30 Days
                    ( ₦4,999.00 )</option>
                    <option value="airt-10000" data-amount="9999.00">Airtel Data Bundle - 10,000 Naira - 25GB - 30 Days
                    ( ₦9,999.00 )</option>
                    <option value="airt-15000" data-amount="14999.00">Airtel Data Bundle - 15,000 Naira - 40GB - 30 Days
                    ( ₦14,999.00 )</option>
                    <option value="airt-20000" data-amount="19999.02">Airtel Data Bundle - 20,000 Naira - 60GB - 30 Days
                    ( ₦19,999.02 )</option>
                </select>
                @elseif($param == "mtn")
                <select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
                <option value="mtn-10mb-100" data-amount="100.00">N100 30MB - 24hrs ( ₦100.00 )</option>
                <option value="mtn-50mb-200" data-amount="200.00">N200 100MB -24hrs ( ₦200.00 )</option>
                <option value="mtn-150mb-500" data-amount="500.00">N500 750MB - 7 Days ( ₦500.00 )</option>
                <option value="mtn-100mb-1000" data-amount="1000.00">N1000 1.5GB - 30days ( ₦1,000.00 )</option>
                <option value="mtn-500mb-2000" data-amount="2000.00">N2000 3.5GB - 30days ( ₦2,000.00 )</option>
                <option value="mtn-100hr-5000" data-amount="5000.00">MTN Data Bundle - 5000 Naira ( ₦5,000.00 )</option>
                </select>
                @elseif($param == "glo")
                <select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
                <option value="glo100" data-amount="100.00">Glo Data N100 -  105MB - 2 day ( ₦100.00 )</option>
                <option value="glo200" data-amount="200.00">Glo Data N200 -  350MB - 4 days ( ₦200.00 )</option>
                <option value="glo500" data-amount="500.00">Glo Data N500 -  1.05GB - 14 days ( ₦500.00 )</option>
                <option value="glo1000" data-amount="1000.00">Glo Data N1000 -  2.5GB - 30 days ( ₦1,000.00 )</option>
                <option value="glo1500" data-amount="1500.00">Glo Data N1500 -  4.1GB - 30 days ( ₦1,500.00 )</option>
                <option value="glo2000" data-amount="2000.00">Glo Data N2000 -  5.8GB - 30 days ( ₦2,000.00 )</option>
                <option value="glo2500" data-amount="2500.00">Glo Data N2500 -  7.7GB - 30 days ( ₦2,500.00 )</option>
                <option value="glo3000" data-amount="3000.00">Glo Data N3000 -  10GB - 30 days ( ₦3,000.00 )</option>
                <option value="glo4000" data-amount="4000.00">Glo Data N4000 -  13.25GB - 30 days ( ₦4,000.00 )</option>
                <option value="glo5000" data-amount="5000.00">Glo Data N5000 -  18.25GB - 30 days ( ₦5,000.00 )</option>
                <option value="glo8000" data-amount="8000.00">Glo Data N8000 -  29.5GB - 30 days ( ₦8,000.00 )</option>
                <option value="glo10000" data-amount="10000.00">Glo Data N10000 -  50GB - 30 days ( ₦10,000.00 )</option>
                <option value="glo15000" data-amount="15000.00">Glo Data N15000 -  93GB - 30 days ( ₦15,000.00 )</option>
                <option value="glo18000" data-amount="18000.00">Glo Data N18000 -  119GB - 30 days ( ₦18,000.00 )</option>
                <option value="glo20000" data-amount="20000.00">Glo Data N20000 -  138GB - 30 days ( ₦20,000.00 )</option>
                </select>
                @elseif($param == "9mobile")
                <select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
                <option value="eti-100" data-amount="100.00">9mobile Data - 100 Naira - 100MB - 1 day ( ₦100.00 )</option>
                <option value="eti-200" data-amount="200.00">9mobile Data - 200 Naira - 650MB - 1 day ( ₦200.00 )</option>
                <option value="eti-500" data-amount="500.00">9mobile Data - 500 Naira - 500MB - 30 Days ( ₦500.00 )</option>
                <option value="eti-1000" data-amount="1000.00">9mobile Data - 1000 Naira - 1.5GB - 30 days ( ₦1,000.00 )</option>
                <option value="eti-2000" data-amount="2000.00">9mobile Data - 2000 Naira - 4.5GB Data - 30 Days ( ₦2,000.00 )</option>
                <option value="eti-5000" data-amount="5000.00">9mobile Data - 5000 Naira - 15GB Data - 30 Days ( ₦5,000.00 )</option>
                <option value="eti-10000" data-amount="10000.00">9mobile Data - 10000 Naira - 40GB - 30 days ( ₦10,000.00 )</option>
                <option value="eti-15000" data-amount="15000.00">9mobile Data - 15000 Naira - 75GB - 30 Days ( ₦15,000.00 )</option>
                <option value="eti-27500" data-amount="27500.00">9mobile Data - 27,500 Naira - 30GB - 90 days ( ₦27,500.00 )</option>
                <option value="eti-55000" data-amount="55000.00">9mobile Data - 55,000 Naira - 60GB - 180 days ( ₦55,000.00 )</option>
                <option value ="eti-110000" data-amount="110000.00">9mobile Data - 110,000 Naira - 120GB - 365 days ( ₦110,000.00 )</option>
                </select>
                @endif

            </div>
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
                    </div>
                </div>
            </div>
            <input type="text" name="phone" id="phone-field"
            value="+2347037382623"
            class="form-control " placeholder="Phone Number"
            required>


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
            <input type="number" id="amount-field" name="amount"
            @if($param == "airtel")
                value="49.99"
            @elseif($param == "mtn")
                value="100.00"
            @elseif($param == "glo")
                value="100.00"
            @elseif($param == "9mobile")
                value="100.00"
            @endif            
            class="form-control " placeholder="Amount" required
            disabled style="background-color: #edf2f9;">


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
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
						Cable Subscription
					</h6>
					<!-- Title -->
					<h1 class="header-title">
						{{$label}}
					</h1>
				</div>
				<div class="col-3">
					<div class="text-right">
						@if($param == "gotv")
						<img src="{{asset("img/gotv.png")}}" width="60px">
						@elseif($param == "dstv")
						<img src="{{asset("img/dstv.png")}}" width="60px">
						@elseif($param == "startimes")
						<img src="{{asset("img/startimes.png")}}" width="60px">
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
						<label>Bouquet</label>
						@if($param == "gotv")
						<select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
							<option value="gotv-lite" data-amount="400.00">GOtv Lite N400 ( ₦400.00 )</option>
							<option value="gotv-value" data-amount="1250.00">GOtv value N1250 ( ₦1,250.00 )</option>
							<option value="gotv-plus" data-amount="1900.00">GOtv plus N1900 ( ₦1,900.00 )</option>
							<option value="gotv-max" data-amount="3200.00">GOtv Max N3200 ( ₦3,200.00 )</option>
							<option value="gotv-jolli" data-amount="2400.00">GOtv Jolli N2,400 ( ₦2,400.00 )</option>
							<option value="gotv-jinja" data-amount="1600.00">GOtv Jinja N1,600 ( ₦1,600.00 )</option>
						</select>
						@elseif($param == "dstv")
						<select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
							<option value="dstv1" data-amount="2000.00">DStv Access N2000 ( ₦2,000.00 )</option>
							<option value="dstv2" data-amount="4000.00">DStv Family N4000 ( ₦4,000.00 )</option>
							<option value="dstv3" data-amount="15800.00">DStv Premium N15800 ( ₦15,800.00 )</option>
							<option value="dstv4" data-amount="3640.00">DStv German only N3640 ( ₦3,640.00 )</option>
							<option value="dstv5" data-amount="6050.00">DStv French only N6050 ( ₦6,050.00 )</option>
							<option value="dstv6" data-amount="5050.00">DStv Asia only N5050 ( ₦5,050.00 )</option>
							<option value="dstv7" data-amount="10650.00">DStv Compact Plus N10650 ( ₦10,650.00 )</option>
							<option value="dstv9" data-amount="20780.00">DStv Premium-French N20780 ( ₦20,780.00 )</option>
							<option value="dstv10" data-amount="17630.00">DStv Premium-Asia N17630 ( ₦17,630.00 )</option>
							<option value="dstv13" data-amount="25580.00">DStv Premium - French - Asia N25580 ( ₦25,580.00 )</option>
							<option value="dstv18" data-amount="9400.00">DStv Family - Asia N9400 ( ₦9,400.00 )</option>
							<option value="dstv21" data-amount="7400.00">DStv Access - Asia N7400 ( ₦7,400.00 )</option>
							<option value="dstv22" data-amount="7850.00">DStv Access - French N7850 ( ₦7,850.00 )</option>
							<option value="dstv23" data-amount="4200.00">DStv Access - Dual View N4200 ( ₦4,200.00 )</option>
							<option value="dstv24" data-amount="4200.00">DStv Access - Extra View N4200 ( ₦4,200.00 )</option>
							<option value="dstv25" data-amount="4200.00">DStv Access - PVR Access N4200 ( ₦4,200.00 )</option>
							<option value="dstv26" data-amount="6200.00">DStv Family - Dual View N6200 ( ₦6,200.00 )</option>
							<option value="dstv27" data-amount="6200.00">DStv Family - Extra View N6200 ( ₦6,200.00 )</option>
							<option value="dstv28" data-amount="6200.00">DStv Family - PVR Access N6200 ( ₦6,200.00 )</option>
							<option value="dstv29" data-amount="9000.00">DStv Compact - Dual View N9000 ( ₦9,000.00 )</option>
							<option value="dstv30" data-amount="9000.00">DStv Compact Extra View N9000 ( ₦9,000.00 )</option>
							<option value="dstv31" data-amount="9000.00">DStv Compact - PVR Access N9000 ( ₦9,000.00 )</option>
							<option value="dstv32" data-amount="18000.00">DStv Premium Dual View N18000 ( ₦18,000.00 )</option>
							<option value="dstv33" data-amount="18000.00">DStv Premium - Extra View N18000 ( ₦18,000.00 )</option>
							<option value="dstv34" data-amount="18000.00">DStv Premium PVR Access N18000 ( ₦18,000.00 )</option>
							<option value="dstv36" data-amount="10360.00">DStv Family - French N10360 ( ₦10,360.00 )</option>
							<option value="dstv40" data-amount="16050.00">DStv Compact Plus - Asia N16050 ( ₦16,050.00 )</option>
							<option value="dstv43" data-amount="17010.00">DStv Compact Plus French N17010 ( ₦17,010.00 )</option>
							<option value="dstv44" data-amount="12850.00">DStv Compact Plus Dual View N12850 ( ₦12,850.00 )</option>
							<option value="dstv45" data-amount="12850.00">DStv Compact Plus - Extra View N12850 ( ₦12,850.00 )</option>
							<option value="dstv46" data-amount="12850.00">DStv Compact Plus - PVR Access N12850 ( ₦12,850.00 )</option>
							<option value="dstv47" data-amount="18250.00">DStv Compact Plus Asia PVR Access N18250 ( ₦18,250.00 )</option>
							<option value="dstv48" data-amount="18250.00">DStv Compact Plus Asia Dual View N18250 ( ₦18,250.00 )</option>
							<option value="dstv49" data-amount="19900.00">DStv Premium - Asia - Dual View N19900 ( ₦19,900.00 )</option>
							<option value="dstv50" data-amount="24400.00">DStv Premium - French - Dual View N24400 ( ₦24,400.00 )</option>
							<option value="dstv58" data-amount="19900.00">DStv Premium - Asia - PVR Access N19900 ( ₦19,900.00 )</option>
							<option value="dstv59" data-amount="24400.00">DStv Premium - French - PVR Access N24400 ( ₦24,400.00 )</option>
							<option value="dstv61" data-amount="19900.00">DStv Premium - Asia - Extra View N19900 ( ₦19,900.00 )</option>
							<option value="dstv62" data-amount="24400.00">DStv Premium - French - Extra View N24400 ( ₦24,400.00 )</option>
							<option value="dstv64" data-amount="26640.00">DStv Premium - French - Asia - Extra View N26640 ( ₦26,640.00 )</option>
							<option value="dstv65" data-amount="26640.00">DStv Premium - French - Asia - PVR Access N26640 ( ₦26,640.00 )</option>
							<option value="dstv66" data-amount="26640.00">DStv Premium - French - Asia - Dual View N26640 ( ₦26,640.00 )</option>
							<option value="dstv76" data-amount="7600.00">DStv Asia - Dual View N7600 ( ₦7,600.00 )</option>
							<option value="dstv77" data-amount="7600.00">DStv Asia - Extra View N7600 ( ₦7,600.00 )</option>
							<option value="dstv78" data-amount="7600.00">DStv  Asia - PVR Access N7600 ( ₦7,600.00 )</option>
							<option value="dstv79" data-amount="6800.00">DStv  Compact N6800 ( ₦6,800.00 )</option>
							<option value="dstv-yanga" data-amount="2500.00">DStv Yanga N2,500 ( ₦2,500.00 )</option>
							<option value="dstv-confam" data-amount="4500.00">Dstv Confam N4,500 ( ₦4,500.00 )</option>
						</select>
						@elseif($param == "startimes")
						<select name="variation" id="variation-select" onChange="updateAmount()" class="form-control ">
							<option value="nova" data-amount="900.00">Nova - 900 Naira - 1 Month ( ₦900.00 )</option>
							<option value="basic" data-amount="1300.00">Basic - 1,300 Naira - 1 Month ( ₦1,300.00 )</option>
							<option value="smart" data-amount="1900.00">Smart - 1,900 Naira - 1 Month ( ₦1,900.00 )</option>
							<option value="classic" data-amount="1900.00">Classic - 1,900 Naira - 1 Month- Promo ( ₦1,900.00 )</option>
							<option value="super" data-amount="3800.00">Super - 3,800 Naira - 1 Month ( ₦3,800.00 )</option>
							<option value="nova-weekly" data-amount="300.00">Nova - 300 Naira - 1 Week ( ₦300.00 )</option>
							<option value="basic-weekly" data-amount="450.00">Basic - 450 Naira - 1 Week ( ₦450.00 )</option>
							<option value="smart-weekly" data-amount="600.00">Smart - 600 Naira - 1 Week ( ₦600.00 )</option>
							<option value="classic-weekly" data-amount="900.00">Classic - 900 Naira - 1 Week - Promo  ( ₦900.00 )</option>
							<option value="super-weekly" data-amount="1300.00">Super - 1,300 Naira - 1 Week ( ₦1,300.00 )</option>
							<option value="nova-daily" data-amount="90.00">Nova - 90 Naira - 1 Day ( ₦90.00 )</option>
							<option value="basic-daily" data-amount="120.00">Basic - 120 Naira - 1 Day ( ₦120.00 )</option>
							<option value="smart-daily" data-amount="180.00">Smart - 180 Naira - 1 Day ( ₦180.00 )</option>
							<option value="classic-daily" data-amount="240.00">Classic - 240 Naira - 1 Day - Promo  ( ₦240.00 )</option>
							<option value="super-daily" data-amount="360.00">Super - 360 Naira - 1 Day ( ₦360.00 )</option>
							{{-- <option value="ewallet" data-amount="0.00">ewallet Amount ( ₦0.00 )</option> --}}
						</select>

						@endif

					</div>
					<div class="col-12 col-md-6 mb-3">
						<div style="display: flex; align-items: baseline">
							<label style="margin-right: 4px">Smartcard</label>
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
					<input type="text" id="smartcard-field" name="smartcard_number" value="" class="form-control " placeholder="Smartcard Number" required>


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
					<input type="text" name="phone" value="+2347037382623" class="form-control " placeholder="Phone Number" required>


				</div>
				<div class="col-12 col-md-6 mb-3">
					<label>Amount</label>
					<input type="number" id="amount-field" name="amount" 
					@if($param == "gotv")
					value="400.00" 
					@elseif($param == "dstv")
					value="2000.00" 
					@elseif($param == "startimes")
					value="900.00" 
					@endif
					class="form-control " placeholder="Amount" required disabled style="background-color: #edf2f9;">


				</div>
			</div>
			<div class="form-row">
				<div class="col-12 col-md-6 mb-3">
					<label>Email</label>
					<input type="text" name="email" value="emalinerosemiller@gmail.com" class="form-control " placeholder="Email">


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
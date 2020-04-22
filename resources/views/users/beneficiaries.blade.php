@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - Account Settings')


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
        <div class="col-12 col-lg-10 col-xl-10">

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
                        Settings
                    </h1>

                </div>
            </div> <!-- / .row -->
            <div class="row align-items-center">
                <div class="col">
                    <!-- Nav -->
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="/settings/profile" class="nav-link">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/password" class="nav-link">
                                Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/settings/beneficiaries" class="nav-link active">
                                Saved Beneficiaries
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card" data-toggle="lists"
    data-options='{"valueNames": ["name", "service", "billers_code", "created_at"]}'>
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <!-- Search -->
                <form class="row align-items-center">
                    <div class="col-auto pr-0">
                        <span class="fe fe-search text-muted"></span>
                    </div>
                    <div class="col">
                        <input type="search" name="search" value=""
                        class="form-control form-control-flush search"
                        placeholder="Search Beneficiaries">
                    </div>
                </form>
            </div>
        </div> <!-- / .row -->
    </div>
    <div class="table-responsive">
        <table class="table {{-- table-sm  --}}table-nowrap card-table">
            <thead>
                <tr>
                    <th>
                        <a href="#" class="text-muted sort" data-sort="name">
                            Name
                        </a>
                    </th>
                    <th>
                        <a href="#" class="text-muted sort" data-sort="service">
                            Service
                        </a>
                    </th>
                    <th>
                        <a href="#" class="text-muted sort" data-sort="billers_code">
                            Billers Code
                        </a>
                    </th>
                    <th>
                        <a href="#" class="text-muted sort" data-sort="created_at">
                            Created Date
                        </a>
                    </th>
                    <th>
                        Delete
                    </th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($beneficiaries as $beneficiary)
                <tr>
                    <td class="name">
                      {{$beneficiary->beneficiary_name}}
                  </td>
                  <td class="service">
                    {{$beneficiary->service}}
                </td>

                <td class="billers-code">
                    {{$beneficiary->billers_code == null ? 'Nil' : $beneficiary->billers_code}}
                </td>
                <td class="date">
                    {{$beneficiary->created_at}}
                </td>
                <td class="date">
                    <a href="{{route("user.deleteBeneficiary", [$beneficiary->id])}}" onclick="return confirm('Are you sure you want to delete this beneficiary?');"><button class="btn btn-sm btn-danger">Delete</button></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if(count($beneficiaries) == 0)
<div class="text-70 text-center">
    <li class='fa fa-frown'></li>
    <br>
    <p class="text-14">No Record found!</p>
</div>
@endif
</div>

<nav aria-label="Page navigation example">

</nav>

</div>
</div> <!-- / .row -->
</div>
</div>
@endsection
@extends('users.layouts.app')

@section('content')
@section('title', 'NaijaWayServices  - Transfer History')

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
    <div class="header md-5">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Title -->
                    <h1 class="header-title">
                        Wallet Transfer History
                    </h1>
                </div>
            </div> <!-- / .row -->
            <div class="row align-items-center">
                <div class="col">

                    <!-- Nav -->
                    <ul class="nav nav-tabs nav-overflow header-tabs">
                        <li class="nav-item">
                            <a href="/transfer-history" class="nav-link">
                                All <span class="badge badge-pill badge-soft-secondary">{{number_format(\App\Http\Controllers\WalletController::countAllTransfers(), 0)}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/transfer-history?filter_by=Sent" class="nav-link @if($filterBy == "Sent"){{"active"}}@endif">
                                Sent <span class="badge badge-pill badge-soft-secondary">{{number_format(\App\Http\Controllers\WalletController::countOutwardTransfers(), 0)}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/transfer-history?filter_by=Received" class="nav-link @if($filterBy == "Received"){{"active"}}@endif">
                                Received <span class="badge badge-pill badge-soft-secondary">{{number_format(\App\Http\Controllers\WalletController::countInwardTransfers(), 0)}}</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="card" data-toggle="lists" data-options='{"valueNames": ["ref", "amount", "service", "payment-method", "orders-status", "date"]}'>
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">

                    <!-- Search -->
                    <form class="row align-items-center">
                        <div class="col-auto pr-0">
                            <span class="fe fe-search text-muted"></span>
                        </div>
                        <div class="col">
                            <input type="search" name="search" value="" class="form-control form-control-flush search"
                            placeholder="Search Transactions">
                        </div>
                    </form>

                </div>

            </div> <!-- / .row -->
        </div>
        <div class="table-responsive">
            <table class="table {{-- table-sm --}} table-nowrap card-table">
                <thead>
                    <tr>

                        <th>
                            <a href="/wallet-topups?sort_by=reference.desc" class="text-muted sort" data-sort="ref">
                                Ref.
                            </a>
                        </th>
                        <th>
                            <a href="/wallet-topups?sort_by=amount.desc" class="text-muted sort" data-sort="amount">
                                Amount
                            </a>
                        </th>
                        <th>
                            <a href="/wallet-topups?sort_by=payment_method.desc" class="text-muted sort" data-sort="payment-method">
                                @if($filterBy == "Sent")
                                Receiver
                                @else
                                Sender
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="/wallet-topups?sort_by=status.desc" class="text-muted sort" data-sort="orders-status">
                                Status
                            </a>
                        </th>
                        <th>
                            <a href="/wallet-topups?sort_by=created_at.desc" class="text-muted sort" data-sort="date">
                                Date
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($transfers as $transfer)
                    <tr>
                        <td class="ref">
                            {{$transfer->ref_number}}
                        </td>
                        <td class="amount">
                            &#8358;{{number_format($transfer->amount, 2)}}
                        </td>
                        <td class="payment-method">
                            @if($transfer->sender_id == Auth::user()->id)
                            {{$transfer->receiver}}
                            @else
                            {{$transfer->sender}}
                            @endif
                        </td>
                        <td class="orders-status">
                            <div class="badge badge-soft-success">
                                @if($transfer->sender_id == Auth::user()->id)
                                &nbsp;{{"Sent"}}&nbsp;
                                @else
                                {{"Received"}}
                                @endif
                            </div>
                        </td>
                        <td class="date">
                            {{$transfer->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(count($transfers) == 0)
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
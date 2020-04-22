<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('users.layouts.header')
<body>
	<!-- Sidebar section -->
	<nav class="navbar navbar-vertical fixed-left navbar-expand-md side-nav-bg" id="sidebar">
		<div class="container-fluid">

			<!-- Toggler -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse"
			aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa fa-bars"></i>
		</button>

		<!-- Brand -->
		<a class="navbar-brand" href="https://naijawayservices.ng">
			<img src="{{asset("img/naijawayservices.png")}}" class="navbar-brand-img
			mx-auto" alt="NaijaWayServices">
		</a>

		@include('users.layouts.topmenu')

		<!-- Collapse -->
		@include('users.layouts.sidebar')
		<!-- / .navbar-collapse -->

	</div>
</nav>


<nav class="navbar navbar-vertical navbar-vertical-sm fixed-left navbar-expand-md " id="sidebarSmall" style="display: none !important;">
</nav>


<nav class="navbar navbar-expand-lg " id="topnav" style="display: none !important;">
</nav>
<!-- Sidebar section end -->

<!-- MAIN CONTENT -->

@yield('content')
<!-- Footer section -->
<div class="floating-wpp"></div>
<footer>

</footer>

@include('users.layouts.js')
<!--End of WhatsApp Chat Script-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
</body>
</html>

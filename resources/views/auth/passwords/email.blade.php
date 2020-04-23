
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <title>NaijaWayServices  - Reset Password</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="NaijaWayServices  - Home">

  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="NaijaWayServices  - Home">
  <meta itemprop="description" content="NaijaWayServices  - Home">
  <meta itemprop="image" content="{{asset("img/social_card_img.jpg")}}">

  <!-- Twitter Card data -->
  <meta name="twitter:card" content="{{asset("img/social_card_img.jpg")}}">
  <meta name="twitter:title" content="NaijaWayServices  - Home">
  <meta name="twitter:description" content="NaijaWayServices  - Home">
  <meta name="twitter:image:src" content="{{asset("img/social_card_img.jpg")}}">

  <!-- Open Graph data -->
  <meta property="og:locale" content="en_US">
  <meta property="og:title" content="NaijaWayServices  - Home">
  <meta property="og:image" content="{{asset("img/social_card_img.jpg")}}">
  <meta property="og:description" content="NaijaWayServices  - Home" />
  <meta property="og:site_name" content="NaijaWayServices"/>
  <meta property="og:url" content="https://naijawayservices.ng">
  <meta property="og:type" content="website">


  <link rel="stylesheet" href="{{asset("css/theme.min.css")}}" id="stylesheetLight">
  <link rel="stylesheet" href="{{asset("css/responsive.css")}}">
  <link rel="stylesheet" href="{{asset("css/theme-dark.min.css")}}" id="stylesheetDark">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
  integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous"/>

  <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900&display=swap" rel="stylesheet">


  <link rel="apple-touch-icon" sizes="57x57" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{asset("img/favicon.png")}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset("img/favicon.png")}}">

  <link rel="icon" type="image/png" sizes="192x192"  href="{{asset("img/favicon.png")}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset("img/favicon.png")}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{asset("img/favicon.png")}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset("img/favicon.png")}}">

  <style>body {
    display: none;
  }</style>


</head>
<body  class="d-flex align-items-center bg-auth border-top border-top-2 border-warning">

<!-- CONTENT
 ================================================== -->
 <div class="container">
  <div class="row align-items-center">
    <div class="col-12 col-md-6 offset-xl-2 offset-md-1 order-md-2 mb-5 mb-md-0">

      <!-- Image -->
      <div class="text-center">
        <img src="{{asset("img/happiness.svg")}}" alt="..." class="img-fluid">
      </div>

    </div>
    <div class="col-12 col-md-5 col-xl-4 order-md-1 my-5">

      <!-- Heading -->
      <h1 class="display-4 text-center mb-3">
        Welcome Back!
      </h1>

      <!-- Subheading -->
      <p class="text-muted text-center mb-5">
        Fill your email Below
      </p>
      @if(Session::has("displayError"))
      <div class="alert alert-success" role="alert">
        We have e-mailed your password reset link!
      </div>
      @endif
      <form method="POST" action="{{route("user.resetPassword")}}">
        @csrf
        <!-- Email address -->
        <div class="form-group">
          <label>
            Email Address
          </label>
          <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old("email")}}" placeholder="name@address.com" required="required">

          @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-lg btn-block btn-primary mb-3">
          Send Password Reset Link
        </button>

        <!-- Link -->
        <div class="text-center">
          <small class="text-muted text-center">
            <a href="/login">Back to login</a>.
          </small>
        </div>

      </form>

      <div class="floating-wpp"></div>

    </div>
  </div> <!-- / .row -->
</div> <!-- / .container -->


<script src="{{asset("libs/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("libs/list.js/dist/list.min.js")}}"></script>
<script src="{{asset("landing-assets/js/bootstrap-select.min.js")}}"></script>
<script src="{{asset("js/floating-wpp.min.js")}}"></script>

<!-- JS -->
<script src="{{asset("https://ceepay.ng/js/theme.min.js")}}"></script>


<!--Start of WhatsApp Chat Script-->
<script type="text/javascript">

  $(function () {
    $('.floating-wpp').floatingWhatsApp({
      phone: '2348166861397',
      popupMessage: 'Welcome to NaijaWayServices, if you need help simply reply to this message, we are online and ready to help.',
      showPopup: true,
      position: 'right',
      autoOpen: false,
            //autoOpenTimer: 4000,
            message: '',
            //headerColor: 'orange',
            headerTitle: 'WhatsApp Message',
          });
  });

</script>
<!--End of WhatsApp Chat Script-->

</body>
</html>

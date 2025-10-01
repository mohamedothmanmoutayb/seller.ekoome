<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('public/assets/images/logos/favicon.png')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{ asset('public/assets/css/styles.css')}}" />

  <title>Ekoome Solution - Best platform Ecommerce</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{ asset('public/assets/images/logos/favicon.png')}}" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100 my-5 my-xl-0">
          <div class="col-md-9 d-flex flex-column justify-content-center">
            <div class="card mb-0 bg-body auth-login m-auto w-100">
              <div class="row gx-0">
                <!-- ------------------------------------------------- -->
                <!-- Part 1 -->
                <!-- ------------------------------------------------- -->
                <div class="col-xl-6 border-end">
                  <div class="row justify-content-center py-4">
                    <div class="col-lg-11">
                      <div class="card-body">
                        <a href="{{ route('home')}}" class="text-nowrap logo-img d-block mb-4 w-100">
                          <img src="{{ asset('public/logo.png')}}" class="dark-logo" alt="Logo-Dark" width="200"/>
                        </a>
                        <h4 class="lh-base mb-2" style="font-size: 23px;">Your Ecommerce, Fully Under Control</h4>
                        <p class="mb-4">Sign in to access your all-in-one platform for COD & dropshipping order management</p>                        <div class="row">
                          <!-- <div class="col-6 mb-2 mb-sm-0">
                            <a class="btn btn-white shadow-sm text-dark link-primary border fw-semibold d-flex align-items-center justify-content-center rounded-1 py-6" href="javascript:void(0)" role="button">
                              <img src="{{ asset('public/assets/images/svgs/facebook-icon.svg')}}" alt="matdash-img" class="img-fluid me-2" width="18" height="18">
                              <span class="d-none d-xxl-inline-flex"> Sign in with </span>&nbsp; Facebook
                            </a>
                          </div>
                          <div class="col-6">
                            <a class="btn btn-white shadow-sm text-dark link-primary border fw-semibold d-flex align-items-center justify-content-center rounded-1 py-6" href="javascript:void(0)" role="button">
                              <img src="{{ asset('public/assets/images/svgs/google-icon.svg')}}" alt="matdash-img" class="img-fluid me-2" width="18" height="18">
                              <span class="d-none d-xxl-inline-flex"> Sign in with </span>&nbsp; Google
                            </a>

                          </div> -->
                        </div>
                        <!-- <div class="position-relative text-center my-4">
                          <p class="mb-0 fs-12 px-3 d-inline-block bg-body z-index-5 position-relative">Or sign in with
                            email
                          </p>
                          <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div> -->

                          @php if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_pass']))
                          {
                            $login_email = $_COOKIE['login_email'];
                            $login_pass  = $_COOKIE['login_pass'];
                            $is_remember = "checked='checked'";
                          }
                          else{
                            $login_email ='';
                            $login_pass = '';
                            $is_remember = "";
                          }
                          @endphp
                        <form id="loginform" method="POST" action="{{ route('login') }}">
                          @csrf
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter your email" aria-describedby="emailHelp">
                          </div>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                              <label for="exampleInputPassword1" class="form-label">Password</label>
                              <a class="text-primary link-dark fs-2" href="../horizontal/authentication-forgot-password2.html">Forgot
                                Password ?</a>
                            </div>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter your password">
                          </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                              <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                              <label class="form-check-label text-dark" for="flexCheckChecked">
                                Keep me logged in
                              </label>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-dark w-100 py-8 mb-4 rounded-1">Sign In</button>
                          <div class="d-flex align-items-center">
                            <p class="fs-12 mb-0 fw-medium">Don’t have an account yet?</p>
                            <a class="text-primary fw-bolder ms-2" href="../horizontal/authentication-register2.html">Sign Up Now</a>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- ------------------------------------------------- -->
                <!-- Part 2 -->
                <!-- ------------------------------------------------- -->
                 <div class="col-xl-6 d-none d-xl-block">
                  <div class="row justify-content-center align-items-start h-100 " style="margin-top:   80px;">
                    <div class="col-lg-9">
                      <div id="auth-login" class="carousel slide auth-carousel mt-3 pt-4" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="2" aria-label="Slide 3"></button>
                           <button type="button" data-bs-target="#auth-login" data-bs-slide-to="3" aria-label="Slide 4"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="4" aria-label="Slide 5"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="5" aria-label="Slide 6"></button>
                           <button type="button" data-bs-target="#auth-login" data-bs-slide-to="6" aria-label="Slide 7"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="7" aria-label="Slide 8"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/order.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">📦 Order Management</h4>
                              <p class="fs-12 mb-0">Handle Cash on Delivery & Dropshipping in any country.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/call.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">☎️ Call Center Management</h4>
                              <p class="fs-12 mb-0"> Manage sales agents, track performance, and boost conversions.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/user.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">👥 Team Management</h4>
                              <p class="fs-12 mb-0">Assign roles, monitor productivity & streamline workflows.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                            <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/lastmile.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">🚚 Shipping Integrations</h4>
                              <p class="fs-12 mb-0">Connect with top logistics companies seamlessly.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                            <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/store.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">🛒 Store Integrations</h4>
                              <p class="fs-12 mb-0">Sync with your preferred store platforms instantly.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                            <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/bill.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">💰 Cash Flow Control</h4>
                              <p class="fs-12 mb-0">Track revenue, COD payments, returns, and payouts in real-time.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                            <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/warehouse.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">📊 Inventory & Stock Management</h4>
                              <p class="fs-12 mb-0">Stay in control of your products and avoid overselling.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                           <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="{{ asset('public/assets/images/backgrounds/aiageent.png')}}" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">🤖 WhatsApp AI Agent & Bots</h4>
                              <p class="fs-12 mb-0">Automate chats, confirm orders, answer FAQs, and increase efficiency.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="{{ asset('public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('public/assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{ asset('public/assets/js/theme/app.horizontal.init.js')}}"></script>
  <script src="{{ asset('public/assets/js/theme/theme.js')}}"></script>
  <script src="{{ asset('public/assets/js/theme/app.min.js')}}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
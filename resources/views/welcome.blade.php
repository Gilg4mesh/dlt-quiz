<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Shifu">

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="/assets/dist/img/icon.png">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <style>
        .pic1 {
            background-image: url('img/bg-showcase-1-min.jpg'); 
        }
        .pic2 {
            background-image: url('img/bg-showcase-2-min.jpg'); 
        }
        .pic3 {
            background-image: url('img/bg-showcase-3-min.jpg'); 
        }
        
        /* For width 400px and larger: */
        @media only screen and (min-width: 415px) {
            .pic1 { 
                background-image: url('img/bg-showcase-1.jpg'); 
            }
            .pic2 { 
                background-image: url('img/bg-showcase-2.jpg'); 
            }
            .pic3 { 
                background-image: url('img/bg-showcase-3.jpg'); 
            }
        }
    </style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        
        <a class="navbar-brand" href="/"><img src="/assets/dist/img/icon.png" height="38" width="38"></img> {{ config('app.name') }}</a>
        @if (Auth::guest())
            <a href="{{ url('auth/facebook') }}" class="btn btn-primary">
                <strong>FB 登入</strong>
            </a> 
        @else
            <a class="btn btn-primary" href="{{ url('/logout') }}">登出</a>
        @endif
      </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">從今天開始累積你的區塊鏈知識</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <a href="{{ url('/test') }}" class="btn btn-block btn-lg btn-primary">Start Quiz</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-screen-desktop m-auto text-primary"></i>
              </div>
              <h3>隨時挑戰</h3>
              <p class="lead mb-0">隨時能挑戰自己的觀念</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-layers m-auto text-primary"></i>
              </div>
              <h3>橫跨領域</h3>
              <p class="lead mb-0">觀念、技術、金融一應俱全</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-check m-auto text-primary"></i>
              </div>
              <h3>即時批改</h3>
              <p class="lead mb-0">作答完即附上結果與詳解</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Image Showcases -->
    <section class="showcase">
      <div class="container-fluid p-0">
        <div class="row no-gutters">

          <div class="col-lg-6 order-lg-2 text-white showcase-img pic1">
            <p style="text-align: center;margin-top:30rem; ">Images requires attribution to <a href="https://descryptive.com">Descryptive</a> is licensed under <a href="https://creativecommons.org/licenses/by/2.0/">CC BY 2.0</a></p>
          </div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>共識機制</h2>
            <p class="lead mb-0">辨別各種區塊鏈中，如何透過不同的共識機制，促使全體使用者一起維護帳本。</p>
          </div>
        </div>
        <div class="row no-gutters">
          <div class="col-lg-6 text-white showcase-img pic2">
            <p style="text-align: center;margin-top:30rem; ">Images requires attribution to <a href="https://descryptive.com">Descryptive</a> is licensed under <a href="https://creativecommons.org/licenses/by/2.0/">CC BY 2.0</a></p>
          </div>
          <div class="col-lg-6 my-auto showcase-text">
            <h2>加密機制</h2>
            <p class="lead mb-0">了解如何透過雜湊函數(Hash Function)，確保區塊鏈的安全性(例如:無法竄改、非對稱加密)。</p>
          </div>
        </div>
        <div class="row no-gutters">
          <div class="col-lg-6 order-lg-2 text-white showcase-img pic3">
            <p style="text-align: center;margin-top:30rem; ">Images requires attribution to <a href="https://descryptive.com">Descryptive</a> is licensed under <a href="https://creativecommons.org/licenses/by/2.0/">CC BY 2.0</a></p>
          </div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>去中心化</h2>
            <p class="lead mb-0">探究如何讓每一個使用者都是平等的，擁有相同權限，擺脫中央金融機構，並且沒有人有優勢可以作弊。</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
      <div class="container">
        <h2 class="mb-5">貢獻者</h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/shifu.jpg" alt="">
              <h5>Shifu Hung</h5>
              <p class="font-weight-light mb-0">一個肥宅</br>有興趣改善網站或協助增加題目可以去密底下的 FB 粉專</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/tsehou.jpg" alt="">
              <h5>Tse Hou</h5>
              <p class="font-weight-light mb-0"></br>區塊鏈專欄作家、講師、礦場相關服務等<a href="mailto:wqqmatt@yahoo.com.tw">wqqmatt@yahoo.com.tw</a></p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="testimonial-item mx-auto mb-5 mb-lg-0">
              <img class="img-fluid rounded-circle mb-3" src="img/testimonials-1.jpg" alt="">
              <h5>Unknown</h5>
              <p class="font-weight-light mb-0">Unknown</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row" style="overflow:auto">
          <div class="col-xl-9 mx-auto">
            <h2 class="mb-4">您可以贊助ETH讓平台更長久:</h2>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <h2 class="mb-4">0x6DAF4cf7943101F4471dD5B84A8F1209C8cA7946</h2>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <p class="text-muted small mb-4 mb-lg-0">&copy; BlockFayjai 2018. All Rights Reserved.</p>
          </div>
          <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item mr-3">
                <a href="/privacy">
                  <i class="fa fa-shield fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="https://www.facebook.com/BlockFayjai/" target="_blank">
                  <i class="fa fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>

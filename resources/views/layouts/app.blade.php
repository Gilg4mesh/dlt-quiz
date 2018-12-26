<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="wb:webmaster" content="04d25093ca20dc42" />
    <title>{{ config('app.name') }}</title>

    <!-- Loading Bootstrap -->
    <link href="/assets/dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Loading Flat UI -->
    <link href="/assets/dist/css/flat-ui.css" rel="stylesheet" />

    <link rel="shortcut icon" href="/assets/dist/img/icon.png">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

    <!--導入代碼高亮：highlight.css-->
    <link href="/assets/dist/styles/solarized-light.css" rel="stylesheet" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="/assets/dist/js/vendor/html5shiv.js'"></script>
    <script src="/assets/dist/js/vendor/respond.min.js"></script>
    <![endif]-->
    <link href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        body {font-family: Arial;}
        
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }
        
        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }
        
        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }
        
        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
</head>
<body id="app-layout" style=" position:absolute;margin: 0; padding: 0;width:100%; height:100% ;">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/test') }}">測驗</a></li>
                    <li><a href="{{ url('/history') }}">紀錄</a></li>
                    <li><a href="{{ url('/textbook') }}">資源</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>登出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @include('flash::message')
    @yield('content')

    <!-- JavaScripts -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/assets/dist/js/vendor/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/dist/js/flat-ui.min.js"></script>

    <script src="/assets/dist/js/application.js"></script>
    <script src="/assets/dist/js/highlight.pack.js"></script>

    <script>
        $('button:not([type="submit"])').on('click', function (e) {
            var $this = $(this);

            if (!!$this.attr('data-radiocheck-check')) {
                var el = $this.attr('data-radiocheck-check');
                $(el).radiocheck('check');
            } else if (!!$this.attr('data-radiocheck-uncheck')) {
                var el = $this.attr('data-radiocheck-uncheck');
                $(el).radiocheck('uncheck');
            } else if (!!$this.attr('data-radiocheck-toggle')) {
                var el = $this.attr('data-radiocheck-toggle');
                $(el).radiocheck('toggle');
            } else if (!!$this.attr('data-radiocheck-indeterminate')) {
                var el = $this.attr('data-radiocheck-indeterminate');
                $(el).radiocheck('indeterminate');
            } else if (!!$this.attr('data-radiocheck-determinate')) {
                var el = $this.attr('data-radiocheck-determinate');
                $(el).radiocheck('determinate');
            } else if (!!$this.attr('data-radiocheck-disable')) {
                var el = $this.attr('data-radiocheck-disable');
                $(el).radiocheck('disable');
            } else if (!!$this.attr('data-radiocheck-enable')) {
                var el = $this.attr('data-radiocheck-enable');
                $(el).radiocheck('enable');
            } else if (!!$this.attr('data-radiocheck-destroy')) {
                var el = $this.attr('data-radiocheck-destroy');
                $(el).radiocheck('destroy');
            } else if (!!$this.attr('data-radiocheck-init')) {
                var el = $this.attr('data-radiocheck-init');
                $(el).radiocheck();
            }

            e.preventDefault();
        });

    </script>
    <script type="text/javascript">
        //modal框樣式
        $('#flash-overlay-modal').modal();
        //或者普通樣式

        $('div.alert').not('.alert-important').delay(3000).slideUp(300);
    </script>
    <script >hljs.initHighlightingOnLoad();</script>
    @yield('footer')
</body>
</html>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="blank, starter">

    <title>Truman</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
    <link href="/assets/css/core.min.css" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="/assets/css/style.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
    <link rel="icon" href="/assets/img/favicon.png">
  </head>

  <body class="sidebar-folded">

    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
      </div>
    </div>


    <!-- Sidebar -->
    <aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg">
      <header class="sidebar-header d-flex justify-content-center">
        <strong>TRUMAN</strong>
      </header>

      <nav class="sidebar-navigation">
        <ul class="menu">

          <li class="menu-category">Category 1</li>

          <li class="menu-item active">
            <a class="menu-link" href="../dashboard/general.html">
              <span class="icon fa fa-home"></span>
              <span class="title">Dashboard</span>
            </a>
          </li>

          <li class="menu-item">
            <a class="menu-link" href="#">
              <span class="icon fa fa-user"></span>
              <span class="title">Users</span>
              <span class="arrow"></span>
            </a>

            <ul class="menu-submenu">
              <li class="menu-item">
                <a class="menu-link" href="#">
                  <span class="dot"></span>
                  <span class="title">Moderators</span>
                </a>
              </li>

              <li class="menu-item">
                <a class="menu-link" href="#">
                  <span class="dot"></span>
                  <span class="title">Customers</span>
                </a>
              </li>
            </ul>
          </li>



          <li class="menu-category">Category 2</li>


          <li class="menu-item">
            <a class="menu-link" href="#">
              <span class="icon ti-layout"></span>
              <span class="title">Layout</span>
              <span class="arrow"></span>
            </a>

            <ul class="menu-submenu">
              <li class="menu-item">
                <a class="menu-link" href="#">
                  <span class="dot"></span>
                  <span class="title">Sidebar</span>
                </a>
              </li>

              <li class="menu-item">
                <a class="menu-link" href="#">
                  <span class="dot"></span>
                  <span class="title">Header</span>
                </a>
              </li>

              <li class="menu-item">
                <a class="menu-link" href="#">
                  <span class="dot"></span>
                  <span class="title">Footer</span>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>

    </aside>
    <!-- END Sidebar -->


    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
      </div>

      <div class="topbar-right">
        <ul class="topbar-btns">

          <!-- Notifications -->
          <li class="dropdown d-none d-md-block">
            <span class="topbar-btn has-new" data-toggle="dropdown"><i class="ti-bell"></i></span>
            <div class="dropdown-menu dropdown-menu-right">

              <div class="media-list media-list-hover media-list-divided media-list-xs">
                <a class="media media-new" href="#">
                  <span class="avatar bg-success"><i class="ti-user"></i></span>
                  <div class="media-body">
                    <p>New user registered</p>
                    <time datetime="2018-07-14 20:00">Just now</time>
                  </div>
                </a>

                <a class="media" href="#">
                  <span class="avatar bg-info"><i class="ti-shopping-cart"></i></span>
                  <div class="media-body">
                    <p>New order received</p>
                    <time datetime="2018-07-14 20:00">2 min ago</time>
                  </div>
                </a>

                <a class="media" href="#">
                  <span class="avatar bg-warning"><i class="ti-face-sad"></i></span>
                  <div class="media-body">
                    <p>Refund request from <b>Ashlyn Culotta</b></p>
                    <time datetime="2018-07-14 20:00">24 min ago</time>
                  </div>
                </a>

                <a class="media" href="#">
                  <span class="avatar bg-primary"><i class="ti-money"></i></span>
                  <div class="media-body">
                    <p>New payment has made through PayPal</p>
                    <time datetime="2018-07-14 20:00">53 min ago</time>
                  </div>
                </a>
              </div>

              <div class="dropdown-footer">
                <div class="left">
                  <a href="#">Read all notifications</a>
                </div>

                <div class="right">
                  <a href="#" data-provide="tooltip" title="Mark all as read"><i class="fa fa-circle-o"></i></a>
                  <a href="#" data-provide="tooltip" title="Update"><i class="fa fa-repeat"></i></a>
                  <a href="#" data-provide="tooltip" title="Settings"><i class="fa fa-gear"></i></a>
                </div>
              </div>

            </div>
          </li>
          <!-- END Notifications -->

        </ul>

        <div class="topbar-divider"></div>

        <a class="btn btn-xs btn-round btn-success mr-2" href="https://themeforest.net/item/theadmin-responsive-bootstrap-4-admin-dashboard-webapp-template/20475359?license=regular&amp;open_purchase_for_item_id=20475359&amp;purchasable=source&amp;ref=thethemeio">Buy TheAdmin</a>

      </div>
    </header>
    <!-- END Topbar -->


    <!-- Main container -->
    <main class="main-container">
      <div class="main-content">
        @yield('content')
      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-center">
            <p class="text-center text-md-left">Copyright © {{ date('Y') }} | {{ config('app.name') }}. Todos los derechos reservados.</p>
          </div>

        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->



    <!-- Global quickview -->
    <div id="qv-global" class="quickview" data-url="assets/data/quickview-global.html">
      <div class="spinner-linear">
        <div class="line"></div>
      </div>
    </div>
    <!-- END Global quickview -->



    <!-- Scripts -->
    <script src="/assets/js/core.min.js"></script>
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/script.min.js"></script>

  </body>
</html>

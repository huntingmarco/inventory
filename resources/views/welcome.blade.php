<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{ asset('backend/img/logo/logo.png') }}" rel="icon">
  <title>Hotel and Inventory</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}">

  <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
<div id="app">

  <div id="wrapper">


    <!-- Sidebar -->
  <nav id="sidebar" v-show="$route.path === '/' || $route.path == '/register' || $route.path == '/forget' ? false : true "  style="display:  none;">

    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar" >
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="background-color: #272d36;"href="index.html">
        <div class="sidebar-brand-icon">
          <img src="{{ asset('backend/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <router-link class="nav-link" to="/home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></router-link>
      </li>

      <li class="nav-item active">
        <router-link class="nav-link" to="/pos">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>POS</span></router-link>
      </li>
      <hr>
      <!-- <hr class="sidebar-divider" style="margin:5px;"> -->

      <div class="sidebar-heading" style="background-color:#333e52;color:#999;padding:20px;">
        Admin
      </div>
       <!-- Hotel Management -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap1"
          aria-expanded="true" aria-controls="collapseBootstrap1">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Hotel Management</span>
        </a>
        <div id="collapseBootstrap1" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="">Billing</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="">Check-In</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="">Check-Out</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="">Reservation</router-link>
          </div>
        </div>
      </li>
       <!-- Cashiering -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2"
          aria-expanded="true" aria-controls="collapseBootstrap2">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Cashiering</span>
        </a>
        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/pos">Point of Sale</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/sales">Sales</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/searchsales">Search Sales</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="">Billing</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/expense">Expenses</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/customer">Customers</router-link>
            <hr>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/cashdrawer">Cash Drawer</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/endofday">End-of-Day</router-link>
          </div>
        </div>
      </li>
      <!-- Inventory -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap3"
          aria-expanded="true" aria-controls="collapseBootstrap3">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Inventory</span>
        </a>
        <div id="collapseBootstrap3" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/product">Products</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/category">Product Category</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/stock">Stocks</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/supplier">Suppliers</router-link>
          </div>
        </div>
      </li>
    
      <!-- <hr class="sidebar-divider"> -->

      <!-- Payroll -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap4"
          aria-expanded="true" aria-controls="collapseBootstrap4">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Payroll</span>
        </a>
        <div id="collapseBootstrap4" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/pay">Create Payroll</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/payroll">Payroll List</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/add-payroll">Add Payroll</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/employee">Employees</router-link>
          </div>
        </div>
      </li>
    
      <!-- <hr class="sidebar-divider">       -->

      <!-- Accounting -->
      <div class="sidebar-heading" style="background-color:#333e52;color:#999;padding:20px;">
        Accounting
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>Reports</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Example Pages</h6> -->
            <a class="collapse-item text-white" style="margin-left:40px;" href="login.html">Trial Balance</a>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/balance">Balance Sheet</router-link>
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/income">Income Statement</router-link>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage2" aria-expanded="true"
          aria-controls="collapsePage2">
          <i class="fas fa-fw fa-columns"></i>
          <span>Accounts</span>
        </a>
        <div id="collapsePage2" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar" style="background-color: #4a5872; margin:0px 0px 0px 0px;">
          <div class="py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">Example Pages</h6> -->
            <router-link class="collapse-item text-white" style="margin-left:40px;" to="/journal">Journal Entry</router-link>
            <a class="collapse-item text-white" style="margin-left:40px;" href="login.html">General Ledger</a>
            <a class="collapse-item text-white" style="margin-left:40px;" href="register.html">GL Accounts</a>
          </div>
        </div>
      </li>
      

      <hr class="sidebar-divider">

      <li class="nav-item active">
        <router-link class="nav-link" to="/closetrn">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Close Transaction</span></router-link>
      </li>

      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    </nav>



    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">


        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" id="topbar" v-show="$route.path === '/' || $route.path == '/register' || $route.path == '/forget' ? false : true " style="display: none;">


          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

           
            <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

            <li class="nav-item dropdown no-arrow">
              
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <!-- <img class="img-profile rounded-circle" src="{{ asset('backend/img/boy.png') }}" style="max-width: 60px"> -->
                <router-link to="/logout" class="ml-2 d-none d-lg-inline text-gray-700 small" >Logout</router-link>
              </a>

              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="login.html">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          
            <router-view></router-view>

        </div>
        <!---Container Fluid-->
      </div>
  
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; 2021 - developed by
              <b><a href="https://www.capturebay.com/" target="_blank">Capture Bay</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->


    </div>

  </div>

</div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="{{ asset('js/app.js')}}"></script>
  <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script type="text/javascript">
    let token= localStorage.getItem('token')
    if (token) {
      $("#sidebar").css("display","");
      $("#topbar").css("display","");
    }
  </script>


  <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('backend/js/ruang-admin.min.js') }}"></script>
  <script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('backend/js/demo/chart-area-demo.js') }}"></script>  
</body>

</html>
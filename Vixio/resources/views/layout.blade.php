<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>@yield('title') - Vixio CMS</title>
   <meta name="description" content="Sufee Admin - HTML5 Admin Template">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="apple-touch-icon" href="apple-icon.png">
   <link rel="shortcut icon" href="favicon.ico">

   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/normalize.css')}}">
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/font-awesome.min.css')}}">
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/themify-icons.css')}}">
   {{-- <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/flag-icon-min.css')}}"> --}}
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/cs-skin-elastic.css')}}">
   <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/scss/style.css')}}">
   <link rel="stylesheet" href="{{asset('vixio-cms/assets/css/lib/vector-map/jqvmap.min.css')}}">
   <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' type='text/css'>
   <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
   
   @yield('stylesheet')
</head>

<body>
   <!-- Left Panel -->
   <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">

         <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">
               <h3>VIXIO CMS</h3>
            </a>
            <a class="navbar-brand hidden" href="#"></a>
         </div>

         <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
               <li class="active">
                  <a href="{{ route('dashboard') }}">
                     <i class="menu-icon fa fa-dashboard"></i>Dashboard
                  </a>
               </li>

               {{-- Pages --}}
               <h3 class="menu-title">Pages</h3>
               <li class="menu-item-has-children dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="menu-icon fa fa-list-alt"></i>Blog
                  </a>
                  <ul class="sub-menu children dropdown-menu">
                     <li><i class="fa fa-plus"></i><a href="{{ route('blogCreate') }}">Create New Post</a></li>
                     <li><i class="fa fa-table"></i><a href="{{ route('getPusblisedPost') }}">Published Posts</a></li>
                     <li><i class="fa fa-table"></i><a href="{{ route('getUnpublishPost') }}">Unpublish Posts</a></li>
                  </ul>
               </li>

               <li class="menu-item-has-children dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="menu-icon fa fa-list-alt"></i>Documentation
                  </a>
                  <ul class="sub-menu children dropdown-menu">
                     <li><i class="fa fa-table"></i><a href="{{ route('documentationTitle') }}">Title</a></li>
                     <li><i class="fa fa-table"></i><a href="{{ route('documentationSubtitle') }}">Subtitle</a></li>
                     <li><i class="fa fa-table"></i><a href="{{ route('documentationContent') }}">Content</a></li>
                  </ul>
               </li>
      
               {{-- User --}}
               <h3 class="menu-title">User</h3>
               <li>
                  <a href="{{ route('userList') }}"> <i class="menu-icon fa fa-users"></i>User List</a>
               </li>
               <li>
                  <a href="{{ route('userAdd') }}"> <i class="menu-icon fa fa-plus"></i>Add Admin</a>
               </li>
               <li>
                  <a href="{{ route('userReport') }}"> <i class="menu-icon fa fa-warning"></i>User Reporting</a>
               </li>
               
               {{-- Story --}}
               <h3 class="menu-title">Story</h3>
               <li class="menu-item-has-children dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-view-list"></i>Story Category</a>
                  <ul class="sub-menu children dropdown-menu">
                     <li><i class="menu-icon fa fa-bars"></i><a href="{{ route('categoryGenre') }}">Genre</a></li>
                     <li><i class="menu-icon fa fa-bars"></i><a href="{{ route('categoryType') }}">Type</a></li>
                  </ul>
               </li>
               <li>
                  <a href="{{ route('storyList') }}"> <i class="menu-icon fa fa-book"></i>Story List</a>
               </li>
               <li>
                  <a href="{{ route('storyReport') }}"> <i class="menu-icon fa fa-bullhorn"></i>Story Reporting</a>
               </li>

            </ul>
         </div><!-- /.navbar-collapse -->
      </nav>
   </aside><!-- /#left-panel -->
   <!-- Left Panel -->

   <!-- Right Panel -->
   <div id="right-panel" class="right-panel">
      <!-- Header-->
      <header id="header" class="header">
         <div class="header-menu">
            <div class="col-sm-7"></div>

            <div class="col-sm-5">
               <div class="user-area dropdown float-right">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img class="user-avatar rounded-circle" src="{{asset('image/default-user.png')}}" alt="User Avatar">
                  </a>

                  <div class="user-menu dropdown-menu">
                     <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                           <i class="fa fa-power -off"></i>Logout
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </header>

      <div class="breadcrumbs">
         <div class="col-sm-4">
            <div class="page-header float-left">
               <div class="page-title">
                  <h1>Dashboard</h1>
               </div>
            </div>
         </div>
         <div class="col-sm-8">
            <div class="page-header float-right">
               <div class="page-title">
               <ol class="breadcrumb text-right">
                  <li>
                     <a href="{{route('dashboard')}}">Dashboard</a>
                  </li>
                  @for($i = 1; $i <= count(Request::segments()); $i++)
                     @if($i == count(Request::segments()))
                     <li class="active">
                     @else
                     <li>
                     @endif
                        {{Request::segment($i)}}
                     </li>
                  @endfor
               </ol>
                  <!-- <ol class="breadcrumb text-right">
                     <li class="active">Dashboard</li>
                  </ol> -->
               </div>
            </div>
         </div>
      </div>
      
      {{-- Page Content Goes Here --}}
      <div class="content mt-3">
         @yield('content')
      </div>
   </div>

   <script src="{{asset('vixio-cms/assets/js/vendor/jquery-2.1.4.min.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
   <script src="{{asset('vixio-cms/assets/js/plugins.js')}}"></script>
   <script src="{{asset('vixio-cms/assets/js/main.js')}}"></script>
   <script src="{{asset('vixio-cms/assets/js/lib/chart-js/Chart.bundle.js')}}"></script>
   {{-- <script src="{{asset('vixio-cms/assets/js/dashboard.js')}}"></script> --}}
   {{-- <script src="{{asset('vixio-cms/assets/js/widgets.js')}}"></script> --}}
   
   {{-- Insert JS Here --}}
   @yield('script')

</body>
</html>

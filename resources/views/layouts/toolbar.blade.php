<div class="row d-flex justify-content-center">
    <img src="{{ asset('assets/images/head.png') }}" width="80px">
</div>
<div class="container-fluid px-0" style="background-color: #74b9ff;">
    <div class="container px-0">
        <nav class="navbar navbar-expand-lg navbar-light">
            <img src="{{ asset('assets/images/logo.png') }}">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ml-3" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Request::is('index') ? 'active bg-white rounded-lg' : '' }}">
                        <a class="nav-link" href="/index"><i class="fa fa-home"></i> Home <span
                                class="sr-only">(current)</span></a>
                    </li>
                    {{-- <li class="nav-item {{ Request::is('project') ? 'active bg-white rounded-lg' : '' }}">
                        <a class="nav-link" href="/project"><i class="fas fa-folder-open"></i> Project</a>
                    </li> --}}
                    <li class="nav-item dropdown {{ Request::is('project') ? 'active bg-white rounded-lg' : '' }}">
                        <a class="nav-link dropdown-toggle" href="/project" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-folder-open"></i>Project </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/project">My project</a>
                            <a class="dropdown-item" href="/roject/add">Add</a>
                        </div>
                    </li>
                    <li class="nav-item  {{ Request::is('cases') ? 'active bg-white rounded-lg' : '' }}">
                        <a class="nav-link" href="/cases"> <i class="fas fa-edit"></i>Case</a>
                    </li>
                </ul>
                {{-- <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form> --}}
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline small">Minny Nicapa</span>
                            <img class="img-profile rounded-circle" src="{{ asset('themes/img/undraw_profile.svg') }}"
                                width="32px">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            {{-- <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
    </div>
</div>
</nav>

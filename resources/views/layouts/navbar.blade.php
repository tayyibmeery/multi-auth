<!-- Navbar -->
{{-- <nav class="main-header navbar navbar-expand @auth navbar-white navbar-light @else navbar-custom @endauth"> --}}
    <!-- Left navbar links -->
    <nav class="main-header navbar navbar-expand @auth navbar-white navbar-light @else navbar-custom @endauth" id="main-navbar">

    <ul class="navbar-nav">
        @auth
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        @else
        <li class="nav-item">
            <a href="{{ url("/") }}" class="navbar-brand">
                <i class="fas fa-warehouse mr-2"></i>
                <span>Inventory System</span>
            </a>
        </li>
        @endauth

        @auth
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
        @endauth
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @auth
        <!-- Navbar Search (commented out but preserved) -->
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li> --}}

        <!-- Messages Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li> --}}

        <!-- Contact Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                @if($unreadMessagesCount > 0)
                <span class="badge badge-danger navbar-badge">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    {{ $unreadMessagesCount }} Unread Messages
                </span>
                <div class="dropdown-divider"></div>
                @foreach($recentMessages as $message)
                <a href="{{ route('admin.messages.show', $message->id) }}" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{ $message->name }}
                                <span class="float-right text-sm text-muted">
                                    <i class="fas fa-clock"></i> {{ $message->created_at->diffForHumans() }}
                                </span>
                            </h3>
                            <p class="text-sm">{{ Str::limit($message->message, 50) }}</p>
                            <p class="text-sm text-muted">{{ $message->email }}</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                @endforeach
                <a href="{{ route('admin.messages.index') }}" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>


        <!-- Profile Dropdown Menu with User Name -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="far fa-user mr-1"></i>
                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'User' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>{{ auth()->user()->name ?? 'User' }}</strong>
                    <div class="text-muted small">{{ auth()->user()->email ?? '' }}</div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item bg-transparent border-0 w-100 text-left">
                        <i class="fas fa-sign-out-alt mr-2 text-danger"></i>
                        <span class="text-danger">Logout</span>
                    </button>
                </form>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link" href="#" id="dark-mode-toggle" role="button">
                <i class="fas fa-moon"></i>
            </a>
        </li>

        @else
        <!-- For non-authenticated users -->
        <li class="nav-item">
            <a href="{{ route("login") }}" class="nav-link px-4">
                <i class="fas fa-user mr-2"></i>
                <span class="font-weight-bold">User Login</span>
            </a>
        </li>
        @endauth
    </ul>
</nav>
<!-- /.navbar -->

<nav class="my-nav">
    <div class="navi">
        @auth
            <div class="nav-item"><h2>Hello {{ $name }}</h2></div>
            <div class="nav-item">
                <form method="GET" action="{{ route('get_contacts') }}">
                    @csrf
                    <button type="submit" class="home-btn">Home</button>
                </form>
            </div>
            <div class="nav-item">
                <a href="{{ route('page/create/contact') }}">Create Contact</a>
            </div>  
            <div class="nav-item">
                <a href="{{ route('/page/profile/update') }}">Profile</a>
            </div>
            <div class="nav-item">
                <form 
                    method="GET" 
                    action="{{ route('logout') }}"
                    onsubmit="return confirm('Are you sure you want to sign out?');"
                >
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @else
            <h1>Phone Book</h1>
        @endauth
    </div>
</nav>

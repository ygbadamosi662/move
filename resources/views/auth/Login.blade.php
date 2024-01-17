<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
</head>
<body>
    @include('Navigation')

    <div class="content">
        <h1>Login</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (isset($success))
            <div class="alert alert-success">
                {{ $success }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="user">
            @csrf

            <div class="field txt">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="field txt">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="field chk">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <div class="btn">
                <button type="submit">Login</button>
                <div class="reg">
                    <a href="{{ route('/page/register') }}">Register</a>
                </div>
            </div>
        </form>
    </div>
    @include('Footer')
</body>
</html>
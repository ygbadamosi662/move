<!DOCTYPE html>
<html>
<head>
    <title>Password Update</title>
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
    @include('Navigation', ['name' => auth()->user()->fname])
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h2>Upadate apassword</h2>
        <form method="POST" action="{{ route('update_password') }}" class="user">
            @csrf
        
          <div class="field txt">
            <label for="password">Old Password</label>
            <input type="password" id="old_password" name="old_password" required>
          </div>

          <div class="field txt">
            <label for="password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
          </div>

          <div class="field txt">
            <label for="password_confirmation">New Password Confirmation</label>
            <input type="new_password_confirmation" id="new_password_confirmation" name="new_password_confirmation" required>
          </div>
        
          <button type="submit">Update</button>
        </form>
    </div>
    @include('Footer')
</body>
</html>
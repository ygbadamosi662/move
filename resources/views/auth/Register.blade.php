<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
</head>
<body>
    @include('Navigation')
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

      @if (isset($success))
          <div class="alert alert-success">
              {{ $success }}
          </div>
      @endif
      <h1>Register</h1>
      <form method="POST" action="{{ route('register') }}" class="user">
          @csrf

        <div class="field txt">
          <label for="fname">First Name</label>
          <input type="text" id="fullname" name="fname" value="{{ old('fname') }}" required>
        </div>

        <div class="field txt">
          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lname" value="{{ old('lname') }}"required>
        </div>

        <div class="field txt">
          <label for="aka">A.K.A</label>
          <input type="text" id="aka" name="aka" value="{{ old('aka') }}" >
        </div>

        <div class="field num">
          <label for="age">Age</label>
          <input type="number" id="age" name="age" value="{{ old('age') }}" >
        </div>

        <div class="field txt">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}"  required>
        </div>

        <div class="field txt">
          <label for="phone">Phone</label>
          <input type="text" id="phone" name="phone" value="{{ old('phone') }}"  required>
        </div>

        <div class="field txt">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" value="{{ old('password') }}"  required>
        </div>

        <div class="field txt">
          <label for="password_confirmation">Password Confirmation</label>
          <input 
            type="password_confirmation" 
            id="password_confirmation" 
            name="password_confirmation" 
            value="{{ old('password_confirmation') }}" 
            required
          >
        </div>

        <div class="field txt-area">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="4" value="{{ old('address') }}" ></textarea>
        </div>

        <div class="btn">
          <button type="submit">Register</button>
          <a href="{{ route('/page/login') }}">Login</a>
        </div>
      </form>
    </div>
    @include('Footer')
</body>
</html>
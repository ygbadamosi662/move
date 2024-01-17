<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
      .header{
        display: flex;
        flex-direction: row;
        padding: 1rem;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
      }

      .header a {
        text-decoration: none;
        cursor: pointer;
      }

      .header button{
        border: none;
        background: none;
        padding: 0;
        margin: 0;
        font: inherit;
        cursor: pointer;
      }
    </style>
</head>
<body>
    @include('Navigation', ['name' => auth()->user()->fname])

    <div class="header">
      <form method="GET" action="{{ route('delete_user') }}">
          @csrf
          <button type="submit">Delete Account</button>
      </form>
      <a href="{{ route('/page/password/update') }}">Update Password</a>
  </div>

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

    <form method="POST" action="{{ route('update_user') }}" class="user">
        @csrf
        
      <div class="field txt">
        <label for="fname">First Name</label>
        <input type="text" id="fullname"  value="{{ auth()->user()->fname }}" name="fname" required>
      </div>

      <div class="field txt">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" value="{{ auth()->user()->lname }}" required>
      </div>

      <div class="field txt">
        <label for="aka">A.K.A</label>
        <input type="text" id="aka" name="aka" value="{{ auth()->user()->aka }}">
      </div>
      
      <div class="field num">
        <label for="age">Age</label>
        <input type="number" id="age" name="age" value="{{ auth()->user()->age }}">
      </div>
      
      <div class="field txt">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
      </div>

      <div class="field txt">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}" required>
      </div>

      <div class="field">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="4">{{ auth()->user()->address }}</textarea>
      </div>
      
      <div class="field txt">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      
      <button type="submit">Update</button>
    </form>
    @include('Footer')
</body>
</html>
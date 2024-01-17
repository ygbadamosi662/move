<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <title>Create Contact</title>
</head>
<body>
    @include('Navigation', ['name' => auth()->user()->fname])
    <div class="content">
        <h1>Create A Contact</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('create_contact') }}" class="create">
            @csrf

            <div class="field txt">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" required>
            </div>

            <div class="field txt">
              <label for="phone">Phone</label>
              <input type="text" id="phone" name="phone" required>
            </div>

            <div class="field">
              <label for="type">Select Contact Type:</label>
              <select name="type" id="type">
                  <option value="home">Home</option>
                  <option value="work">Work</option>
                  <option value="other">Other</option>
              </select>
            </div>

            <div class="field">
                <label for="ship">Select Contact Relationship</label>
                <select name="ship" id="ship">
                    <option value="fam">Fam</option>
                    <option value="friend">Friend</option>
                    <option value="colleague">Colleague</option>
                    <option value="acquaintance">Acquaintance</option>
                    <option value="foe">Foe</option>
                    <option value="boss">Boss</option>
                    <option value="other">Other</option>
                </select>
              </div>

              <button type="submit">Create</button>
        </form>
    </div>
    @include('Footer')
</body>
</html>
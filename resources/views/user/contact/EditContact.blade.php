<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <title>Edit Contact</title>
</head>
<body>
    @include('Navigation', ['name' => auth()->user()->fname])
    <div class="content">
        <h1>Edit Contact</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('update_contact') }}" class="create">
            @csrf
            <input hidden ="text" id="id" name="id" value="{{ $contact->id}}">
            <div class="field txt">
              <label for="name">Name</label>
              <input    
                type="text" 
                id="name" 
                name="name" 
                value="{{ $contact->name }}" r
                equired
              >
            </div>

            <div class="field txt">
              <label for="phone">Phone</label>
              <input 
                type="text" 
                id="phone" 
                name="phone" 
                value="{{ $contact->phone }}" 
                required
              >
            </div>

            <div class="field">
              <label for="type">Select Contact Type:</label>
              <select name="type" id="type">
                  <option 
                    value="home" 
                    {{ $contact->type == 'home' ? 'selected' : '' }}
                  >Home</option>
                  <option 
                    value="work" 
                    {{ $contact->type == 'work' ? 'selected' : '' }}
                  >Work</option>
                  <option 
                    value="other" 
                    {{ $contact->type == 'other' ? 'selected' : '' }}
                  >Other</option>
              </select>
            </div>

            <div class="field">
                <label for="ship">Select Contact Relationship</label>
                <select name="ship" id="ship">
                    <option 
                        value="fam" 
                        {{ $contact->ship == 'fam' ? 'selected' : '' }}
                    >Fam</option>
                    <option 
                        value="friend" 
                        {{ $contact->ship == 'friend' ? 'selected' : '' }}
                    >Friend</option>
                    <option 
                        value="colleague" 
                        {{ $contact->ship == 'colleague' ? 'selected' : '' }}
                    >Colleague</option>
                    <option 
                        value="acquaintance" 
                        {{ $contact->ship == 'acquaintance' ? 'selected' : '' }}
                    >Acquaintance</option>
                    <option 
                        value="foe" 
                        {{ $contact->ship == 'foe' ? 'selected' : '' }}
                    >Foe</option>
                    <option 
                        value="boss" 
                        {{ $contact->ship == 'boss' ? 'selected' : '' }}
                    >Boss</option>
                    <option 
                        value="other" 
                        {{ $contact->ship == 'other' ? 'selected' : '' }}
                    >Other</option>
                </select>
              </div>

              <button type="submit">Update</button>
        </form>
    </div>
    @include('Footer')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dash.css') }}">
</head>
<body>
    @include('Navigation', ['name' => auth()->user()->fname])

    <div class="content dash">
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

        @if (auth()->user()->contacts->isEmpty())
            <h1 class="no-contacts">No Contacts Yet</h1>
        @else
            @include('user.contact.Filter')
            <div class="contacts">
                @foreach ($contacts as $contact)
                    @include('user.contact.Contact', ['contact' => $contact])
                @endforeach
                @if ($links)
                    <div class="pg-links">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
    
    @include('Footer')
</body>
</html>

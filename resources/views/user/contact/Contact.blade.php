<div class="contact">
    <h3>{{ ucfirst($contact->name) }}</h3>
    <h4>{{ $contact->phone }}</h4>
    <div class="cp">
        <span>Type:</span>
        <h3>{{ ucfirst($contact->type) }}</h3>
    </div>
    <div class="cp">
        <span>Ship:</span>
        <h3>{{ ucfirst($contact->ship) }}</h3>
    </div>
    <div class="act">
        <form 
            method="GET" 
            action="{{ route('get_contact', ['id' => $contact->id]) }}"
            onsubmit="return confirm('Are you sure you want to edit this contact');"
        >
            @csrf
            <button class="edit-btn" type="submit">Edit</button>
        </form>
        <form 
            method="GET" 
            action="{{ route('delete_contact', ['id' => $contact->id]) }}" 
            onsubmit="return confirm('Are you sure you want to delete this contact');"
        >
            @csrf
            <button class="delete-btn" type="submit">Delete</button>
        </form>
    </div>
</div>

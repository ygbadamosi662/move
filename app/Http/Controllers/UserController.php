<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Enums\ContactShip;
use App\Models\Enums\ContactType;

class UserController extends Controller
{
    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:200', 'min:5'],
            'lname' => ['required', 'string', 'max:200', 'min:5'],
            'aka' => ['string', 'max:200', 'min:5'],
            'email' => ['required', 'email', 'max:200'],
            'phone' => ['required', 'regex:/^(80|70|90|71|81|91)\d{8}$/'],
            'age' => ['integer', 'max:200'],
            'address' => ['string', 'max:500'],
            'password' => ['required', 'regex:/^(?=.*\d)(?=.*[A-Z]).{1,8}$/'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $validatedData = $validator->validated();

        // get user
        $user = Auth::user();

        // check password
        if(!Hash::check($validatedData['password'], $user['password'])) {
            return redirect()->back()->with(['error' => 'Invalid password'])->withInput();
        }

        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->age = $validatedData['age'];
        $user->address = $validatedData['address'];
        $user->fname = $validatedData['fname'];
        $user->lname = $validatedData['lname'];
        $user->aka = $validatedData['aka'];
        
        // save user
        $user->save();

        session()->flash('success', 'Profile updated successfully');

        // Authentication passed
        return redirect()->route('get_contacts');
    }

    public function update_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'regex:/^(?=.*\d)(?=.*[A-Z]).{1,8}$/'],
            'new_password' => ['required', 'regex:/^(?=.*\d)(?=.*[A-Z]).{1,8}$/'],
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = Auth::user();
    
        if(!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with(['error' => 'Invalid password'])->withInput();
        }

        $user->setPasswordAttribute($request->new_password);
        // save user
        $user->save();

        session()->flash('success', 'Password updated successfully');

        return view('user.Profile', ['user' => $user]);
        
    }

    public function delete_user(Request $request)
    {
        $id = Auth::user()->id;
        User::destroy($id);

        return view('auth.Register', ['success' => 'Account deleted successfully']);
    }

    public function logout(Request $request)
    {
        $email = Auth::user()->email;
        Auth::logout();

        return view('auth.Login', [
            'success' => 'User logged out successfully',
             'email' => $email
            ]);
    }

    public function get_user(Request $request)
    {
        $user = Auth::user();

        return view('user.Profile', ['user' => $user]);
    }

    public function create_contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200|min:5',
            'phone' => ['required', 'regex:/^(80|70|90|71|81|91)\d{8}$/'],
            'type' => ['in:' . implode(',', ContactType::values())],
            'ship' => ['in:' . implode(',', ContactShip::values())],
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        $user = Auth::user();
        $contact_exist = $user->contacts()->where('phone', $request->phone)->exists();
        //if phone already exists
        if($contact_exist) {
            return redirect()
                ->back()
                ->with('error', 'phone number already added');
        }

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->type = $request->type;
        $contact->ship = $request->ship;

        $user = Auth::user();

        // Associates the contact with the user
        $user->contacts()->save($contact);

        // pass success
        session()->flash('success', 'Contact added Succesfully');
    
        return redirect()->route('get_contacts');
            
    }

    public function update_contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200|min:5',
            'phone' => ['required', 'regex:/^(80|70|90|71|81|91)\d{8}$/'],
            'type' => ['in:' . implode(',', ContactType::values())],
            'ship' => ['in:' . implode(',', ContactShip::values())],
        ]);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())  
                ->withInput();
        }

        // get contact
        $contact = Contact::find($request->id)->first();

        // update contacts
        $contact->name = $request->name;
        $contact->phone = $request->name;
        if($request->has('type')) {
            $contact->type = $request->type;
        }
        if($request->has('ship')) {
            $contact->ship = $request->ship;
        }

        // save contact
        $contact->save();
    
        // pass success
        session()->flash('success', 'Contact updated successfully');

        return redirect()->route('get_contacts');
    }

    public function delete_contact(Request $request, string $id)
    {
        $user = Auth::user();

        $contact = $user->contacts()->find($id);

        if ($contact) {
            $contact->delete();

            session()->flash('success', 'Contact deleted successfully');

            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'Contact not found');
        }
    }

    public function get_contacts(Request $request)
    {
        $method = $request->method();
        
        if ($method === 'GET') {
            // session()->has('default_filter')
            $default_filter= session('default_filter');
            $user = Auth::user();
            $contacts = $user
                ->contacts()
                ->orderBy('created_at')
                ->paginate(5);

            $currentPage = $contacts->currentPage();
            $totalPages = $contacts->lastPage();
            $hasNextPage = $contacts->hasMorePages();
            $nextPageNumber = $contacts->nextPageUrl() ? $contacts->currentPage() + 1 : null;

            $pageInfo = [
                'currentPage'=>$currentPage,
                'totalPages'=>$totalPages,
                'hasNextPage'=>$hasNextPage,
                'nextPageNumber'=>$nextPageNumber
            ];

            return view('user.Dashboard')
                ->with([
                    'contacts' => $contacts,
                    'pageInfo' => $pageInfo,
                    'links' => true
                ]);
            
        } elseif ($method === 'POST') {
            // dd($request->phone);
            // dd($request->name);
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:200|min:5',
                'phone' => ['nullable', 'string','regex:/^(80|70|90|71|81|91)\d{8}$/'],
                'type' => ['nullable','in:' . implode(',', ContactType::values())],
                'ship' => ['nullable','in:' . implode(',', ContactShip::values())],
            ]);
    
            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }
            // dd($request->phone);
            $user = Auth::user();
            $query = $user->contacts();
    
            // build query
            if (($request->name != null) || ($request->phone != null)) {
                // cause we dont need to paginate for name and phone query parameters
                // phone is unique 
                // and if you know anyone with > 10 active numbers you know a criminal
                if($request->name != null) {
                    // dd("why are you here");
                    $query->where('name', $request->name);
                }
                if($request->phone != null) {
                    $query->where('phone', $request->phone);
                }
    
                $contacts = $query->get();
    
                return view('user.Dashboard')
                    ->with([
                        'contacts' => $contacts,
                        'links' => false
                    ]);
                
            }
            if ($request->type != null) {
                $query->where('type', $request->type);
            }
            if ($request->ship != null) {
                $query->where('ship', $request->ship);
            }
    
            $query->orderBy('created_at');

            $contacts = $query->paginate(5);

            $currentPage = $contacts->currentPage();
            $totalPages = $contacts->lastPage();
            $hasNextPage = $contacts->hasMorePages();
            $nextPageNumber = $contacts->nextPageUrl() ? $contacts->currentPage() + 1 : null;

            $pageInfo = [
                'currentPage'=>$currentPage,
                'totalPages'=>$totalPages,
                'hasNextPage'=>$hasNextPage,
                'nextPageNumber'=>$nextPageNumber
            ];
    
            return view('user.Dashboard')
                ->with([
                    'contacts' => $contacts,
                    'pageInfo'=>$pageInfo,
                    'links' => true
                ]);
        }
        
    }


    public function get_contact(Request $request, string $id)
    {
        if(empty($id)) {
            return redirect()->back()->with('error', 'Contact id is required');
        }
        $user = Auth::user();

        $contact = $user->contacts()->find($id);

        if ($contact) {
            return view('user.contact.EditContact')
                ->with(['contact' => $contact]);
        } else {
            return redirect()->back()->with('error', 'Contact not found');
        }

    }
}

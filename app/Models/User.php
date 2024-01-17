<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    use HasUuids;


    protected $fillable = ['fname', 'email', 'phone', 'password', 'lname', 'aka'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Set the password attribute.
     *
     * @param mixed $pwd The value to set the password attribute to.
     * @return void
     */
    public function setPasswordAttribute($pwd)
    {
        $this->attributes['password'] = Hash::make($pwd);
    }

    /**
     * Authenticates the user with the provided password.
     *
     * @param string $pwd The password to authenticate with.
     * @return bool Returns true if authentication is successful, false otherwise.
     */
    public function authenticate($pwd)
    {
        return Hash::check($pwd, $this->password);
    }

    
}
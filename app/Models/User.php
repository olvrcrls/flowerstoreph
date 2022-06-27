<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Attribute that the model will use as the database table;
     */
    protected $table = "users_table";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name',
        'email_address', 'mobile_number',
        'address', 'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Setter and Getter for First Name attribute.
     * 
     */ 
    protected function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = strtolower($value);
    }

    protected function getFirstNameAttribute($value) {
        return ucwords($value);
    }

    /**
     * Interact with the user's last name.
     * To make all values stored in database be homogeneous
     * @param  string  $value
     */
    protected function setLastNameAttribute($value) {
        $this->attributes['last_name'] = strtolower($value);
    }

    /**
     * Interact with the user's last name.
     * To make all values stored in database be homogeneous
     * @param  string  $value
     */
    protected function getLastNameAttribute($value) {
        return ucwords($value);
    }

    public function orders() {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function getEmailForPasswordReset() {
        return $this->email_address;
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'customer_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_by',
        'updated_by',
        'last_login_at',
        'last_login_ip',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        
    ];


    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'role' => 'required',
        'password' => 'required',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'BAccountID', 'customer_id');
    }
}

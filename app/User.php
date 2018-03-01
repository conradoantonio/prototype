<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the rol of the current user.
     *
     */
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    /**
     * Check the role of the current user.
     *
     */
    public function checkRole($roles)
    {
        foreach ($roles as $role) {
            if ($this->role->role == $role) {
                return true;
            }
        }
        return false;
    }
}

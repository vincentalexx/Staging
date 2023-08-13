<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{

    protected $fillable = [
        "name",
        "guard_name",
    ];

    protected $hidden = [

    ];

    protected $dates = [
        "created_at",
        "updated_at",
    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/permissions/'.$this->getKey());
    }

    public function role()
    {
        return $this->hasOne('App\Role');
    }

}

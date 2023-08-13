<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
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
        "deleted_at",
    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/roles/'.$this->getKey());
    }
}

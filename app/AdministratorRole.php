<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministratorRole extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function details()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

<?php

namespace App;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministratorRole extends Model
{
    use SoftDeletes, Historiable;

    protected $guarded = [];

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function details()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

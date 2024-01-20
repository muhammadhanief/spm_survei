<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class TargetResponden extends Model
{
    use HasFactory;
    protected $guard_name = 'web';
    protected $table = 'target_respondens';
    protected $fillable = ['name', 'email', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

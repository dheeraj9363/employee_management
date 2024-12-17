<?php

namespace App\Models;

// Facades
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'address',
        'gender',
        'hobby',
        'photo',
    ];

    protected $date = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

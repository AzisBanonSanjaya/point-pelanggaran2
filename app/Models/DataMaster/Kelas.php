<?php

namespace App\Models\DataMaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];
}

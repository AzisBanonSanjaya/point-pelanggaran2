<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntervalPoint extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'from',
        'to',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $appends = ['formatted_type'];

     protected function formattedType(): Attribute
    {

        if($this->type == 'Berat'){
            $type = '<span class="badge rounded-pill bg-danger">BERAT</span>';
        }elseif($this->type == 'Sedang'){
             $type = '<span class="badge rounded-pill bg-warning text-dark">SEDANG</span>';
        }elseif($this->type == 'Ringan'){
             $type = '<span class="badge rounded-pill bg-primary">RINGAN</span>';
        }else{
            $type = '-';
        }

        return new Attribute(
            get: fn () => $type,
        );
    }
}

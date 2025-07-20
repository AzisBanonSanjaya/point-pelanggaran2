<?php

namespace App\Models\MasterData;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'major',
        'code',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];
    
    /**
     * Get the user that owns the ClassRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'Teacher');
                    });

    }

    /**
     * Get all of the student for the ClassRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function student(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($query) {
                        $query->where('name', 'User');
                    });;
    }
}

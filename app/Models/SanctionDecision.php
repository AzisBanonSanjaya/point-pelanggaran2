<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanctionDecision extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'user_id',
        'code',
        'report_date',
        'total_point',
        'status',
        'file',
        'description',
        'reason_reject',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    /**
     * Get all of the sanctionDecisionDetail for the SanctionDecision
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sanctionDecisionDetail(): HasMany
    {
        return $this->hasMany(SanctionDecisionDetail::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->whereHas('roles', function ($query) {
                        $query->where('name', 'User');
                    });;
    }

    public function userCreated(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

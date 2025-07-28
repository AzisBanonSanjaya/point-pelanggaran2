<?php

namespace App\Models;

use App\Models\MasterData\Category;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SanctionDecisionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanction_decision_id',
        'category_id',
        'incident_date',
        'file',
        'comment',
    ];


    protected $appends = ['file_url'];

    protected function fileUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file ? asset('storage/pelanggaran/'. $this->file) : 'https://www.toprankindonesia.com/wp-content/uploads/2023/10/4.-Apa-itu-404-not-Found-scaled.jpg',
        );
    }
    /**
     * Get the category that owns the SanctionDecisionDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sanctionDetail(): BelongsTo
    {
        return $this->belongsTo(SanctionDecision::class, 'sanction_decision_id');
    }
}

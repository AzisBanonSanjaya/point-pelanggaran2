<?php

namespace App\Models\MasterData;

use App\Models\RecomandationSanction;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'point',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $appends = ['formatted_type','formatted_rekomendasi'];

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

    /**
     * Accessor baru untuk memformat rekomendasi menjadi daftar <li>.
     */
    protected function formattedRekomendasi(): Attribute
    {
        // Ambil relasi dan periksa apakah ada isinya
        if ($this->recomendation->isNotEmpty()) {
            
            // Ambil semua nama, bungkus dengan <li>, lalu gabungkan
            $listItems = $this->recomendation->pluck('name')
                ->map(fn ($name) => "<li>{$name}</li>")
                ->implode('');

            $html = "<ul>{$listItems}</ul>";
        } else {
            $html = '-'; // Tampilkan strip jika tidak ada rekomendasi
        }
        
        return Attribute::get(fn () => $html);
    }

    /**
     * Get all of the recomendation for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recomendation(): HasMany
    {
        return $this->hasMany(RecomandationSanction::class, 'category_id', 'id');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\MasterData\ClassRoom;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_room_id',
        'name',
        'username',
        'email',
        'password',
        'image',
        'date_of_birth',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:d M Y H:i',
    ];

    /**
     * @var array<int, string>
    */
    protected $appends = ['image_url', 'translated_date', 'formatted_date_of_birth'];

    protected function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('storage/user/'. $this->image) : asset('assets/img/user-notfound.png'),
        );
    }

    protected function translatedDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->created_at)->translatedFormat('l, d F Y'),
        );
    }
    protected function formattedDateOfBirth(): Attribute
    {
        return new Attribute(
            get: fn () => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->translatedFormat('d/m/Y') : '-',
        );
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotSuperAdmin($query): Builder
    {
        return $query->where('id', "!=", 1);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);

    }

}

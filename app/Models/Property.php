<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'address',
        'city',
        'country',
        'postal_code',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'floor',
        'furnished',
        'available',
        'type',
        'status',
        'featured',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'furnished' => 'boolean',
        'available' => 'boolean',
        'featured' => 'boolean',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function reservations(){
        return $this->belongsTo(Reservation::class);
    }
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function getStatusColorAttribute()
    {
        return [
            'available' => 'success',
            'rented' => 'warning',
            'maintenance' => 'danger'
        ][$this->status] ?? 'secondary';
    }

    public function getTypeTextAttribute()
    {
        return [
            'apartment' => 'Appartement',
            'studio' => 'Studio',
            'duplex' => 'Duplex'
        ][$this->type] ?? $this->type;
    }
}

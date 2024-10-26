<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

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
        'type',
        'status',
        'furnished',
        'featured',
        'user_id'
    ];

    protected $casts = [
        'furnished' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'property_id');
    }

    // Accesseurs
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

    public function getStatusTextAttribute()
    {
        return [
            'available' => 'Disponible',
            'rented' => 'Loué',
            'maintenance' => 'En maintenance'
        ][$this->status] ?? $this->status;
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    // SoftDeletes;

    protected $fillable = [
        'property_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'guests',
        'status',
        'payment_status',
        'notes'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'decimal:2'
    ];

    // Relations
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs pour les statuts
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info'
        ][$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'cancelled' => 'Annulée',
            'completed' => 'Terminée'
        ][$this->status] ?? $this->status;
    }

    public function getPaymentStatusTextAttribute()
    {
        return [
            'pending' => 'En attente',
            'paid' => 'Payé',
            'refunded' => 'Remboursé'
        ][$this->payment_status] ?? $this->payment_status;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>', now())->orderBy('check_in');
    }

    public function scopeCurrentAndFuture($query)
    {
        return $query->where('check_out', '>=', now())->orderBy('check_in');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'guests',
        'status',
        'payment_status',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'property_id' => 'integer',
        'user_id' => 'integer',
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
    ];

     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     // Accesseurs
     public function getStatusColorAttribute()
     {
         return [
             'pending' => 'warning',
             'confirmed' => 'success',
             'cancelled' => 'danger',
             'completed' => 'info',
         ][$this->status] ?? 'secondary';
     }
 
     public function getPaymentStatusColorAttribute()
     {
         return [
             'pending' => 'warning',
             'paid' => 'success',
             'refunded' => 'info'
         ][$this->payment_status] ?? 'secondary';
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
 
     // Scopes
     public function scopeUpcoming($query)
     {
         return $query->where('check_in', '>=', now())->orderBy('check_in');
     }
 
     public function scopeActive($query)
     {
         return $query->whereIn('status', ['pending', 'confirmed']);
     }
 
     // Méthodes
     public function calculateDuration()
     {
         return $this->check_in->diffInDays($this->check_out);
     }
 
     public function isActive()
     {
         return in_array($this->status, ['pending', 'confirmed']);
     }
}

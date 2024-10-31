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
        'notes',
        'total_paid',
        'motif_annulation',
        'date_annulation'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'date_annulation' => 'datetime'
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
    public const STATUTS = [
        'en_attente' => 'En attente',
        'confirmee' => 'Confirmée',
        'annulee' => 'Annulée'
    ];


    /**
     * Obtenir l'utilisateur qui a fait la réservation.
     */


    /**
     * Obtenir les paiements associés à la réservation.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Vérifier si la réservation est annulable.
     */
    public function isCancellable(): bool
    {
        return $this->statut !== 'cancelled' &&
               $this->date_debut->isFuture() &&
               $this->date_debut->diffInHours(now()) >= 48;
    }

    /**
     * Vérifier si la réservation est en cours.
     */
    public function isOngoing(): bool
    {
        return now()->between($this->date_debut, $this->date_fin);
    }

    /**
     * Obtenir le montant total payé.
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()
            ->where('status', 'completed')
            ->sum('amount');
    }

    /**
     * Obtenir le solde restant à payer.
     */
    public function getRemainingBalanceAttribute(): float
    {
        return $this->montant_total - $this->total_paid;
    }

    /**
     * Obtenir la durée du séjour en nuits.
     */
    public function getNightsCountAttribute(): int
    {
        return $this->date_debut->diffInDays($this->date_fin);
    }

    /**
     * Vérifier si la réservation est entièrement payée.
     */
    public function isFullyPaid(): bool
    {
        return $this->total_paid >= $this->total_price;
    }
}

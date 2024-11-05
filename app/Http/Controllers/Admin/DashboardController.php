<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $properties = Property::with([
            'reservations.payments',
            'reservations.user',
            'images'
        ])->get()
            ->sortByDesc(function($property) {
                return $property->reservations->sum('total_paid');
         });
         $totalAmount = $properties->sum(function($property) {
             return $property->reservations->sum('total_paid');
         });
         $pendingAmount = $properties->sum(function($property) {
             return $property->reservations->where('status', 'pending')->sum('total_paid');
         });
         $completedAmount = $properties->sum(function($property) {
             return $property->reservations->where('status', 'completed')->sum('total_paid');
         });
         $refundedAmount = $properties->sum(function($property) {
             return $property->reservations->where('payment_status','refunded')->sum('total_paid');
         });
         $totalReservations = $properties->sum(function($property) {
             return $property->reservations->count();
         });
         $averagePrice = $properties->sum(function($property) {
             return $property->reservations->avg('total_price');
         });
         $averageOccupancy = $properties->sum(function($property) {
            try {
                return $property->reservations->sum('guests') / $property->reservations->count();
            } catch (\Throwable $th) {
                return 0;
            }
         });



        return view('admin.dashboard',compact('properties'));
    }
}

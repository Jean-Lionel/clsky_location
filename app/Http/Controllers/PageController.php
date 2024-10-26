<?php

namespace App\Http\Controllers;

use App\Models\Property;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        $properties = Property::query()
            ->with(['images', 'user'])
            ->withCount('reservations')
            ->when(request('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when(request('type'), function($query, $type) {
                $query->where('type', $type);
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('min_price'), function($query, $price) {
                $query->where('price', '>=', $price);
            })
            ->when(request('max_price'), function($query, $price) {
                $query->where('price', '<=', $price);
            })
            ->when(request('bedrooms'), function($query, $bedrooms) {
                $query->where('bedrooms', '>=', $bedrooms);
            })
            ->when(request('bathrooms'), function($query, $bathrooms) {
                $query->where('bathrooms', '>=', $bathrooms);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('welcome', compact('properties'));
    }
    /**
     * Display the Accueil page.
     */

    public function Accueil()
    {
        return view('home');
    }

    /**
     * Display the about page.
     */
    public function about()
    {

        return view('pages.about');
    }

    /**
     * Display the property list page.
     */
    public function propertyList(){
        return view('pages.property-list');
    }

    /**
     * Display the property type page.
     */
    public function propertyType()
    {
        return view('pages.property-type');
    }

    /**
     * Display the property agent page.
     */
    public function propertyAgent()
    {
        return view('pages.property-agent');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Display the testimonial page.
     */
    public function testimonial()
    {
        return view('pages.testimonial');
    }

    /**
     * Display the 404 error page.
     */
    public function notFound()
    {
        return view('pages.404');
    }
    /**
     * Display all properties page.
     */
    public function allProperties()
    {
        $properties = Property::query()
            ->with(['images', 'user'])
            ->withCount('reservations')
            ->when(request('search'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when(request('type'), function($query, $type) {
                $query->where('type', $type);
            })
            ->when(request('status'), function($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('min_price'), function($query, $price) {
                $query->where('price', '>=', $price);
            })
            ->when(request('max_price'), function($query, $price) {
                $query->where('price', '<=', $price);
            })
            ->when(request('bedrooms'), function($query, $bedrooms) {
                $query->where('bedrooms', '>=', $bedrooms);
            })
            ->when(request('bathrooms'), function($query, $bathrooms) {
                $query->where('bathrooms', '>=', $bathrooms);
            })
            ->latest()->get();

        return view('pages.allproperties', compact('properties'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(Request $request)
    {
        $query = Property::with('images')
            ->where('status', 'available')
            ->when($request->search, function($q, $search) {
                $q->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($request->type, function($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->min_price, function($q, $price) {
                $q->where('price', '>=', $price);
            })
            ->when($request->max_price, function($q, $price) {
                $q->where('price', '<=', $price);
            })
            ->when($request->bedrooms, function($q, $bedrooms) {
                $q->where('bedrooms', '>=', $bedrooms);
            });

        $properties = $query->latest()->paginate(6);

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
    public function allProperties(Request $request)
    {
        $query = Property::with('images')
            ->where('status', 'available')
            ->when($request->search, function($q, $search) {
                $q->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($request->type, function($q, $type) {
                $q->where('type', $type);
            })
            ->when($request->min_price, function($q, $price) {
                $q->where('price', '>=', $price);
            })
            ->when($request->max_price, function($q, $price) {
                $q->where('price', '<=', $price);
            })
            ->when($request->bedrooms, function($q, $bedrooms) {
                $q->where('bedrooms', '>=', $bedrooms);
            });

        $properties = $query->latest()->get();

        return view('pages.allproperties', compact('properties'));
    }
}

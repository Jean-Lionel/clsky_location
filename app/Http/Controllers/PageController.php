<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view('welcome');
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
}

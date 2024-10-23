<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
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
        return view('property-list');
    }

    /**
     * Display the property type page.
     */
    public function propertyType()
    {
        return view('property-type');
    }

    /**
     * Display the property agent page.
     */
    public function propertyAgent()
    {
        return view('property-agent');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Display the testimonial page.
     */
    public function testimonial()
    {
        return view('testimonial');
    }

    /**
     * Display the 404 error page.
     */
    public function notFound()
    {
        return view('404');
    }
}

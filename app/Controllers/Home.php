<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home - Learning Management System'
        ];
        
        return view('index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us - Learning Management System'
        ];
        
        return view('about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us - Learning Management System'
        ];
        
        return view('contact', $data);
    }
}

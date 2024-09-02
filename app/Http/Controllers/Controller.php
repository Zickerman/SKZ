<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function contacts()
    {
        return view('frontend/contacts');
    }

    public function about()
    {
        return view('frontend/about');
    }
    
	public function delivery()
    {
        return view('frontend/delivery');
    }
}

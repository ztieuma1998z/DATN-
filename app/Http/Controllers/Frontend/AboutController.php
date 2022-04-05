<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutController extends FrontendController
{
    public function index()
    {
        $about = AboutPage::first();
        return view('frontend.about.index', compact('about'));
    }
}

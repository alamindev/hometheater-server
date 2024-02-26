<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function ContactPageData()
    {
        $contact= ContactPage::select('title', 'image', 'phone','email')->first();
       return response()->json([
                'success' => true,
                'contact' => $contact,
            ], 200);
    }
}
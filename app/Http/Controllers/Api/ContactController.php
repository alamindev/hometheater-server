<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserContact;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'reason' => 'required',
            'details' => 'required|min:5',
        );
        $validator = Validator::make($request->all(), (array)$rules);

        if (!$validator->fails()) {

            $contact = new Contact();
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->reason = $request->reason;
            $contact->details = $request->details;
            $contact->save();

            $setting = Setting::first();
            if ($setting) {
                Mail::to($setting->contact_email)->send(new UserContact($contact));
            }
            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }
}
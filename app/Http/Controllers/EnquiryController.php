<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    //
     public function index()
    {
        return view('front.contact-us');
    }

    public function store(Request $request){
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:enquiries,email',
            'phone' => ['required', 'digits:10'],
            'message' => 'required'
        ]);

        $enquiry = Enquiry::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ]); 
      
        return redirect()->route('contact_us')->with('success', 'Your message was sent successfully!');

    }
}

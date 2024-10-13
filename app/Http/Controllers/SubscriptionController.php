<?php

namespace App\Http\Controllers;

use App\Mail\SuccessSubscriptionMail;
use App\Models\Admin;
use App\Models\Subscription;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptionFromDB = Subscription::all();
        return view('subscription.index',['subscriptions'=>  $subscriptionFromDB]);

    }

    

public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:subscriptions,email',
        ]);

        
        $subscriber = Subscription::create($validatedData);

        
        if ($subscriber) {
            Mail::to($validatedData['email'])->send(new SuccessSubscriptionMail($validatedData['name']));
        }

        
        if (Admin::where('email', $validatedData['email'])->exists()) {
            session()->put('isAdmin', true);
            Cookie::queue('isAdmin', true, 10080); // 7 days
            return redirect()->route('subscription.index'); 
        }

       
        return redirect()->route('subscription.index')->with('success', 'You have successfully subscribed, and we have sent you an email.');

    } catch (ValidationException $e) {
       
        $email = $request->input('email');
        if (Admin::where('email', $email)->exists()) {
            
            session()->put('isAdmin', true);
            return redirect()->route('subscription.index')->with('info', 'You are already subscribed as an admin.'); 
        }

        return back()->withErrors($e->validator)->withInput();
    }
}



}

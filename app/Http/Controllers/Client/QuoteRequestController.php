<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class QuoteRequestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric|digits_between:10,15',
            'device_type' => 'required|string|max:100',
            'issue' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Log incoming request data
            Log::info('Quote request submission attempt:', $request->all());

            // Check if user exists with this email for admin reference only
            $existingUser = \App\Models\User::where('email', $request->email)->first();

            // Always use the information provided in the request form
            $quoteRequest = QuoteRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'device_type' => $request->device_type,
                'issue' => $request->issue,
                'status' => 'pending',
                'is_existing_customer' => $existingUser ? true : false,
                'notes' => '' // Admin will fill this later
            ]);

            // Log successful creation
            Log::info('Quote request created successfully:', ['id' => $quoteRequest->id, 'data' => $quoteRequest->toArray()]);

            // TODO: Send notification email to admin
            // TODO: Send confirmation email to customer

            $message = 'Quote request sent successfully!';
            if ($existingUser) {
                $message = 'Quote request sent successfully! We found your account in our system.';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Quote request submission failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Failed to submit quote request. Please try again.');
        }
    }
}

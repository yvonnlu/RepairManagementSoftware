<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QuoteRequest::withTrashed();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by name, email, or device type
        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('device_type', 'like', '%' . $request->search . '%');
            });
        }

        $quoteRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get status counts for stats
        $pendingCount = QuoteRequest::where('status', 'pending')->count();
        $quotedCount = QuoteRequest::where('status', 'quoted')->count();
        $completedCount = QuoteRequest::where('status', 'completed')->count();

        return view('admin.pages.quote_requests.index', compact('quoteRequests', 'pendingCount', 'quotedCount', 'completedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deviceTypes = \App\Models\Services::select('device_type_name')->distinct()->get();
        return view('admin.pages.quote_requests.create', compact('deviceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric|digits_between:10,15',
            'device_type' => 'required|string|max:100',
            'issue' => 'nullable|string|max:1000',
            'is_existing_customer' => 'boolean',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,quoted,completed,rejected'
        ]);

        QuoteRequest::create($validated);

        return redirect()->route('admin.quote-requests.index')
            ->with('success', 'Quote request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuoteRequest $quoteRequest)
    {
        return view('admin.pages.quote_requests.detail', compact('quoteRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuoteRequest $quoteRequest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric|digits_between:10,15',
            'device_type' => 'required|string|max:100',
            'issue' => 'nullable|string|max:1000',
            'is_existing_customer' => 'boolean',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,quoted,completed,rejected'
        ]);

        $quoteRequest->update($validated);

        return redirect()->route('admin.quote-requests.detail', $quoteRequest)
            ->with('success', 'Quote request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteRequest $quoteRequest)
    {
        $quoteRequest->delete();

        return redirect()->route('admin.quote-requests.index')
            ->with('success', 'Quote request deleted successfully.');
    }

    /**
     * Restore the specified resource from soft delete.
     */
    public function restore($id)
    {
        $quoteRequest = QuoteRequest::withTrashed()->findOrFail($id);
        $quoteRequest->restore();

        return redirect()->route('admin.quote-requests.index')
            ->with('success', 'Quote request restored successfully.');
    }
}

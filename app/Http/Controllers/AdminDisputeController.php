<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDisputeController extends Controller
{
    /**
     * Display a listing of all disputes for administrative review.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Dispute::with(['order.customer', 'order.canteen.school', 'order.courier']);

        // Filter by dispute status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by dispute type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by school (via order's canteen)
        if ($request->has('school_id') && $request->school_id !== 'all') {
            $query->whereHas('order.canteen', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }

        // Search by dispute ID, order ID, customer name, or courier name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('order', function ($subQ) use ($search) {
                      $subQ->where('id', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('order.customer', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('order.courier', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $disputes = $query->latest()->paginate(10);
        $schools = School::all(); // For school filter dropdown
        $disputeTypes = [ // All possible dispute types from PRD
            'PAYMENT_DISPUTED', 'DELIVERY_DISPUTED', 'ORDER_NOT_RECEIVED', 
            'INCORRECT_ORDER', 'OTHER_ISSUE'
        ];
        $disputeStatuses = ['PENDING', 'IN_REVIEW', 'RESOLVED', 'REJECTED']; // Possible statuses for disputes

        return view('admin.disputes.index', compact('disputes', 'schools', 'disputeTypes', 'disputeStatuses'));
    }

    /**
     * Update the status of a specific dispute.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispute  $dispute
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Dispute $dispute)
    {
        $request->validate([
            'status' => ['required', Rule::in(['PENDING', 'IN_REVIEW', 'RESOLVED', 'REJECTED'])],
        ]);

        $dispute->status = $request->status;
        $dispute->save();

        return redirect()->back()->with('success', 'Status sengketa berhasil diperbarui.');
    }
}

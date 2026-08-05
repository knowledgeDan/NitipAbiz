<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCanteenController extends Controller
{
    /**
     * Display a listing of the canteens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Canteen::with('school', 'owner');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->has('school_id') && $request->school_id !== 'all') {
            $query->where('school_id', $request->school_id);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $canteens = $query->paginate(10);
        $schools = School::all(); // For filter dropdown

        return view('admin.canteens.index', compact('canteens', 'schools'));
    }

    /**
     * Show the form for editing the specified canteen.
     *
     * @param  \App\Models\Canteen  $canteen
     * @return \Illuminate\View\View
     */
    public function edit(Canteen $canteen)
    {
        $schools = School::all();
        $statuses = ['pending', 'active', 'inactive', 'rejected'];
        return view('admin.canteens.edit', compact('canteen', 'schools', 'statuses'));
    }

    /**
     * Update the specified canteen in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Canteen  $canteen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Canteen $canteen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['pending', 'active', 'inactive', 'rejected'])],
        ]);

        $canteen->update($request->all());

        return redirect()->route('admin.canteens.index')->with('success', 'Informasi kantin berhasil diperbarui.');
    }

    /**
     * Remove the specified canteen from storage.
     *
     * @param  \App\Models\Canteen  $canteen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Canteen $canteen)
    {
        $canteen->delete();
        return redirect()->route('admin.canteens.index')->with('success', 'Kantin berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller
{
    /**
     * Display a listing of the schools.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $schools = School::all();
        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created school in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name',
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        School::create($request->all());

        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified school.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\View\View
     */
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name,' . $school->id,
            'address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $school->update($request->all());

        return redirect()->route('admin.schools.index')->with('success', 'Informasi sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified school from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}

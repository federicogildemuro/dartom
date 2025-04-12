<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    // Show the list of all barbers
    public function index()
    {
        // Fetch all barbers from the database
        $barbers = Barber::all();

        // Return the view with the list of barbers
        return view('barbers.index', compact('barbers'));
    }

    // Show the form for creating a new barber
    public function create()
    {
        return view('barbers.create');
    }

    // Store a newly created barber in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:barbers,email',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Handle photo upload if provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('barbers', 'public');
        }

        // Create a new barber record
        Barber::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $photoPath,
        ]);

        // Redirect to the barbers index with a success message
        return redirect()->route('barbers.index')->with('success', 'Barbero creado exitosamente.');
    }

    // Show the form for editing an existing barber
    public function edit($id)
    {
        // Find the barber by ID
        $barber = Barber::findOrFail($id);

        // Return the edit view with the barber data
        return view('barbers.edit', compact('barber'));
    }

    // Update the specified barber in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:barbers,email,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Find the barber by ID
        $barber = Barber::findOrFail($id);

        // Update barber's name and email
        $barber->name = $request->name;
        $barber->email = $request->email;

        // Handle photo upload if a new one is provided
        if ($request->hasFile('photo')) {
            // Delete previous photo if exists
            if ($barber->photo && file_exists(storage_path('app/public/' . $barber->photo))) {
                unlink(storage_path('app/public/' . $barber->photo));
            }
            // Save new photo
            $barber->photo = $request->file('photo')->store('barbers', 'public');
        }

        // Save the updated barber record
        $barber->save();

        // Redirect to the barbers index with a success message
        return redirect()->route('barbers.index')->with('success', 'Barbero actualizado exitosamente.');
    }

    // Delete the specified barber from the database
    public function destroy($id)
    {
        // Find the barber by ID
        $barber = Barber::findOrFail($id);

        // Delete barber's photo if exists
        if ($barber->photo && file_exists(storage_path('app/public/' . $barber->photo))) {
            unlink(storage_path('app/public/' . $barber->photo));
        }

        // Delete the barber record
        $barber->delete();

        // Redirect to the barbers index with a success message
        return redirect()->route('barbers.index')->with('success', 'Barbero eliminado exitosamente.');
    }
}

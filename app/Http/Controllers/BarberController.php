<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    // Show the list of all barbers
    public function index()
    {
        $barbers = Barber::all();
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

        Barber::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $photoPath,
        ]);

        return redirect()->route('barbers.index')->with('success', 'Barbero creado exitosamente.');
    }

    // Show the form for editing an existing barber
    public function edit($id)
    {
        $barber = Barber::findOrFail($id);
        return view('barbers.edit', compact('barber'));
    }

    // Update the specified barber in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:barbers,email,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $barber = Barber::findOrFail($id);
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

        $barber->save();

        return redirect()->route('barbers.index')->with('success', 'Barbero actualizado exitosamente.');
    }

    // Delete the specified barber from the database
    public function destroy($id)
    {
        $barber = Barber::findOrFail($id);

        // Delete barber's photo if exists
        if ($barber->photo && file_exists(storage_path('app/public/' . $barber->photo))) {
            unlink(storage_path('app/public/' . $barber->photo));
        }

        $barber->delete();

        return redirect()->route('barbers.index')->with('success', 'Barbero eliminado exitosamente.');
    }
}

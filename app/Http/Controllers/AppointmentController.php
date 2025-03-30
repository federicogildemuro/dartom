<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Define date and ascending sort as default values for the sorting options
        $sortColumn = $request->get('sort', 'date');
        $sortDirection = $request->get('direction', 'asc');

        // Validate the sorting direction to ensure it's either 'asc' or 'desc'
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; // Default sort direction is 'asc' if invalid direction 
        }

        // Validate the sorting column to ensure it is one of the allowed columns
        $allowedColumns = ['barber_id', 'user_id', 'date'];
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 'date'; // Default sort column is 'date' if invalid column
        }

        // Fetch all barbers and users for the filter options
        $barbers = Barber::all();
        $users = User::all();

        // Start the query to fetch appointments
        $appointments = Appointment::query();

        // Apply filters if provided
        if ($request->filled('barber_id')) {
            $appointments->where('barber_id', $request->barber_id);
        }
        if ($request->filled('user_id')) {
            $appointments->where('user_id', $request->user_id);
        }
        if ($request->filled('date')) {
            $appointments->whereDate('date', $request->date);
        }

        // If the request has the 'show_all' parameter set to 1, show all appointments
        if ($request->has('show_all') && $request->show_all == 1) {
            $appointments = $appointments->orderBy($sortColumn, $sortDirection)
                ->orderBy('date', 'asc') // Default secondary sort by 'date'
                ->orderBy('time', 'asc') // Default tertiary sort by 'time'
                ->paginate(10); // Paginate the results
        } else {
            // Otherwise, get only the appointments that have a date greater than or equal to today
            $appointments = $appointments->where('date', '>=', Carbon::today())
                ->orderBy($sortColumn, $sortDirection)
                ->orderBy('date', 'asc') // Default secondary sort by 'date'
                ->orderBy('time', 'asc') // Default tertiary sort by 'time'
                ->paginate(10); // Paginate the results
        }

        // Return the view with the data
        return view('appointments.index', compact('appointments', 'barbers', 'users', 'sortColumn', 'sortDirection'));
    }

    // Show the form for creating appointments
    public function create()
    {
        $barbers = Barber::all();
        return view('appointments.create', compact('barbers'));
    }

    // Store a newly created appointment in the database
    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
        ]);

        $barberId = $request->barber_id;
        $date = $request->date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        $start = Carbon::createFromFormat('Y-m-d H:i', "$date $startTime");
        $end = Carbon::createFromFormat('Y-m-d H:i', "$date $endTime");

        // Array to store the appointments to be created
        $appointments = [];
        // Create an appointment for each 30 minute interval between the start and end time
        while ($start <= $end) {
            $appointments[] = [
                'barber_id' => $barberId,
                'date' => $start->toDateString(),
                'time' => $start->toTimeString(),
            ];
            // Increment the time by 30 minutes
            $start->addMinutes(30);
        }

        // Insert all the appointments into the database
        Appointment::insert($appointments);

        return redirect()->route('appointments.index')->with('success', 'Turnos creados exitosamente.');
    }

    // Show the form for editing an existing appointment
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $barbers = Barber::all();
        return view('appointments.edit', compact('appointment', 'barbers'));
    }

    // Update the specified appointment in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'time' => 'required|date_format:H:i',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'barber_id' => $request->barber_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Turno actualizado exitosamente.');
    }

    // Delete the specified appointment from the database
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Turno eliminado exitosamente.');
    }

    public function availableAppointments(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user already has an appointment
        $existingAppointment = Appointment::where('user_id', $user->id)
            ->where('date', '>=', Carbon::today())
            ->first();

        // If the user already has an appointment, show the existing appointment
        if ($existingAppointment) {
            return view('appointments.available', compact('existingAppointment'));
        }

        // Define date and ascending sort as default values for the sorting options
        $sortColumn = $request->get('sort', 'date');
        $sortDirection = $request->get('direction', 'asc');

        // Validate the sorting direction to ensure it's either 'asc' or 'desc'
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc'; // Default sort direction is 'asc' if invalid direction 
        }

        // Validate the sorting column to ensure it is one of the allowed columns
        $allowedColumns = ['barber_id', 'date'];
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 'date'; // Default sort column is 'date' if invalid column
        }

        // Fetch all barbers for the filter options
        $barbers = Barber::all();

        // Start the query to fetch available appointments
        $availableAppointments = Appointment::query()
            ->whereNull('user_id')
            ->where('date', '>=', Carbon::today());

        // Apply filters if provided
        if ($request->filled('barber_id')) {
            $availableAppointments->where('barber_id', $request->barber_id);
        }
        if ($request->filled('date')) {
            $availableAppointments->whereDate('date', $request->date);
        }

        // Order the appointments and apply pagination
        $availableAppointments = $availableAppointments
            ->orderBy($sortColumn, $sortDirection)
            ->orderBy('date', 'asc') // Default secondary sort by 'date'
            ->orderBy('time', 'asc') // Default tertiary sort by 'time'
            ->paginate(10); // Paginate the results

        // Return the view with the available appointments and filters
        return view('appointments.available', compact('availableAppointments', 'barbers', 'sortColumn', 'sortDirection'));
    }

    public function bookAppointment($id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user already has an appointment
        if (Appointment::where('user_id', $user->id)->where('date', '>=', Carbon::today())->exists()) {
            return redirect()->route('appointments.available')->with('error', 'Ya tienes un turno vigente.');
        }

        // Find the appointment by ID and lock it for update
        $appointment = Appointment::where('id', $id)->whereNull('user_id')->lockForUpdate()->first();

        // If the appointment is not found or already taken, show an error message
        if (!$appointment) {
            return redirect()->route('appointments.available')->with('error', 'El turno ya fue tomado.');
        }

        $appointment->user_id = $user->id;
        $appointment->save();

        return redirect()->route('appointments.available')->with('success', 'Turno reservado exitosamente.');
    }

    public function cancelAppointment()
    {
        $user = Auth::user();

        $appointment = Appointment::where('user_id', $user->id)
            ->where('date', '>=', Carbon::today())
            ->first();

        if (!$appointment) {
            return redirect()->route('appointments.available')->with('error', 'No tienes turnos para cancelar.');
        }

        $appointment->user_id = null;
        $appointment->save();

        return redirect()->route('appointments.available')->with('success', 'Turno cancelado exitosamente.');
    }

    public function showHistory()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch the user's appointment history
        $appointments = Appointment::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('appointments.history', compact('appointments'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReserved;
use App\Mail\AppointmentCanceled;

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
        // Otherwise, show only future appointments
        if ($request->has('show_all') && $request->show_all == 1) {
            $appointments = $appointments->orderBy($sortColumn, $sortDirection)
                ->orderBy('date', 'asc') // Default secondary sort by 'date'
                ->orderBy('time', 'asc') // Default tertiary sort by 'time'
                ->paginate(10); // Paginate the results
        } else {
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
        // Fetch all barbers for the dropdown
        $barbers = Barber::all();

        // Return the view with the barbers data
        return view('appointments.create', compact('barbers'));
    }

    // Store the newly created appointments in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
        ]);

        // Get the barber ID, date, start time, and end time from the request
        $barberId = $request->barber_id;
        $date = $request->date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        // Create Carbon instances for the start and end times
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

        // Redirect to the appointments index with a success message
        return redirect()->route('appointments.index')->with('success', 'Turnos creados exitosamente.');
    }

    // Show the form for editing an existing appointment
    public function edit($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Fetch all barbers for the dropdown
        $barbers = Barber::all();

        // Return the edit view with the appointment and barbers data
        return view('appointments.edit', compact('appointment', 'barbers'));
    }

    // Update the specified appointment in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
            'time' => 'required|date_format:H:i',
        ]);

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Update the appointment with the new data
        $appointment->update([
            'barber_id' => $request->barber_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        // Redirect to the appointments index with a success message
        return redirect()->route('appointments.index')->with('success', 'Turno actualizado exitosamente.');
    }

    // Delete the specified appointment from the database
    public function destroy($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Delete the appointment record
        $appointment->delete();

        // Redirect to the appointments index with a success message
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

        // If the user already has an appointment, show an error message
        if (Appointment::where('user_id', $user->id)->where('date', '>=', Carbon::today())->exists()) {
            return redirect()->route('appointments.available')->with('error', 'Ya tienes un turno vigente.');
        }

        // Find the appointment by ID and lock it for update
        $appointment = Appointment::where('id', $id)->whereNull('user_id')->lockForUpdate()->first();
        // If the appointment is not found or already taken, show an error message
        if (!$appointment) {
            return redirect()->route('appointments.available')->with('error', 'El turno ya fue tomado.');
        }

        // Assign the user to the appointment and save it
        $appointment->user_id = $user->id;
        $appointment->save();

        // Get the barber associated with the appointment
        $barber = Barber::find($appointment->barber_id);
        // Send confirmation email to the user
        Mail::to($user->email)->send(new AppointmentReserved($appointment, $user, $barber));

        // Redirect to the available appointments page with a success message
        return redirect()->route('appointments.available')->with('success', 'Turno reservado exitosamente.');
    }

    public function cancelAppointment()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has an appointment
        $appointment = Appointment::where('user_id', $user->id)
            ->where('date', '>=', Carbon::today())
            ->first();
        // If the user doesn't have an appointment, show an error message
        if (!$appointment) {
            return redirect()->route('appointments.available')->with('error', 'No tienes turnos para cancelar.');
        }

        // Get the barber associated with the appointment
        $barber = Barber::find($appointment->barber_id);
        // Send cancellation email to the user
        Mail::to($user->email)->send(new AppointmentCanceled($appointment, $user, $barber));

        // Cancel the appointment by setting the user_id to null and saving it
        $appointment->user_id = null;
        $appointment->save();

        // Redirect to the available appointments page with a success message
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

        // Return the view with the appointment history
        return view('appointments.history', compact('appointments'));
    }
}

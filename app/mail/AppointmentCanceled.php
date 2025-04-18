<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Barber;

class AppointmentCanceled extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $user;
    public $barber;

    public function __construct(Appointment $appointment, User $user, Barber $barber)
    {
        $this->appointment = $appointment;
        $this->user = $user;
        $this->barber = $barber;
    }

    public function build()
    {
        return $this->subject('Cancelación de turno')
            ->view('emails.appointment_canceled');
    }
}

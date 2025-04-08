<h2>Tu turno fue reservado</h2>
<p>Hola {{ $user->name }},</p>
<p>Reservaste un turno con {{ $barber->name }} para el día
    {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }} a
    las {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}.</p>
<p>Gracias por elegir Barbería Dartom.</p>
<p>Si tenés alguna pregunta, no dudes en contactarnos.</p>
<p>Saludos,</p>
<p>El equipo de Barbería Dartom</p>

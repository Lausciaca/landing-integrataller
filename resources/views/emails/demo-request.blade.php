<h1>Nueva solicitud de demo</h1>

<p><strong>Nombre:</strong> {{ $contact->name }}</p>
<p><strong>Taller:</strong> {{ $contact->taller }}</p>
<p><strong>Email:</strong> {{ $contact->email }}</p>
<p><strong>Teléfono:</strong> {{ $contact->phone }}</p>
<p><strong>Consulta:</strong> {{ $contact->message ?: 'Sin comentario adicional.' }}</p>
<p><strong>Pidió recibir novedades:</strong> {{ $contact->marketing_opt_in_requested ? 'Sí; falta confirmar el email.' : 'No.' }}</p>

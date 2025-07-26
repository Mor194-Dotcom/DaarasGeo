<h2>Alerte déclenchée</h2>
<p>Bonjour {{ $destinataire->prenom }},</p>
<p>Un Talibé est sorti de sa zone de sécurité.</p>

<ul>
    <li><strong>Nom :</strong>
        {{ $alerte->utilisateur->prenom ?? 'Talibé inconnu' }} {{ $alerte->utilisateur->nom ?? 'daaratal' }}</li>
    <li><strong>Distance :</strong> {{ number_format($alerte->distance, 2) }} m</li>
    <li><strong>Date :</strong> {{ \Carbon\Carbon::parse($alerte->date)->format('d/m/Y à H:i') }}</li>
</ul>

<p>Connectez-vous à la plateforme pour suivre la situation.</p>

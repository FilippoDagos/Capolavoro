<?php
// Ricevi l'username dal parametro POST
$username = $_POST['user'];

// Esegui la logica per verificare se l'username è disponibile o meno
// Supponiamo che tu abbia una funzione o un'istruzione SQL per verificare l'username nel database

// Esempio: verifica se l'username è disponibile
$isAvailable = true; // Assumiamo che l'username sia disponibile

// Restituisci una risposta JSON
header('Content-Type: application/json');
echo json_encode(['available' => $isAvailable]);
?>

<?php 
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';

$heading = "Paesi";

header('Content-Type: application/json');

// Inizializza l'array di risposta
$response = [
    'success' => false,
    'message' => ''
];

try {

    $pdo = Connection::make($config['database']);

    // Inizia la transazione
    $pdo->beginTransaction();
    // Se arriviamo qui, significa che la connessioneè avvenuta con successo!
    $statement = $pdo->query("SELECT * FROM paesi ORDER BY nome_paese");
    $paesi = $statement->fetchAll();


    // Commit della transazione
    $pdo->commit();

    http_response_code(200); // OK

    $response['success'] = true;
    $response['message'] = "Paesi recuperati con successo!";
    $response['paesi'] = $paesi;



} catch (Exception $e) {
    // Gestione dell'errore nel recupero dei paesi.
    // Logga l'errore per il debug, ma non interrompere l'esecuzione se la vista possono gestirlo.
    http_response_code(500); // Internal Server Error
    error_log("Errore nel recupero dei paesi per la vista: " . $e->getMessage());
    $paesi = []; // Assicurati che $paesi sia un array vuoto in caso di errore.
}

// Stampa la risposta JSON
echo json_encode($response);

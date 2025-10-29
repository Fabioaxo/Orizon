<?php


header('Content-Type: application/json');

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';

// Inizializza l'array di risposta
$response = [
    'success' => false,
    'message' => ''
];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Metodo non consentito
    $response['message'] = "Metodo non consentito. Usa POST per aggiungere un paese.";
    echo json_encode($response);
    exit;
}
    try {
    $pdo = Connection::make($config['database']);

    // Usa i dati JSON come fallback se non ci sono dati POST tradizionali
    $paese = $_POST['paese'] ?? $input['paese'] ?? null;

    // Validazione base dei dati
    if (!$paese) {
        http_response_code(400); // Bad Request
        $response['message'] = "Errore: dati del form incompleti o non validi.";
        echo json_encode($response);
        exit;
    }

    // Inizia la transazione
    $pdo->beginTransaction();

    // Query per inserire il viaggio
    $sql_paese = "INSERT INTO paesi (nome_paese) VALUES (:paese)";
    $statement_paese = $pdo->prepare($sql_paese);
    $statement_paese->execute([
        ':paese' => $paese
    ]);

    // Commit della transazione
    $pdo->commit();

    // Prepara la risposta di successo
    http_response_code(201); // Created
    $response['success'] = true;
    $response['message'] = "Paese creato con successo!";
    $response['paese'] = $paese;

} catch (Exception $e) {
    // In caso di errore, fai il rollback della transazione
    $pdo->rollBack();
    // Gestisce l'errore e imposta la risposta appropriata
    http_response_code(500); // Internal Server Error
    $response['message'] = "Errore durante la creazione del paese: " . $e->getMessage();
    error_log("Errore nel salvataggio del paese: " . $e->getMessage());
}

// Stampa la risposta JSON
echo json_encode($response);
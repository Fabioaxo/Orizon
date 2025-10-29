<?php
// Includi i file di configurazione e connessione
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';

header('Content-Type: application/json');



// Inizializza l'array di risposta
$response = [
    'success' => false,
    'message' => ''
];

// L'API risponde solo alle richieste POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Metodo non consentito
    $response['message'] = "Metodo non consentito. Usa POST per creare un viaggio.";
    echo json_encode($response);
    exit;
}

try {
    $pdo = Connection::make($config['database']);
    // Usa i dati JSON come fallback se non ci sono dati POST tradizionali
    $nome_del_viaggio = $_POST['nome_del_viaggio'] ?? $input['nome_del_viaggio'] ?? null;
    $numero_posti_disponibili = $_POST['numero_posti_disponibili'] ?? $input['numero_posti_disponibili'] ?? null;
    $paesi_selezionati_ids = $_POST['paesi'] ?? $input['paesi'] ?? [];

    // Validazione base dei dati
    if (!$nome_del_viaggio || $numero_posti_disponibili <= 0 || empty($paesi_selezionati_ids)) {
        http_response_code(400); // Bad Request
        $response['message'] = "Errore: dati del form incompleti o non validi.";
        echo json_encode($response);
        exit;
    }

    // Inizia la transazione
    $pdo->beginTransaction();

    // Query per inserire il viaggio
    $sql_viaggio = "INSERT INTO viaggi (nome_del_viaggio, numero_posti_disponibili) VALUES (:nome_del_viaggio, :numero_posti_disponibili)";
    $statement_viaggio = $pdo->prepare($sql_viaggio);
    $statement_viaggio->execute([
        ':nome_del_viaggio' => $nome_del_viaggio,
        ':numero_posti_disponibili' => $numero_posti_disponibili
    ]);

    $viaggio_id = $pdo->lastInsertId();

    // Query per inserire le relazioni con i paesi
    $sql_viaggi_paesi = "INSERT INTO viaggi_paesi (viaggio_id, paese_id) VALUES (:viaggio_id, :paese_id)";
    $statement_viaggi_paesi = $pdo->prepare($sql_viaggi_paesi);

    foreach ($paesi_selezionati_ids as $paese_id) {
        $statement_viaggi_paesi->execute([
            ':viaggio_id' => $viaggio_id,
            ':paese_id' => $paese_id
        ]);
    }

    // Se tutto va bene, esegui il commit
    $pdo->commit();

    // Prepara la risposta di successo
    http_response_code(201); // Created
    $response['success'] = true;
    $response['message'] = "Viaggio creato con successo!";
    $response['viaggio_id'] = $viaggio_id;

} catch (Exception $e) {
    // In caso di errore, fai il rollback della transazione
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Gestisce l'errore e imposta la risposta appropriata
    http_response_code(500); // Internal Server Error
    $response['message'] = "Errore durante la creazione del viaggio: " . $e->getMessage();
    error_log("Errore nel salvataggio del viaggio: " . $e->getMessage());

} finally {
    // Stampa la risposta JSON
    echo json_encode($response);
}
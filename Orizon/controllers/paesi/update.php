<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';

// 1. Imposta l'header per la risposta JSON PRIMA DI QUALSIASI OUTPUT (inclusi errori!)
header('Content-Type: application/json');

// Funzione di utilità per inviare la risposta ed uscire
function sendJsonResponse(int $httpCode, array $responseData) {
    http_response_code($httpCode);
    echo json_encode($responseData);
    exit;
}
$raw_json_input = file_get_contents('php://input');
$data = json_decode($raw_json_input, true);

// 2. Controllo del metodo HTTP (Opzionale ma Raccomandato per un vero endpoint REST)
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    $response = ['success' => false, 'message' => 'Metodo non consentito. Questo endpoint accetta solo richieste DELETE.'];
    sendJsonResponse(405, $response); // Method Not Allowed
}

$id_paese = $data['id_paese'];
$nome_paese = $data['nome_paese'];
// 3. RECUPERO E VALIDAZIONE DELL'ID
// L'ID viene generalmente estratto dal parametro di query per semplicità,
// ma in un vero router verrebbe estratto dal percorso URL (/paesi/{id}).
if (!isset($_GET['id_paese']) || !is_numeric($_GET['id_paese'])) {
    $response = ['success' => false, 'message' => "ID Paese mancante o non valido nella richiesta."];
    sendJsonResponse(400, $response); // Bad Request
}
try {
    // 4. Connessione al database
    // DEVI ASSICURARTI CHE LA TUA LOGICA DI CONNESSIONE SIA DISPONIBILE QUI
    // ESEMPIO (sostituisci con la tua logica Connection::make()):
    $pdo = Connection::make($config['database']); 

    // --- AGGIORNAMENTO DEL PAESE (Prepared Statements) ---
    $sql_paese = "UPDATE paesi SET nome_paese = :nome_paese WHERE id_paese = :id_paese";
    $statement_paese = $pdo->prepare($sql_paese);
    
    $statement_paese->bindParam(':id_paese', $id_paese, PDO::PARAM_INT);
    $statement_paese->bindParam(':nome_paese', $nome_paese, PDO::PARAM_STR);
    $statement_paese->execute();
    
    // 5. Verifica l'esito
    $row_count = $statement_paese->rowCount();

    if ($row_count === 0) {
        $response = ['success' => false, 'message' => "Paese con ID {$id_paese} non trovato. Nessun aggiornamento eseguito."];
        sendJsonResponse(404, $response); // Not Found
    }

    // --- RISPOSTA DI SUCCESSO ---
    $response = [
        'success' => true,
        'message' => "Paese aggiornato con successo.",
    ];
    sendJsonResponse(200, $response); // OK

} catch (PDOException $e) {
    // Errore DB
    $response = ['success' => false, 'message' => "Errore del database: " . $e->getMessage()];
    error_log("DB Error UPDATE paese [ID: {$id_paese}]: " . $e->getMessage());
    sendJsonResponse(500, $response); // Internal Server Error

} catch (Exception $e) {
    // Errore Generico
    $response = ['success' => false, 'message' => "Errore del server: " . $e->getMessage()];
    error_log("General Error UPDATE paese [ID: {$id_paese}]: " . $e->getMessage());
    sendJsonResponse(500, $response); // Internal Server Error
}


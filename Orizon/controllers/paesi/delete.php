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

// 2. Controllo del metodo HTTP (Opzionale ma Raccomandato per un vero endpoint REST)
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response = ['success' => false, 'message' => 'Metodo non consentito. Questo endpoint accetta solo richieste DELETE.'];
    sendJsonResponse(405, $response); // Method Not Allowed
}


// 3. RECUPERO E VALIDAZIONE DELL'ID
// L'ID viene generalmente estratto dal parametro di query per semplicità,
// ma in un vero router verrebbe estratto dal percorso URL (/paesi/{id}).
if (!isset($_GET['id_paese']) || !is_numeric($_GET['id_paese'])) {
    $response = ['success' => false, 'message' => "ID Paese mancante o non valido nella richiesta."];
    sendJsonResponse(400, $response); // Bad Request
}

$id_paese = (int)$_GET['id_paese'];
$nome_paese = $_GET['nome_paese']; 


try {
    //Connessione al database
    $pdo = Connection::make($config['database']); 

    // --- CANCELLAZIONE DEL PAESE (Prepared Statements) ---
    $sql_paese = "DELETE FROM paesi WHERE id_paese = :id_paese";
    $statement_paese = $pdo->prepare($sql_paese);
    
    $statement_paese->bindParam(':id_paese', $id_paese, PDO::PARAM_INT);
    $statement_paese->execute();
    
    // 5. Verifica l'esito
    $row_count = $statement_paese->rowCount();

    if ($row_count === 0) {
        $response = ['success' => false, 'message' => "Paese con ID {$id_paese} non trovato. Nessuna cancellazione eseguita."];
        sendJsonResponse(404, $response); // Not Found
    }

    // --- CANCELLAZIONE DEI VIAGGI ORFANi (opzionale) ---
    $sql_viaggio_orfano = "DELETE FROM viaggi WHERE id_viaggio NOT IN (SELECT viaggio_id FROM viaggi_paesi)";
    $statement_elimina_viaggio = $pdo->query($sql_viaggio_orfano);
    $orphans_deleted = $statement_elimina_viaggio->rowCount();
    
    // --- RISPOSTA DI SUCCESSO ---
    $response = [
        'success' => true,
        'message' => "Paese {$nome_paese} cancellato con successo. Eliminati {$orphans_deleted} viaggi senza paese.",
        'data' => ['id_cancellato' => $id_paese, 'viaggi_orfani_eliminati' => $orphans_deleted]
    ];
    
    sendJsonResponse(200, $response); // OK

} catch (PDOException $e) {
    // Errore DB
    $response = ['success' => false, 'message' => "Errore del database: " . $e->getMessage()];
    error_log("DB Error DELETE paese [ID: {$id_paese}]: " . $e->getMessage());
    sendJsonResponse(500, $response); // Internal Server Error

} catch (Exception $e) {
    // Errore Generico
    $response = ['success' => false, 'message' => "Errore del server: " . $e->getMessage()];
    error_log("General Error DELETE paese [ID: {$id_paese}]: " . $e->getMessage());
    sendJsonResponse(500, $response); // Internal Server Error
}

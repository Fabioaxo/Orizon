<?php 
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';
// La tua logica di connessione al database va qui.
$pdo = Connection::make($config['database']);

function sendJsonResponse(int $httpCode, array $responseData) {
    http_response_code($httpCode);
    echo json_encode($responseData);
    exit;
}

$id_viaggio = $_GET['id_viaggio'];

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    $response = ['success' => false, 'message' => 'Metodo non consentito. Questo endpoint accetta solo richieste DELETE.'];
    sendJsonResponse(405, $response); // Method Not Allowed
}

if (!isset($_GET['id_viaggio']) || !is_numeric($_GET['id_viaggio'])) {
    $response = ['success' => false, 'message' => "ID Viaggio mancante o non valido nella richiesta."];
    sendJsonResponse(400, $response); // Bad Request
}

try {
    
    if ($id_viaggio) {
        // Prepara la query
        $sql = "DELETE FROM viaggi WHERE id_viaggio = :id_viaggio";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_viaggio', $id_viaggio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Viaggio eliminato con successo.'];
            sendJsonResponse(200, $response); // OK

        } else {
              $row_count = $stmt->rowCount();
                  if ($row_count === 0) {
                         $response = ['success' => false, 'message' => "Paese con ID {$id_viaggio} non trovato. Nessuna cancellazione eseguita."];
                         sendJsonResponse(404, $response); // Not Found
                                        }
        }
    } 
} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Errore database: ' . $e->getMessage()];
     sendJsonResponse(500, $response); // Internal Server Error
}
?>
<?php 
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';

$heading = "Viaggio";

header('Content-Type: application/json');
// Inizializza l'array di risposta
$response = [
    'success' => false,
    'message' => ''
];
function sendJsonResponse(int $httpCode, array $responseData) {
    http_response_code($httpCode);
    echo json_encode($responseData);
    exit;
}
$id_viaggio = $idViaggio;


try {

    $pdo = Connection::make($config['database']);

    $pdo->beginTransaction();

    $sql = "SELECT viaggi.nome_del_viaggio, viaggi.numero_posti_disponibili,viaggi.id_viaggio, paesi.nome_paese FROM viaggi
    LEFT JOIN viaggi_paesi ON viaggi.id_viaggio = viaggi_paesi.viaggio_id
    LEFT JOIN paesi ON viaggi_paesi.paese_id = paesi.id_paese
     WHERE id_viaggio = :id_viaggio";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_viaggio', $id_viaggio, PDO::PARAM_INT);
    $stmt->execute();

    $viaggio = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $viaggioDettagli = [];
    $paesi_aggiunti = [];

    if (count($viaggio) > 0) {
        $prima_riga = $viaggio[0];

        $viaggioDettagli = [
            'nome_del_viaggio' => $prima_riga['nome_del_viaggio'],
            'numero_posti_disponibili' => $prima_riga['numero_posti_disponibili'],
            'paesi' =>[],
            'id_viaggio' => $prima_riga['id_viaggio']
        ];
        
        foreach ($viaggio as $riga) {
         
            $nome_paese = $riga['nome_paese'];
            if (!in_array($nome_paese, $paesi_aggiunti)) {
                $viaggioDettagli['paesi'][] = $nome_paese;
                $paesi_aggiunti[] = $nome_paese;
            }
        }
    }

    if (!$viaggio) {
        $response = ['success' => false, 'message' => "Viaggio con ID {$id_viaggio} non trovato."];
        sendJsonResponse(404, $response); // Not Found
    }

    $response = [
        'success' => true,
        'message' => "Viaggio trovato con successo.",
        'data' => $viaggioDettagli
    ];
    sendJsonResponse(200, $response); // OK

} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Errore database: ' . $e->getMessage()];
    sendJsonResponse(500, $response); // Internal Server Error

}

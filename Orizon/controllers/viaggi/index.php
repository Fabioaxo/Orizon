<?php 
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../../database/QueryBuilder.php';
$heading = "Viaggi";
header('Content-Type: application/json');
// Inizializza l'array di risposta
$response = [
    'success' => false,
    'message' => ''
];
try {
    $pdo = Connection::make($config['database']);
    $pdo->beginTransaction();
    $sql = "SELECT viaggi.nome_del_viaggio, viaggi.numero_posti_disponibili,viaggi.id_viaggio
    ,GROUP_CONCAT(paesi.nome_paese SEPARATOR ', ') AS nome_paese
    FROM viaggi
    LEFT JOIN viaggi_paesi ON viaggi.id_viaggio = viaggi_paesi.viaggio_id
    LEFT JOIN paesi ON viaggi_paesi.paese_id = paesi.id_paese
    GROUP BY viaggi.id_viaggio, viaggi.nome_del_viaggio, viaggi.numero_posti_disponibili";    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $viaggi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $viaggioDettagli = [];

    foreach ($viaggi as $viaggio) {
        $paesi_array = explode(',', $viaggio['nome_paese']);
        $paesi_array = array_map('trim', $paesi_array);
        $viaggioDettagli[] = [
            'nome_del_viaggio' => $viaggio['nome_del_viaggio'],
            'numero_posti_disponibili' => $viaggio['numero_posti_disponibili'],
            'paesi' => $paesi_array,
            'id_viaggio' => $viaggio['id_viaggio']
        ];
    }
    // // Inizia la transazione
    // $pdo->beginTransaction();
    // // Se arriviamo qui, significa che la connessioneè avvenuta con successo!
    // $statement = $pdo->query("SELECT * FROM viaggi ORDER BY numero_posti_disponibili DESC");
    // $viaggi = $statement->fetchAll();


    // Commit della transazione
    $pdo->commit();

    http_response_code(200); // OK
    $response['success'] = true;
    $response['message'] = "Dati viaggi recuperati con successo.";
    $response['viaggi'] = $viaggioDettagli;
    echo json_encode($response);
} catch (Exception $e) {
    // Se si verifica un errore, annulla la transazione
    $pdo->rollBack();
    http_response_code(500); // Internal Server Error
    $response['message'] = "Errore nel recupero dei viaggi: " . $e->getMessage();
    echo json_encode($response);
}
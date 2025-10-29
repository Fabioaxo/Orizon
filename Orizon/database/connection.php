<?php

/**
 * Classe per la gestione della connessione al database tramite PDO.
 */
class Connection
{
    /**
     * Crea e restituisce un'istanza PDO per la connessione al database.
     *
     * @param array $config Un array associativo contenente i dettagli di configurazione del database.
     * Deve includere le chiavi 'connection', 'name', 'username', 'password'.
     * @return PDO L'istanza PDO connessa al database.
     * @throws PDOException Se la connessione al database fallisce.
     */
    public static function make($config)
    {
        try {
            // Estrae i dettagli di connessione dall'array di configurazione
            $dsn = $config['connection'] . ';dbname=' . $config['name'];
            $username = $config['username'];
            $password = $config['password'];

            // Crea una nuova istanza PDO
            // Imposta l'attributo ATTR_ERRMODE su ERRMODE_EXCEPTION per far sì che PDO lanci eccezioni in caso di errori
            // Imposta ATTR_DEFAULT_FETCH_MODE su FETCH_ASSOC per recuperare i risultati come array associativi di default
            return new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            // Cattura l'eccezione PDOException in caso di errore di connessione
            // Stampa un messaggio di errore e termina lo script
            // In un ambiente di produzione, dovresti loggare l'errore e mostrare un messaggio generico all'utente
            die('Impossibile connettersi al database: ' . $e->getMessage());
        }
    }
}

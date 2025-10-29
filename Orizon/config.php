<?php

/**
 * File di configurazione per l'applicazione Orizon.
 * Contiene le impostazioni per il database e altre configurazioni globali.
 */

$config = [
    // Sezione di configurazione del database
    'database' => [
        // Tipo di connessione e host:
        // 'mysql:host=127.0.0.1' è l'indirizzo IP standard per localhost.
        // Puoi anche usare 'mysql:host=localhost' se preferisci.
        // Se il tuo MySQL/MariaDB usa una porta diversa da 3306, puoi specificarla:
        // es. 'mysql:host=127.0.0.1;port=3307'
        'connection' => 'mysql:host=127.0.0.1',

        // Nome del database a cui connettersi.
        // Assicurati che questo database esista sul tuo server MySQL/MariaDB.
        'name' => 'orizon', // Sostituisci con il nome effettivo del tuo database

        // Username per la connessione al database.
        // Per XAMPP/WAMP, 'root' è l'username predefinito.
        'username' => 'root',

        // Password per la connessione al database.
        // Per XAMPP/WAMP, la password è spesso una stringa vuota ('').
        // Se hai impostato una password per il tuo utente MySQL, inseriscila qui.
        'password' => '',

        // Opzioni aggiuntive per la connessione PDO (facoltative ma consigliate).
        // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION: Fa sì che PDO lanci eccezioni
        // in caso di errori SQL, rendendo la gestione degli errori più robusta.
        // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC: Imposta il recupero predefinito
        // dei risultati delle query come array associativi (chiavi = nomi colonne).
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    // Puoi aggiungere altre sezioni di configurazione qui, ad esempio:
    // 'app' => [
    //     'name' => 'Orizon Viaggi App',
    //     'environment' => 'development', // o 'production'
    // ],
    // 'paths' => [
    //     'views' => __DIR__ . '/view/',
    //     'controllers' => __DIR__ . '/controllers/',
    // ]
];

?>

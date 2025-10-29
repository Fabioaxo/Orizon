<h1></h1>
      <header>
            <h1>🌍 Orizon: Viaggi Esotici ed Ecosostenibili</h1>
            <p>Benvenuto nel repository di Orizon, un'applicazione web sviluppata in PHP nativo.</p>
        </header>
        <section>
            <h2>🌟 Caratteristiche Principali</h2>
            <p>Questo progetto utilizza un'architettura MVC (Model-View-Controller) semplificata, gestisce il routing dinamico e interagisce con un database MySQL per la persistenza dei dati.</p>
            <ul>
                <li><strong>Routing Dinamico:</strong> Utilizzo di una classe <code>Router</code> (in <code>router.php</code>) per gestire le richieste GET, POST, PUT, PATCH e DELETE.</li>
                <li><strong>Gestione Database:</strong> Interazione diretta con il database tramite <strong>PDO</strong> e la classe <code>Connection</code> per eseguire query SQL.</li>
                <li><strong>Operazioni CRUD:</strong> Supporto completo per la gestione (creazione, lettura, aggiornamento, eliminazione) di Viaggi e Paesi.</li>
                <li><strong>Destinazioni Tematiche:</strong> Focus su viaggi esotici e sostenibili.</li>
            </ul>
        </section>
        <section>
            <h2>⚙️ Configurazione e Avvio del Progetto</h2>
            <p>Segui questi passaggi per configurare e avviare il progetto sul tuo ambiente locale (es. XAMPP o WAMP).</p>
            <h3>1. Requisiti</h3>
            <ul>
                <li>Server Web (es. Apache, incluso in XAMPP/WAMP)</li>
                <li>PHP (versione 8.x consigliata)</li>
                <li>Database MySQL/MariaDB (incluso in XAMPP/WAMP)</li>
            </ul>
            <h3>2. Preparazione del Database</h3>
            <p>Il progetto richiede un database e tre tabelle (<code>paesi</code>, <code>viaggi</code> e <code>viaggi_paesi</code>).</p>
            <ol>
                <li><strong>Crea il Database:</strong> Apri <code>phpMyAdmin</code> o un altro client MySQL. Crea un nuovo database chiamato <code>orizon</code>. (Questo nome è specificato in <code>config.php</code>).</li>
                <li><strong>Importa lo Schema:</strong> Importa il file <code>orizon.sql</code> nel database appena creato. Questo popolerà le tabelle con gli schemi e i dati iniziali.</li>
            </ol>
            <h3>3. Configurazione dell'Applicazione</h3>
            <ol start="3">
                <li><strong>Aggiorna <code>config.php</code>:</strong> Apri il file <code>config.php</code>. Verifica che le credenziali del database (nome, username e password) siano corrette per il tuo ambiente:
<pre><code>// Da verificare/modificare se non usi le impostazioni predefinite di XAMPP/WAMP
'name' => 'orizon', 
'username' => 'root', // L'utente predefinito
'password' => '',     // La password predefinita (spesso vuota)</code></pre>
                </li>
            </ol>
            <h3>4. Esecuzione</h3>
            <ol start="4">
                <li>Assicurati che Apache e MySQL siano avviati nel tuo pannello di controllo XAMPP/WAMP.</li>
                <li>Carica i file del progetto nella directory radice del tuo server web (es. <code>htdocs</code> per XAMPP).</li>
                <li>Apri il tuo browser e naviga verso l'URL del progetto:
<pre><code>http://localhost/Orizon/</code></pre>
                </li>
                <li>Per visualizzare l'applicazione analitica interattiva:
<pre><code>http://localhost/Orizon/orizon_explorer.html</code></pre>
                </li>
            </ol>
        </section>
        <section>
            <h2>📂 Struttura delle Directory (Semplificata)</h2>
            <p>La struttura del progetto è organizzata come segue:</p>
            <pre><code>Orizon/
├── orizon_explorer.html     # Applicazione analitica interattiva (solo frontend).
├── bootstrap.php            # Carica la configurazione e le dipendenze iniziali.
├── config.php               # Impostazioni di configurazione (DB, ecc.).
├── index.php                # Punto di ingresso dell'applicazione.
├── router.php               # La classe Router che gestisce le rotte.
├── functions.php            # Funzioni helper globali (es. `dd`).
├── database/                # Logica di connessione al DB.
│   └── Connection.php       # Classe per la connessione PDO.
├── controllers/             # La logica (Controller) delle richieste.
│   ├── paesi/               # Logica per i Paesi.
│   └── viaggi/              # Logica per i Viaggi.
└── view/                    # I file delle viste (l'HTML).
    ├── 404.php              # Pagina di errore.
    ├── paesi/
    ├── viaggi/
    └── partials/            # Componenti riutilizzabili (header, footer, nav).</code></pre>
        </section>
        <section>
            <h2>🧭 Rotte Principali (API e View)</h2>
            <p>Il file <code>router.php</code> definisce tutte le rotte. Le rotte che restituiscono dati JSON sono utilizzate per le chiamate AJAX dell'applicazione, mentre le altre sono per le visualizzazioni HTML.</p>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Metodo</th>
                            <th>Descrizione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><code>/</code></td><td><code>GET</code></td><td>Homepage.</td></tr>
                        <tr><td><code>/info</code></td><td><code>GET</code></td><td>Pagina 'Info/Storia'.</td></tr>
                        <tr><td><code>/paesi</code></td><td><code>GET</code></td><td>Vista della lista Paesi.</td></tr>
                        <tr><td><code>/paesi-json</code></td><td><code>GET</code></td><td><strong>API:</strong> Recupera la lista di tutti i paesi.</td></tr>
                        <tr><td><code>/paesi-create</code></td><td><code>GET</code> / <code>POST</code></td><td>Vista e Logica per la creazione di un nuovo Paese.</td></tr>
                        <tr><td><code>/paesi-delete-json</code></td><td><code>DELETE</code></td><td><strong>API:</strong> Cancella un paese specifico.</td></tr>
                        <tr><td><code>/paesi-update-json</code></td><td><code>PUT</code></td><td><strong>API:</strong> Modifica un paese specifico.</td></tr>
                        <tr><td><code>/viaggi</code></td><td><code>GET</code></td><td>Vista della lista Viaggi.</td></tr>
                        <tr><td><code>/viaggi-json</code></td><td><code>GET</code></td><td><strong>API:</strong> Recupera la lista di tutti i viaggi (con paesi associati).</td></tr>
                        <tr><td><code>/viaggi-create-json</code></td><td><code>POST</code></td><td><strong>API:</strong> Crea un nuovo viaggio (con paesi associati).</td></tr>
                        <tr><td><code>/viaggi-delete-json</code></td><td><code>DELETE</code></td><td><strong>API:</strong> Cancella un viaggio dal db.</td></tr>
                        <tr><td><code>/viaggi/{idViaggio}</code></td><td><code>GET</code></td><td><strong>API:</strong> Recupero di un singolo viaggio.</td></tr>
                        <tr><td><code>/viaggi/{idViaggio}</code></td><td><code>PUT</code></td><td><strong>API:</strong> Modifica un viaggio nel db.</td></tr>
                        <tr><td><code>/viaggi/{idViaggio}/{paese}</code></td><td><code>DELETE</code></td><td><strong>API:</strong> Rimuove un paese specifico da un viaggio (dalla tabella join).</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <h2>👨‍💻 Autore</h2>
            <ul style="list-style: none; padding-left: 0;">
                <li><strong>Autore:</strong>Fabio</li>
            </ul>
        </section>
        <footer>
        </footer>

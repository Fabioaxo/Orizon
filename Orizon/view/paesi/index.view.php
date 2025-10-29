<?php    require_once(__DIR__ . '/../partials/navbar.php'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<body class ="bg-gradient-to-br from-blue-100 to-indigo-200  bg-fixed [background-image:url('https://i.pinimg.com/736x/49/6a/00/496a008e2363cdacef5b948426e5b6f8.jpg')]">

  <main class=" flex items-center justify-center min-h-screen">
        <div class="w-full max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-10">
          <!-- MODIFICA (PUT) -->
            <div class="flex hidden items-center space-x-4 bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-10" id="edit-paese-container">
            <i class="fas fa-map-marker-alt text-red-500 text-2xl mr-4"></i>
            <p class="text-gray-600 text-center ">Modifica il nome del Paese</p>
            <input type="text" id="edit-paese-input" placeholder="Inserisci il nuovo nome" 
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ">
            <button onclick="editPaese()" id="edit-paese-button" type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Salva Modifiche
            </button>
            </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">
            Elenco Paesi 
        </h1>
        <!-- Area per i messaggi di successo -->
           <div id="delete-message" class="hidden p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg mb-10 text-center"></div>
        
        <!-- Contenitore dove verrà iniettata la lista generata da JavaScript -->
        <div id="countries-container" class="space-y-4">
            <!-- Indicatore di caricamento iniziale -->
            <p id="loading-message" class="text-center text-indigo-600 font-medium">
                Caricamento dati in corso...
            </p>
            <!-- Area per i messaggi di errore -->
            <div id="error-message" class="hidden p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg "></div>
        </div>
    </div>
  </main>
        <div class="w-full flex max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-10 mb-32 justify-center">
        <button class=" bg-gradient-to-r from-blue-500 to-teal-500 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:from-blue-600 hover:to-teal-600 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75 transition-all duration-300 transform hover:scale-105">
          <a href="/paesi-create">Aggiungi un paese</a></button>
     </div>





<script>
    // Questo JavaScript viene eseguito dopo che la pagina HTML è stata caricata
        // Ottieni l'elemento con l'id "loading-message"
        const loadingMessage = document.getElementById('loading-message');
        // Ottieni l'elemento con l'id "error-message"
        const errorMessage = document.getElementById('error-message');
        // Ottieni l'elemento con l'id "countries-container"
        const countriesContainer = document.getElementById('countries-container');
        // Ottieni l'elemento con l'id "delete-message"
        const deleteMessage = document.getElementById('delete-message');
        // Ottieni l'elemento con l'id "edit-paese-container"
        const editPaeseContainer = document.getElementById('edit-paese-container');
        const editPaeseInput = document.getElementById('edit-paese-input');
        const editPaeseButton = document.getElementById('edit-paese-button');


        // Mostra il messaggio di caricamento
        loadingMessage.classList.remove('hidden');
       
        async function fetchPaesiData() {
        // Fai una richiesta GET all'API
        fetch('/paesi-json')
            .then(response => response.json())
            .then(data => {
                // Nascondi il messaggio di caricamento
                loadingMessage.classList.add('hidden');

                // Verifica se la richiesta ha avuto successo
                if (data.success) {
                    // Ottieni l'array di paesi
                    const paesi = data.paesi;

                    // Crea una stringa HTML per ogni paese
                   const html = paesi.map(paese => `
                        <div class="flex items-center space-x-4 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                            <i class="fas fa-map-marker-alt text-red-500 text-2xl mr-4"></i>
                            <span class="text-xl font-semibold text-gray-700">${paese.nome_paese}</span>
                                    <!-- PULSANTE DELETE AGGIORNATO: NESSUN FORM, SOLO UN HANDLER ONCLICK -->
                                 <button 
                                  data-id="${paese.id_paese}" 
                                  data-nome-paese="${paese.nome_paese}"
                                  onclick="handleDeleteClick(this)"
                                  class="fas fa-trash-alt text-red-500 hover:text-red-700 transition-colors cursor-pointer ml-auto p-2"
                                  title="Elimina Paese"
                                  ></button>
                                  <button
                                   data-id="${paese.id_paese}" 
                                   data-nome-paese="${paese.nome_paese}"
                                   onclick="handleEditClick(this)"
                                   class="fas fa-edit text-blue-500 hover:text-blue-700 transition-colors cursor-pointer ml-auto p-2" title="Modifica Paese">
                                  </button>
                        </div>
                    `).join('');
                    // Inserisci la stringa HTML nel contenitore
                    countriesContainer.innerHTML = html;
                } else {
                    // Mostra il messaggio di errore
                    errorMessage.innerHTML = data.message;
                    errorMessage.classList.remove('hidden');
                }
            })
            .catch(error => {
                // Mostra il messaggio di errore
                errorMessage.innerHTML = 'Si è verificato un errore durante il caricamento dei dati.';
                errorMessage.classList.remove('hidden');
            });
        }
    // Funzione per gestire il click sul pulsante di eliminazione
    async function handleDeleteClick(element) {
    const idPaese = element.getAttribute('data-id');
    const nomePaese = element.getAttribute('data-nome-paese');
    const deleteMessage = document.getElementById('delete-message');
    if (!idPaese) return;

    // 1. CHIEDI CONFERMA
    // Non possiamo usare alert() o confirm() qui, quindi simuleremo un modal o un log.
    // In una vera app dovresti usare un modal custom.
    const isConfirmed = confirm(`Sei sicuro di voler eliminare il Paese con ID: ${idPaese},${nomePaese}?`);
    
    if (!isConfirmed) {
        console.log(`Cancellazione annullata per l'ID: ${idPaese}`);
        return;
    }

    const apiUrl = `/paesi-delete-json?id_paese=${idPaese}&nome_paese=${nomePaese}`; 

    try {
        console.log(`Invio richiesta DELETE a: ${apiUrl}`);

        // 2. INVIA LA RICHIESTA FETCH CON METODO DELETE
        const response = await fetch(apiUrl, {
            method: 'DELETE',
            // Non è necessario un body per una richiesta DELETE su un ID URL
            headers: {
                'Content-Type': 'application/json'
            }
        });

        // 3. PARSA IL JSON
        const result = await response.json();
        
        // 4. GESTIONE DELLA RISPOSTA
        if (response.ok && result.success) { // Controlla lo status HTTP 2xx E il campo 'success'
            console.log(`Cancellazione riuscita: ${result.message}`);

            // Aggiorna il messaggio di conferma
            deleteMessage.innerHTML = result.message;
            deleteMessage.classList.remove('hidden');

            // Aggiorna la lista dei Paesi
            fetchPaesiData();

            // OPZIONE A: Rimuovi l'elemento direttamente dal DOM (più veloce per l'utente)
            const listItem = element.closest('li');
            if (listItem) {
                listItem.remove();
            }

        } else {
            // Gestione errori (es. 404, 500, o success: false)
            const errorMessage = result.message || `Errore HTTP: ${response.status} - ${response.statusText}`;
            console.error(`Errore durante l'eliminazione del Paese: ${errorMessage}`);
            alert(`Impossibile eliminare il Paese. ${errorMessage}`);
        }
    } catch (error) {
        // Gestione errori di rete
        console.error('Errore di rete durante la richiesta DELETE:', error);
        alert('Si è verificato un errore di rete. Controlla la connessione.');
    }
                
}  
  // funzione di modifica
  document.addEventListener('DOMContentLoaded', fetchPaesiData);


   async function handleEditClick(element) {
    // 1. Leggi i dati dall'elemento cliccato (presumibilmente il pulsante stesso)
    const idPaese = element.getAttribute('data-id');
    const nomePaese = element.getAttribute('data-nome-paese');

        if (!idPaese || !nomePaese) {
        console.error("Errore: ID o Nome del Paese non trovato nell'attributo data-.");
        return;
                                    } 
    console.log(`Sto preparando la modifica per ID: ${idPaese}, Nome: ${nomePaese}`);
      editPaeseInput.value = nomePaese;
      editPaeseButton.setAttribute('data-id', idPaese);
      editPaeseContainer.classList.remove('hidden');
   }                               
   async function editPaese() {
    const bottoneModifica = editPaeseButton;
    const idPaeseToUpdate = bottoneModifica.getAttribute('data-id');
    const nuovoNomePaese = editPaeseInput.value.trim();
    const deleteMessage = document.getElementById('delete-message');

    if (!idPaeseToUpdate || !nuovoNomePaese) {
        console.error("Errore: ID o Nome del Paese non trovato nell'attributo data-.");
        return;
    }
    const apiUrl=`/paesi-update-json?id_paese=${idPaeseToUpdate}`;
    const payload = {
        id_paese: idPaeseToUpdate,
        nome_paese: nuovoNomePaese
    }
    console.log(`Invio richiesta PUT per ID: ${idPaeseToUpdate} con nuovo nome: ${nuovoNomePaese}`);
    try {
        // 2. INVIA LA RICHIESTA FETCH CON METODO PUT
        const response = await fetch(apiUrl, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        });

        // 3. PARSA IL JSON
        const result = await response.json();
        if (result.success) { 
                console.log(`Modifica riuscita: ${result.message}`);
                // Aggiorna il messaggio di conferma
                deleteMessage.innerHTML = result.message;
                deleteMessage.classList.remove('hidden');
                // Aggiorna la lista dei Paesi
                fetchPaesiData();
                // Nascondi il form dopo un successo
                setTimeout(() => {
                    editPaeseContainer.classList.add('hidden');
                    deleteMessage.classList.add('hidden');
                }, 2000);

            } 

        } catch (error) {
        console.error('Errore di connessione o fetch:', error);
    }
  }


    
    
</script>


<?php    require_once(__DIR__ . '/../partials/footer.php'); ?>

</body>
</html>
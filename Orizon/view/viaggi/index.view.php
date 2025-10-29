<?php    require_once(__DIR__ . '/../partials/navbar.php'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <body class ="bg-gradient-to-br from-blue-100 to-indigo-200 bg-center bg-cover  bg-fixed [background-image:url('https://stories.weroad.it/wp-content/uploads/2019/12/mappa-1.jpg')]">
            <header class="flex flex-col items-center justify-center text-white text-center mb-8 p-4 bg-blue-600 rounded-xl shadow-2xl">
            <h1 class="text-3xl font-bold">Trova il tuo Viaggio</h1>
            <p class="text-blue-100">Filtra per paese incluso nel pacchetto.</p>
            </header>
                <div class="flex flex-col items-center justify-center">
                <div class="mb-8 w-2/3 px-4 py-8 text-center p-4 bg-white rounded-xl shadow-lg ">
                <label for="filtro-paese" class="block text-lg font-medium text-gray-700 mb-2">Cerca Viaggi per Paese:</label>
                <!-- 
                    Aggiunto l'evento onkeyup="filterViaggi()" per filtrare in tempo reale
                    ad ogni battitura sulla tastiera.
                -->
                <input 
                    type="text" 
                    id="filtro-paese" 
                    placeholder="Es. Italia, Giappone, Messico..." 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                    
                    onkeyup="filterViaggi()"
                >
                <div id="no-results" class="hidden text-center p-8 bg-yellow-100 border border-yellow-300 rounded-xl mt-8 shadow-lg">
                <p class="text-xl font-semibold text-yellow-800">Nessun viaggio trovato con questo paese.</p>
            </div>
            </div>
            </div>
      <main class=" flex items-center justify-center min-h-screen">
        <div class="w-full flex-col max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-10">
            <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">
            Viaggi Disponibili
        </h1>
         <!-- MODIFICA (PUT) -->
            <div class="flex hidden items-center space-x-4 bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-10" id="edit-posti-container">
            <i class="fas fa-male text-red-500 text-2xl mr-4"></i>
            <p class="text-gray-600 text-center ">Modifica il numero dei posti disponibili</p>
            <input type="text" id="edit-posti-input" placeholder="Inserisci il nuovo numero dei posti disponibili" 
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ">
            <button onclick="editNumeroPostiDisponibili()" id="edit-posti-button" type="button" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Salva Modifiche
            </button>
            </div>
        <!-- Area per i messaggi di successo -->
           <div id="success-message" class="hidden p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg mb-10 text-center"></div>
        
        <!-- Contenitore dove verrà iniettata la lista generata da JavaScript -->
        <div id="viaggi-container" class="space-y-4">
            <!-- Indicatore di caricamento iniziale -->
            <p id="loading-message" class="text-center text-indigo-600 font-medium">
                Caricamento dati in corso...
            </p>
            <!-- Area per i messaggi di errore -->
            <div id="error-message" class="hidden p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg "></div>
        </div>
        <div id="add-viaggio-button" class="flex justify-center mt-6">
        <button onclick="showAddViaggioForm()" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300">Aggiungi Viaggio</button>
        </div>
    </div>
    <div id='viaggio-container' class="w-full hidden flex-col max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-10">
    </div>
    <div  id ="add-viaggio-container" class="w-full hidden flex-col max-w-5xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-10">
     <form id="add-viaggio" action="/viaggi-create-json" method="POST" class="space-y-6">

        <!-- Campo per il Nome del Viaggio -->
        <div>
            <label for="nome_del_viaggio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nome del Viaggio
            </label>
            <input 
                type="text" 
                name="nome_del_viaggio" 
                id="nome_del_viaggio" 
                required 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2"
            >
        </div>

        <!-- Campo per i Posti Disponibili -->
        <div>
            <label for="numero_posti_disponibili" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Posti Disponibili
            </label>
            <input 
                type="number" 
                name="numero_posti_disponibili" 
                id="numero_posti_disponibili" 
                required 
                min="1" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2"
            >
        </div>

        <!-- Checkbox per la selezione dei Paesi -->
        <div>
            <label  id="paesi-label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Seleziona i Paesi (minimo uno)
            </label>
            <div id="paesi-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-60 overflow-y-auto p-4 border rounded-md dark:border-gray-600">

            </div>
        </div>
        <div class="flex justify-center">
        <button type="submit" class=" bg-gradient-to-r from-blue-500 to-teal-500 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:from-blue-600 hover:to-teal-600 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75 transition-all duration-300 transform hover:scale-105">Crea Viaggio</button>
        </div>
        <div id="status-message" class="mt-6 p-4 rounded-md text-sm font-medium text-center hidden transition-all duration-300 ease-in-out"></div>
    </form>   
    </div>
  </main>
<script>
// Questo JavaScript viene eseguito dopo che la pagina HTML è stata caricata 
        
        // Ottieni l'elemento con l'id "paesi-container"
        const paesiContainer = document.getElementById('paesi-container');
        // Ottieni l'elemento con l'id "loading-message"
        const loadingMessage = document.getElementById('loading-message');
        // Ottieni l'elemento con l'id "error-message"
        const errorMessage = document.getElementById('error-message');
        // Ottieni l'elemento con l'id "countries-container"
        const viaggiContainer = document.getElementById('viaggi-container');
        // Ottieni l'elemento con l'id "viaggio-container"
        const viaggioContainer = document.getElementById('viaggio-container');
        // Ottieni l'elemento con l'id "delete-message"
        const successMessage = document.getElementById('success-message');
        // Ottieni l'elemento con l'id "edit-paese-container"
        const addViaggioContainer = document.getElementById('add-viaggio-container');
        // Ottieni l'elemento con l'id "add-viaggio-button"
        const addViaggioButton = document.getElementById('add-viaggio-button');
                // Mostra il messaggio di caricamento
        loadingMessage.classList.remove('hidden');

        fetchPaesiData();
        let viaggi=[];
        function renderViaggi(dataToRender) {
            if (!dataToRender){
                viaggiContainer.innerHTML = `<div class="text-center p-8 text-gray-500 font-semibold">
                Nessun viaggio trovato che corrisponda ai criteri di ricerca.
            </div>`;
            return ;
            }
                                const html = dataToRender.map(viaggio => `
                         <div class="bg-white shadow-md rounded-lg p-6">
                             <i class="fas fa-globe-americas text-blue-500 text-2xl mr-4"></i>
                            <span class="text-2xl font-bold text-gray-800 mb-4"> ${viaggio.nome_del_viaggio}</span>
                                                       <button 
                                   data-id="${viaggio.id_viaggio}"
                                  data-nome_del_viaggio="${viaggio.nome_del_viaggio}"
                                  onclick="handleDeleteClick(this)"
                                   class="fas fa-trash-alt text-red-500 hover:text-red-700 transition-colors cursor-pointer ml-auto p-2"
                                  title="Elimina Viaggio"
                                   ></button>
                                   <button 
                                   data-id="${viaggio.id_viaggio}"
                                   data-nome_del_viaggio="${viaggio.nome_del_viaggio}"
                                   onclick="handleShowClick(${viaggio.id_viaggio})"
                                   class="fas fa-plane-departure text-blue-500 hover:text-blue-700 transition-colors cursor-pointer ml-auto p-2"
                              title="Mostra Dettagli Viaggio"
                                   ></button>
                             <p>Paesi Coinvolti: ${viaggio.paesi.length}</p>      
                             <p class="text-gray-600">Posti Disponibili: ${viaggio.numero_posti_disponibili}</p>
                            <span class="text-gray-600">Prezzo: €500</span>
                            <p class="text-gray-600 hidden">ID Viaggio: ${viaggio.id_viaggio}</p>
                         </div>
                     `).join('');
                     // Inserisci la stringa HTML nel contenitore
                     viaggiContainer.innerHTML = html;
        }
        async function fetchViaggiData() {
             // Fai una richiesta GET all'API
        fetch('/viaggi-json')
            .then(response => response.json())
            .then(data => {
                // Nascondi il messaggio di caricamento
                loadingMessage.classList.add('hidden');
                // Verifica se la richiesta ha avuto successo
                if (data.success) {
                    // Ottieni l'array dei viaggi
                    viaggi = data.viaggi;
                    console.log(viaggi);
                    renderViaggi(viaggi);
                    viaggioContainer.classList.add('hidden');
                    viaggiContainer.classList.remove('hidden');
                    addViaggioButton.classList.remove('hidden');
 
                } else {
                    // Mostra il messaggio di errore
                    errorMessage.classList.remove('hidden');
                    errorMessage.textContent = data.message;
                }

            })
            .catch(error => {
                // Mostra il messaggio di errore
                errorMessage.classList.remove('hidden');
                errorMessage.textContent = " Si è verificato un errore durante il caricamento dei dati."; ;
            });
            
        }
        // Chiama la funzione per ottenere i dati dei Paesi
        addEventListener('DOMContentLoaded', fetchViaggiData);

                const addViaggiForm = document.getElementById('add-viaggio');
                const statusMessage = document.getElementById('status-message');

                addViaggiForm.addEventListener('submit', async (event) => {
                    
                    event.preventDefault();

                    const formData = new FormData(addViaggiForm);
                    const response = await fetch('/viaggi-create-json', {
                        method: 'POST',
                        body: formData


                    });

                    const data = await response.json();

                    if (data.success) {
                         fetchViaggiData();
                        statusMessage.classList.remove('bg-red-500', 'text-white');
                        statusMessage.classList.add('bg-green-500', 'text-white');
                        statusMessage.textContent = data.message;
                        statusMessage.classList.remove('hidden');
                            setTimeout(() => {
                            statusMessage.classList.add('hidden');
                            addViaggioContainer.classList.add('hidden');
                            addViaggiForm.reset();
                          }, 2000);
                        
                        
                    } else {
                        statusMessage.classList.remove('bg-green-500', 'text-white');
                        statusMessage.classList.add('bg-red-500', 'text-white');
                        statusMessage.textContent = data.message;
                        statusMessage.classList.remove('hidden');
                    }
                });


                async function handleDeleteClick(element) {
    const idViaggio = element.getAttribute('data-id');
    const nomeViaggio = element.getAttribute('data-nome_del_viaggio');
    const successMessage = document.getElementById('success-message');
    if (!idViaggio) return;

    const isConfirmed = confirm(`Sei sicuro di voler eliminare il Viaggio con ID: ${idViaggio},${nomeViaggio}?`);
    
    if (!isConfirmed) {
        console.log(`Cancellazione annullata per l'ID: ${idPaese}`);
        return;
    }

    const apiUrl = `/viaggi-delete-json?id_viaggio=${idViaggio}`; 

    try {
        console.log(`Invio richiesta DELETE a: ${apiUrl}`);

        //  INVIA LA RICHIESTA FETCH CON METODO DELETE
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
            successMessage.innerHTML = result.message;
            successMessage.classList.remove('hidden');
            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 2000);

            // Aggiorna la lista dei Paesi
            fetchViaggiData();

                    
            const listItem = element.closest('li');
            if (listItem) {
                listItem.remove();
            }

        } else {
            // Gestione errori (es. 404, 500, o success: false)
            const errorMessage = result.message || `Errore HTTP: ${response.status} - ${response.statusText}`;
            console.error(`Errore durante l'eliminazione del Viaggio: ${errorMessage}`);
            alert(`Impossibile eliminare il Paese. ${errorMessage}`);
        }
    } catch (error) {
        // Gestione errori di rete
        console.error('Errore di rete durante la richiesta DELETE:', error);
        alert('Si è verificato un errore di rete. Controlla la connessione.');
    }          
};


                async function fetchPaesiData() {
                    // Fai una richiesta GET all'API
                    fetch('/paesi-json')
                        .then(response => response.json())
                        .then(data => {
                            // Nascondi il messaggio di caricamento
                            loadingMessage.classList.add('hidden');
                            // Verifica se la richiesta ha avuto successo
                            console.log(data);
                            if (data.success) {
                                // Ottieni l'array dei paesi
                                const paesi = data.paesi;
                                console.log(paesi);
                                // Crea una stringa HTML per ogni paese
                                const html = paesi.map(paese => `
                                        <div class="flex items-center space-x-4 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                                        <i class="fas fa-globe-americas text-blue-500 text-2xl mr-4"></i>
                                        <input type="checkbox" name="paesi[]" value="${paese.id_paese}" id="paese_${paese.id_paese}"">
                                        <label for="paese_${paese.id_paese}">${paese.nome_paese}</label>
                                        </div>
                                `).join('');
                                // Inserisci la stringa HTML nel contenitore
                                paesiContainer.innerHTML = html;
                            } else {
                                // Mostra il messaggio di errore
                                errorMessage.classList.remove('hidden');
                                errorMessage.textContent = data.message;
                            }

                        })
                        .catch(error => {
                            // Mostra il messaggio di errore
                            errorMessage.classList.remove('hidden');
                            errorMessage.textContent = " Si è verificato un errore durante il caricamento dei dati."; ;
                        });
                    
                    }
                    async function showAddViaggioForm() {
                        addViaggioContainer.classList.remove('hidden');
                    }
                    async function handleShowClick(idViaggio) {
                        
                        fetch(`/viaggi/${idViaggio}`)
                        .then(response => response.json())
                        .then(apiResponse => {
                            console.log(apiResponse);
                            if(apiResponse.success){
                                const viaggio = apiResponse.data;
                                 viaggiContainer.classList.add('hidden');
                                 addViaggioButton.classList.add('hidden');
                                 const numeroPaesiCoinvolti = viaggio.paesi.length;
                                const html = `<div class="flex items-center space-x-4 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                                <i class="fas fa-globe-americas text-blue-500 text-2xl mr-4"></i>
                                <span class="text-2xl font-bold text-gray-800 mb-4"> ${viaggio.nome_del_viaggio}</span>
                                <p class="text-gray-600">Posti Disponibili: ${viaggio.numero_posti_disponibili}</p>
                                   <button
                                   data-id-viaggio="${viaggio.id_viaggio}"
                                   data-numero-posti-disponibili="${viaggio.numero_posti_disponibili}" 
                                   onclick="handleEditClick(this)"
                                   class="fas fa-edit text-blue-500 hover:text-blue-700 transition-colors cursor-pointer ml-auto p-2" title="Modifica Posti Disponibili">
                                  </button>
                                <span class="text-gray-600">Prezzo: €500</span>
                                <p class="text-gray-600 hidden">ID Viaggio: ${viaggio.id_viaggio}</p>
                                <p class="text-gray-600">Paesi Coinvolti: ${numeroPaesiCoinvolti}</p>
                                <button onclick="fetchViaggiData()" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition-colors duration-300">Torna alla lista</button>
                                </div>`;
                                viaggioContainer.innerHTML = html;
                                viaggioContainer.classList.remove('hidden');
                                viaggio.paesi.forEach(paese => {
                                    const listItem = document.createElement('div');
                                    listItem.innerHTML = `
                                        <div class="flex justify-center items-center space-x-4">
                                        <i class="fa fa-arrow-down text-blue-500 text-xl p-2"></i>
                                        </div>
                                        <div class="flex justify-center items-center  bg-white p-6 rounded-xl shadow-md border border-gray-200">
                                        <i class="fas fa-plane-departure text-blue-500 text-2xl "></i>
                                        <span class="text-2xl font-bold text-gray-800 mr-2 ml-2 ">${paese}</span>
                                        <button
                                        data-nome-paese="${paese}
                                        data-id-viaggio="${viaggio.id_viaggio}"
                                        onclick="handleDeletePaeseClick(${viaggio.id_viaggio}, '${paese}')" class="fas fa-trash text-2xl text-red-500 hover:text-red-700 transition-colors cursor-pointer">
                                        
                                        </button>
                                        </div>
                                    `;
                                    viaggioContainer.appendChild(listItem);
                                })
                            } else {
                                errorMessage.classList.remove('hidden');
                                errorMessage.textContent = data.message;
                            }
                        })
                        .catch(error => {
                            errorMessage.classList.remove('hidden');
                            errorMessage.textContent = "Si è verificato un errore durante il caricamento dei dati.";
                        });
                    }
                        const editPostiDisponibiliContainer = document.getElementById('edit-posti-container');
                        const editPostiDisponibiliInput = document.getElementById('edit-posti-input');
                        const editPostiDisponibiliButton = document.getElementById('edit-posti-button');
                    async function handleEditClick(element) {
                        idViaggio = element.getAttribute('data-id-viaggio');
                        const numeroPostiDisponibli = element.getAttribute('data-numero-posti-disponibili');

                        if (!idViaggio || !numeroPostiDisponibli) {
                          console.error("Errore: ID o NumeroPostiDisponibili non trovato nell'attributo data-.");
                           return;
                        }
                             
                         console.log(`Sto preparando la modifica per ID: ${idViaggio}, Posti Disponibili: ${numeroPostiDisponibli}`);

                        editPostiDisponibiliContainer.classList.remove('hidden');
                        editPostiDisponibiliInput.value = numeroPostiDisponibli;
                        editPostiDisponibiliButton.setAttribute('data-id-viaggio', idViaggio);
                        }
                            async function editNumeroPostiDisponibili() {
                                
                            const bottoneModifica = editPostiDisponibiliButton;
                            const idViaggio = bottoneModifica.getAttribute('data-id-viaggio');
                            const nuovoNumeroPostiDisponibili = editPostiDisponibiliInput.value.trim();
                            const successMessage = document.getElementById('success-message');  

                            if (!idViaggio || !nuovoNumeroPostiDisponibili) {
                            console.error("Errore: ID o NumeroPostiDisponibili non trovato nell'attributo data-.");
                            return;
                            }

                            const apiUrl = `/viaggi/${idViaggio}`;
                            const payload = {
                                id_viaggio : idViaggio,
                                numero_posti_disponibili : nuovoNumeroPostiDisponibili
                            };
                            console.log(`Invio richiesta PUT per ID: ${idViaggio} con nuovo Numero Posti Disponibili: ${nuovoNumeroPostiDisponibili}`);
                           try {
                            const response = await fetch(apiUrl, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            });

                            const result = await response.json();
                            if (response.ok && result.success) {
                                console.log(`Modifica riuscita: ${result.message}`);
                                successMessage.innerHTML = result.message;
                                successMessage.classList.remove('hidden');

                                setTimeout(() => {
                                    successMessage.classList.add('hidden');
                                    editPostiDisponibiliContainer.classList.add('hidden');
                                }, 3000);
                                handleShowClick(idViaggio);
                            } else {
                                console.error(`Modifica fallita: ${result.message}`);
                                errorMessage.classList.remove('hidden');
                                errorMessage.textContent = result.message;
                            
                            }}catch(error) {
                                console.error("Si è verificato un errore durante la modifica dei dati.");
                                errorMessage.classList.remove('hidden');
                                errorMessage.textContent = "Si è verificato un errore durante la modifica dei dati.";
                            };   
                            }
                            
                            async function handleDeletePaeseClick(idViaggio,paese) {
                            const deleteMessage = document.getElementById('delete-message');
                            
                            const apiUrl = `/viaggi/${idViaggio}/${paese}`;
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

                                          if (response.ok && result.success) { // Controlla lo status HTTP 2xx E il campo 'success'
                                          console.log(`Cancellazione riuscita: ${result.message}`);

                                        // Aggiorna il messaggio di conferma
                                            successMessage.innerHTML = result.message;
                                            successMessage.classList.remove('hidden');
                                            setTimeout(() => {
                                            successMessage.classList.add('hidden');
                                            }, 2000);

                                        // Aggiorna la lista dei Paesi
                                            handleShowClick(idViaggio);
                                          }  else {
                                          console.error(`Cancellazione fallita: ${result.message}`);
                                          }} catch (error) {
                                          // Gestione errori di rete
                                          console.error('Errore di rete durante la richiesta DELETE:', error);
                                          }    
                            }

                            function filterViaggi() {
                              console.log('Filtro Paesi');
                              const searchInput = document.getElementById('filtro-paese').value.toLowerCase().trim();
                              if (searchInput === '') {
                                renderViaggi(viaggi);
                                return;
                              }
                                const filteredViaggi = viaggi.filter(viaggio => {
                                const paesiArray = Array.isArray(viaggio.paesi) ? viaggio.paesi : [];
                                return paesiArray.some(paese => paese.toLowerCase().includes(searchInput));
                              });
                              console.log(`Viaggi filtrati: ${filteredViaggi.length}`);
                              renderViaggi(filteredViaggi);
                            }

</script>
<?php    require_once(__DIR__ . '/../partials/footer.php'); ?>

</body>
</html>
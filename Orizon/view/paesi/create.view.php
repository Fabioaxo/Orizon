<?php    require_once(__DIR__ . '/../partials/navbar.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<main class="flex items-center justify-center min-h-screen bg-gray-900">
    <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md">
         <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Inserisci un Paese<i class="fas fa-map-marker-alt text-red-500 text-2xl ml-2"></i></h2>
         <p class="text-gray-600 text-center mb-8">Digita il nome del paese che vuoi aggiungere.</p>
        <form id='add-paese' method="POST" action="/paesi-create" class="space-y-6" >
            <label for="paese" class="block text-sm font-medium text-gray-700 mb-2">Nome del Paese</label>
            <div>
                <textarea id="paese" name="paese" placeholder=" Inserisci il paese"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                ><?= isset($_POST['paese']) ? $_POST['paese'] : '' ?></textarea>
            </div>
            <?php if (isset($errors['paese'])) : ?>
                <p class="text-red-500 text-xs mt-1"><?= $errors['paese'] ?></p>
            <?php endif; ?>

            <div>
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-teal-500 text-white font-bold py-3 px-6 rounded-full shadow-lg hover:from-blue-600 hover:to-teal-600 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-75 transition-all duration-300 transform hover:scale-105"
                >
                    Aggiungi Paese
                </button>
                <p class="text-gray-600 text-center mt-4"><a href="/paesi" class="text-blue-600 hover:text-blue-800 hover:underline transition-all duration-200">Torna alla lista</a></p>
              <div id="status-message" class="mt-6 p-4 rounded-md text-sm font-medium text-center hidden transition-all duration-300 ease-in-out"></div>
              </div>
              <script>
                const addPaeseForm = document.getElementById('add-paese');
                const statusMessage = document.getElementById('status-message');

                addPaeseForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    

                    const formData = new FormData(addPaeseForm);
                    const response = await fetch('/paesi-create', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success === true) {
                        statusMessage.classList.remove('bg-red-500', 'text-white');
                        statusMessage.classList.add('bg-green-500', 'text-white');
                        statusMessage.textContent = data.message;
                        statusMessage.classList.remove('hidden');
                        
                    } else {
                        statusMessage.classList.remove('bg-green-500', 'text-white');
                        statusMessage.classList.add('bg-red-500', 'text-white');
                        statusMessage.textContent = data.message;
                        statusMessage.classList.remove('hidden');
                    }
                })
              </script>
        </form>
        
    </div>
</main>



<?php    require_once(__DIR__ . '/../partials/footer.php'); ?>


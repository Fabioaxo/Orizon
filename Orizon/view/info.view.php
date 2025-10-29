<?php    require_once(__DIR__ . '/partials/navbar.php'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<body class ="bg-gray-50 dark:bg-gray-900 ">

  <main>
        <section class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="container mx-auto max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div class="md:order-2">
                    <img src="https://plus.unsplash.com/premium_photo-1663047725430-f855f465b6a4?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjV8fHZpYWdnaSUyMGVjb3xlbnwwfHwwfHx8MA%3D%3D" alt="Immagine di Viaggi e Avventura" class="w-72 h-72 rounded-full object-cover mx-auto border-4  shadow-md">
                </div>
                <div class="md:order-1">
                    <h1 class="text-4xl font-extrabold text-white mb-5">Chi Siamo</h1>
                    <p class="text-base text-white leading-relaxed mb-4">
                        Nati dalla voglia di esplorare il mondo, ci dedichiamo a creare guide e ispirazioni per i tuoi prossimi viaggi.
                        Crediamo che ogni viaggio sia un'opportunità unica per scoprire nuove culture e vivere esperienze indimenticabili.
                    </p>
                    <p class="text-base text-white leading-relaxed">
                        Il nostro team è composto da viaggiatori esperti e narratori, pronti a condividere consigli pratici e storie affascinanti.
                        La tua prossima avventura ti aspetta!
                    </p>
                </div>
            </div>
        </section>
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold text-center text-white mb-12">Il Nostro Impegno per un Turismo Sostenibile</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mr-8 ml-8 mb-24">
            <!-- Immagine 1: Spiaggia incontaminata -->
            <div class="relative overflow-hidden rounded-xl shadow-lg flex items-center justify-center min-h-[250px] bg-gray-200">
                <img src="https://images.unsplash.com/photo-1529718836725-f449d3a52881?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dmlhZ2dpJTIwZWNvfGVufDB8fDB8fHww" alt="Spiaggia incontaminata" class="w-full h-full object-cover">
                <p class="absolute z-10 text-white text-3xl font-bold text-center p-4 text-shadow-lg">Aree Incontaminate</p>
            </div>

            <!-- Immagine 2: Città sostenibile -->
            <div class="relative overflow-hidden rounded-xl shadow-lg flex items-center justify-center min-h-[250px] bg-gray-200">
                <img src="https://images.unsplash.com/photo-1629626171203-8abb75d8f32c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8dmlhZ2dpJTIwZWNvfGVufDB8fDB8fHww" alt="Città sostenibile" class="w-full h-full object-cover">
                <p class="absolute z-10 text-white text-3xl font-bold text-center p-4 text-shadow-lg">Viaggi Sostenibili</p>
            </div>

            <!-- Immagine 3: Escursionisti in un parco naturale -->
            <div class="relative overflow-hidden rounded-xl shadow-lg flex items-center justify-center min-h-[250px] bg-gray-200">
                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fHZpYWdnaSUyMHNvc3RlbmliaWxpfGVufDB8fDB8fHww" alt="Escursionisti in un parco naturale" class="w-full h-full object-cover">
                <p class="absolute z-10 text-white text-3xl font-bold text-center p-4 text-shadow-lg">Natura Responsabile</p>
            </div>
        </div>
    </div>
  </main>
<?php    require_once(__DIR__ . '/partials/footer.php'); ?>

</body>
</html>
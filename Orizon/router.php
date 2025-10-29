<?php 

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
class Router {
        protected $routes = [];
        public function  get($uri, $controller){

            $this->routes[] = [
                'uri' => $uri,
                'controller' => $controller,
                'method' => 'GET'
            ];

    }
        public function  post($uri, $controller){

                $this->routes[] = [
                'uri' => $uri,
                'controller' => $controller,
                'method' => 'POST'
            ];
        
    }
        public function  delete($uri, $controller){

                $this->routes[] = [
                'uri' => $uri,
                'controller' => $controller,
                'method' => 'DELETE'
            ];
        
    }
        public function  patch($uri, $controller){

                $this->routes[] = [
                'uri' => $uri,
                'controller' => $controller,
                'method' => 'PATCH'
            ];
        
    }
        public function  put($uri, $controller){

                 $this->routes[] = [
                'uri' => $uri,
                'controller' => $controller,
                'method' => 'PUT'
            ];
        
    }

    // public function route($uri, $method) {
        
    //     foreach ($this->routes as $route) {
    //         if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
    //             require $route['controller'];
    //         }
    //     }
    // }

    public function route($uri, $method) {
        
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            
            // 1. Controlla se il metodo corrisponde
            if ($route['method'] !== $method) {
                continue;
            }

            // 2. Trasforma l'URI della rotta in un pattern RegEx
            // '/viaggi/{idViaggio}' diventa '#^/viaggi/(?<idViaggio>[^/]+)$#'
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?<$1>[^/]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            // 3. Esegui la corrispondenza
            if (preg_match($pattern, $uri, $matches)) {
                
                // Trovata la rotta! Estrai i parametri dinamici.
                
                // 4. Estrai solo i parametri dinamici (tutte le chiavi che non sono indici numerici)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // 5. Includi il controller
                // NOTA: I parametri dinamici (es. ['idViaggio' => 123]) devono essere passati al controller.
                // Li rendiamo disponibili tramite la variabile globale $params o estraendoli.
                
                // Rendi i parametri estratti disponibili nel controller come variabili locali (es. $idViaggio)
                extract($params); 

                require $route['controller'];
                return; // Ferma dopo aver trovato la prima corrispondenza
            }
        }
        
        // Se arriviamo qui, la rotta non è stata trovata
        $this->abort(404);
    }

     function abort($code = 404) {
     http_response_code($code);

     require __DIR__ . "/view/{$code}.php";

     die(); 
 }
}

$router = new Router();
$router->get('/', 'controllers/home.controller.php'); //responsabile della vista del homepage.
$router->get('/info', 'controllers/info.controller.php'); //responsabile della vista della storia.

$router->get('/paesi', 'view/paesi/index.view.php'); //responsabile della vista della lista dei paesi.
$router->get('/paesi-json', 'controllers/paesi/index.php'); //responsabile del recupero dei paesi dal db.
$router->delete('/paesi-delete-json', 'controllers/paesi/delete.php'); //responsabile della cancellazione di un paese dal db.
$router->put('/paesi-update-json', 'controllers/paesi/update.php'); //responsabile della modifica di un paese nel db.

$router->get('/viaggi', 'view/viaggi/index.view.php'); //responsabile della vista della lista dei viaggi.
$router->get('/viaggi-json', 'controllers/viaggi/index.php'); //responsabile del recupero dei viaggi dal db.
$router->post('/viaggi-create-json', 'controllers/viaggi/create.php'); //responsabile della creazione di un viaggio nel db.
$router->delete('/viaggi-delete-json', 'controllers/viaggi/delete.php'); //responsabile della cancellazione di un viaggio dal db.
$router->get('/viaggi/{idViaggio}', 'controllers/viaggi/show.php'); //responsabile recupero  di un singolo viaggio.
$router->put('/viaggi/{idViaggio}', 'controllers/viaggi/update.php'); //responsabile modifica di un viaggio nel db.
$router->delete('/viaggi/{idViaggio}/{paese}', 'controllers/viaggi/delete.paese.php'); //responsabile cancellazione di un paese da un viaggio nel db.

$router->get('/paesi-create', 'view/paesi/create.view.php'); //responsabile della vista per la creazione di un paese.
$router->post('/paesi-create', 'controllers/paesi/create.php'); //responsabile della creazione di un paese nel db.




$router->route($uri, $method);
 function abort($code = 404) {
     http_response_code($code);

     require __DIR__ . "/view/{$code}.php";

     die(); 
 }
// function routeToController($uri , $routes){
//     if (array_key_exists($uri, $routes)) {
//         require $routes[$uri];
//     } else {
//         abort();
//     }
// }
// routeToController($uri , $routes);


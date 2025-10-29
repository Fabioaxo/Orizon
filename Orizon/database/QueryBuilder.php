<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function selectAll($table)

    {
    
        $statement = $this->pdo->prepare('select * from '. $table);
       
        $statement->execute();
       
        return $statement->fetchALL(PDO::FETCH_CLASS);
       
       
    }

     public function selectWhereUser2($table)

    {
    
        $statement = $this->pdo->prepare('select * from '. $table . ' where user_id = 2');
       
        $statement->execute();
       
        return $statement->fetchALL(PDO::FETCH_ASSOC);
       
       
    }
   public function query($sql, $params = []) // Metodo 'query' per eseguire qualsiasi query
    {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params); // Esegue la query con i parametri
            return $statement; // Restituisce lo statement, non i dati
        } catch (PDOException $e) {
            // È meglio lanciare un'eccezione o loggare l'errore in un'applicazione reale,
            // non usare die() direttamente in una classe riusabile.
            // Per il debug, die() può andare, ma in produzione no.
            throw new Exception("Errore nella query: " . $e->getMessage());
        }
    }
}

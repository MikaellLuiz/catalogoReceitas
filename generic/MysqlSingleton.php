<?php
namespace generic;

use PDO;
use PDOException;
use Exception;

class MysqlSingleton{
    private static  $instance = null;    private $conn;
    private $dsn;
    private $usuario;
    private $senha;    private function __construct(){
        // Configuração para Docker/Ambiente
        $host = getenv('DB_HOST') ?: 'mysql';
        $dbname = getenv('DB_NAME') ?: 'receitas_apocalipticas';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: 'root';
          $this->dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
        $this->usuario = $user;
        $this->senha = $pass;
        
        if($this->conn == null){
            try {
                $this->conn = new PDO($this->dsn, $this->usuario, $this->senha, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                throw new Exception("Erro de conexão: " . $e->getMessage());
            }
        }
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new MysqlSingleton();
        }

        return self::$instance;
    }    public function executar($query, $param = array()){
        if($this->conn){
            try {
                $sth = $this->conn->prepare($query);
                foreach($param as $k => $v){
                    $sth->bindValue($k,$v);
                }
                
                $sth->execute();
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Erro ao executar query: " . $e->getMessage());
            }
        } else {
            throw new Exception("Conexão com banco não estabelecida");
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }
}
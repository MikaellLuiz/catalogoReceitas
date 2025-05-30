<?php
namespace generic;

use PDO;
use PDOException;
use Exception;

class MysqlSingleton{
    private static  $instance = null;    private $conexao = null;
    private $dsn;
    private $usuario;
    private $senha;    private function __construct(){
        // Configuração para Docker/Ambiente
        $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'db';
        $dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'receitas_apocalipticas';
        $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'receitas_user';
        $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: 'receitas123';
          $this->dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        $this->usuario = $user;
        $this->senha = $pass;
        
        if($this->conexao == null){
            try {
                $this->conexao = new PDO($this->dsn, $this->usuario, $this->senha, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]);
            } catch (PDOException $e) {
                throw new Exception("Erro na conexão com o banco: " . $e->getMessage());
            }
        }
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new MysqlSingleton();
        }

        return self::$instance;
    }    public function executar($query, $param = array()){
        if($this->conexao){
            try {
                $sth = $this->conexao->prepare($query);
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
}
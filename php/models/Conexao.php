<?php
class Conexao {
    private static $conexao;

    public static function getConexao() {
        if (!isset(self::$conexao)) {
            $host = 'localhost';
            $dbname = 'biblioteca';
            $usuario = 'root';
            $senha = 'd3bora2008'; 

            try {
                self::$conexao = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>
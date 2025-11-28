<?php
require_once 'Conexao.php';

class Categoria {
    private $id;
    private $nome;

    public function getId() { 
        return $this->id; 
    }

    public function getNome() { 
        return $this->nome; 
    }

    public static function listarTodas() {
        $con = Conexao::getConexao();
        [cite_start]// [cite: 24]
        $sql = "SELECT id, nome_categoria AS nome FROM cad_categorias ORDER BY nome_categoria";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Categoria');
    }

    public static function cadastrar($nome_categoria) {
        $con = Conexao::getConexao();
        [cite_start]// [cite: 24]
        $sql = "INSERT INTO cad_categorias (nome_categoria) VALUES (:nome)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nome', $nome_categoria);
        $stmt->execute();
        
        return ['id' => $con->lastInsertId(), 'nome' => $nome_categoria];
    }
}
?>
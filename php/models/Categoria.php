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
        $sql = "SELECT id, nome_categoria AS nome FROM cad_categorias ORDER BY nome_categoria";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Categoria');
    }
}
?>
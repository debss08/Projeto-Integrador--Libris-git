<?php
require_once 'Conexao.php';

class Livro {
    // ... (suas propriedades: id, titulo, autor, etc.) ...
    public $id;
    public $titulo;
    public $autor;
    public $resumo;
    public $imagem_capa;
    public $data_lancamento;
    public $id_categoria;
    public $nome_categoria;
    public $quantidade_total;
    public $quantidade_disponivel;

    public static function listarTodos() {
        $con = Conexao::getConexao();
        $sql = "SELECT 
                    l.*, 
                    c.nome_categoria,
                    a.quantidade_total,
                    a.quantidade_disponivel
                FROM cad_livros l
                LEFT JOIN cad_categorias c ON l.id_categoria = c.id
                LEFT JOIN cad_acervo a ON l.id = a.id_livro
                ORDER BY l.titulo";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Livro');
    }
    
    // ... (outros métodos como buscarPorId) ...
}
?>
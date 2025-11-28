<?php
require_once 'Conexao.php';

class Livro {
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

    public static function listarTodosComDetalhes() {
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

    public static function cadastrar($titulo, $autor, $resumo, $data_lancamento, $caminhoImagem, $categoria, $quantidade) {
        $con = Conexao::getConexao();
        $con->beginTransaction();
        try {
            $sqlLivro = "INSERT INTO cad_livros (titulo, autor, resumo, data_lancamento, imagem_capa, id_categoria)
                         VALUES (:titulo, :autor, :resumo, :data_lancamento, :imagem, :categoria)";
            $stmt = $con->prepare($sqlLivro);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':resumo', $resumo);
            $stmt->bindParam(':data_lancamento', $data_lancamento);
            $stmt->bindParam(':imagem', $caminhoImagem);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            $idLivro = $con->lastInsertId();

            $sqlAcervo = "INSERT INTO cad_acervo (id_livro, quantidade_total, quantidade_disponivel)
                          VALUES (:id_livro, :qtd, :qtd)";
            $stmt2 = $con->prepare($sqlAcervo);
            $stmt2->bindParam(':id_livro', $idLivro);
            $stmt2->bindParam(':qtd', $quantidade);
            $stmt2->execute();

            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return $e->getMessage();
        }
    }
}
?>
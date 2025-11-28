<?php
require_once 'Conexao.php';

class Emprestimo {

    public static function getVisaoAdmin() {
        $con = Conexao::getConexao();
        [cite_start]// Usa a nova VIEW [cite: 82] (Corrigido 'I' para 'l')
        $sql = "SELECT
                    e.id AS id_emprestimo, a.nome AS aluno, l.titulo AS livro,
                    l.autor, e.data_retirada, e.data_devolucao, e.atraso,
                    c.nome_categoria
                FROM cad_emprestimos e
                JOIN cad_alunos a ON e.id_aluno = a.id
                JOIN cad_livros l ON e.id_livro = l.id
                JOIN cad_categorias c ON c.id = l.id_categoria";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criar($id_livro, $id_aluno, $data_retirada) {
        $con = Conexao::getConexao();
        $con->beginTransaction();
        try {
            // 1. Verificar estoque
            $stmtEstoque = $con->prepare("SELECT quantidade_disponivel FROM cad_acervo WHERE id_livro = :id_livro FOR UPDATE");
            $stmtEstoque->bindParam(':id_livro', $id_livro);
            $stmtEstoque->execute();
            $estoque = $stmtEstoque->fetch();

            if (!$estoque || $estoque['quantidade_disponivel'] <= 0) {
                throw new Exception("Livro indisponível no momento.");
            }

            [cite_start]// 2. Registrar o empréstimo [cite: 47]
            $sql = "INSERT INTO cad_emprestimos (id_livro, id_aluno, data_retirada, data_devolucao)
                    VALUES (:id_livro, :id_aluno, :data_retirada, NULL)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id_livro', $id_livro);
            $stmt->bindParam(':id_aluno', $id_aluno);
            $stmt->bindParam(':data_retirada', $data_retirada);
            $stmt->execute();

            [cite_start]// 3. Debitar do estoque [cite: 40]
            $stmtUpdate = $con->prepare("UPDATE cad_acervo SET quantidade_disponivel = quantidade_disponivel - 1 WHERE id_livro = :id_livro");
            $stmtUpdate->bindParam(':id_livro', $id_livro);
            $stmtUpdate->execute();

            $con->commit();
            return true;
        } catch (Exception $e) {
            $con->rollBack();
            return $e->getMessage();
        }
    }
    
    public static function devolver($id_emprestimo) {
        $con = Conexao::getConexao();
        $con->beginTransaction();
        try {
            // 1. Buscar o empréstimo para saber qual livro é
            $stmtEmp = $con->prepare("SELECT id_livro FROM cad_emprestimos WHERE id = :id AND data_devolucao IS NULL");
            $stmtEmp->bindParam(':id', $id_emprestimo);
            $stmtEmp->execute();
            $emprestimo = $stmtEmp->fetch();

            if (!$emprestimo) {
                throw new Exception("Empréstimo não encontrado ou já devolvido.");
            }
            $id_livro = $emprestimo['id_livro'];

            [cite_start]// 2. Marcar como devolvido [cite: 53]
            $sql = "UPDATE cad_emprestimos SET data_devolucao = CURDATE() WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id', $id_emprestimo);
            $stmt->execute();

            [cite_start]// 3. Devolver ao estoque [cite: 45]
            $stmtUpdate = $con->prepare("UPDATE cad_acervo SET quantidade_disponivel = quantidade_disponivel + 1 WHERE id_livro = :id_livro");
            $stmtUpdate->bindParam(':id_livro', $id_livro);
            $stmtUpdate->execute();

            $con->commit();
            return true;
        } catch (Exception $e) {
            $con->rollBack();
            return $e->getMessage();
        }
    }
}
?>
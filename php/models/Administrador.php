<<<<<<< HEAD
<?php
require_once 'Conexao.php';

class Administrador {

    public static function buscarPorMatricula($matricula) {
        $con = Conexao::getConexao();
        // Busca o login E o nome do funcionário
        $sql = "SELECT l.id, l.matricula, l.senha_hash, l.nivel, f.nome 
                FROM Login l
                JOIN cad_funcionarios f ON l.id = f.login_id
                WHERE l.matricula = :matricula AND l.nivel = 'admin'";
        
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- Métodos do Dashboard ---

    public static function getEmprestimosPorMes() {
        $con = Conexao::getConexao();
        //
        $sql = "SELECT YEAR(data_retirada) AS ano, MONTH(data_retirada) AS mes, COUNT(*) AS total_emprestimos
                FROM cad_emprestimos
                GROUP BY ano, mes
                ORDER BY ano DESC, mes DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoriasMaisPopulares() {
        $con = Conexao::getConexao();
        // (Corrigido 'I' para 'l')
        $sql = "SELECT c.nome_categoria, COUNT(e.id) AS total_emprestimos
                FROM cad_emprestimos e
                JOIN cad_livros l ON l.id = e.id_livro
                JOIN cad_categorias c ON c.id = l.id_categoria
                GROUP BY c.id, c.nome_categoria
                ORDER BY total_emprestimos DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEmprestimosAtrasados() {
        $con = Conexao::getConexao();
        // (Query para atrasados, não "mais populares")
        $sql = "SELECT al.nome, l.titulo, e.data_retirada, e.data_devolucao
                FROM cad_emprestimos e
                JOIN cad_alunos al ON e.id_aluno = al.id
                JOIN cad_livros l ON e.id_livro = l.id
                WHERE e.atraso = TRUE"; //
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
=======
<?php
require_once 'Conexao.php';

class Administrador {

    public static function buscarPorMatricula($matricula) {
        $con = Conexao::getConexao();
        // Busca o login E o nome do funcionário
        $sql = "SELECT l.id, l.matricula, l.senha_hash, l.nivel, f.nome 
                FROM Login l
                JOIN cad_funcionarios f ON l.id = f.login_id
                WHERE l.matricula = :matricula AND l.nivel = 'admin'";
        
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- Métodos do Dashboard ---

    public static function getEmprestimosPorMes() {
        $con = Conexao::getConexao();
        //
        $sql = "SELECT YEAR(data_retirada) AS ano, MONTH(data_retirada) AS mes, COUNT(*) AS total_emprestimos
                FROM cad_emprestimos
                GROUP BY ano, mes
                ORDER BY ano DESC, mes DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCategoriasMaisPopulares() {
        $con = Conexao::getConexao();
        // (Corrigido 'I' para 'l')
        $sql = "SELECT c.nome_categoria, COUNT(e.id) AS total_emprestimos
                FROM cad_emprestimos e
                JOIN cad_livros l ON l.id = e.id_livro
                JOIN cad_categorias c ON c.id = l.id_categoria
                GROUP BY c.id, c.nome_categoria
                ORDER BY total_emprestimos DESC";
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEmprestimosAtrasados() {
        $con = Conexao::getConexao();
        // (Query para atrasados, não "mais populares")
        $sql = "SELECT al.nome, l.titulo, e.data_retirada, e.data_devolucao
                FROM cad_emprestimos e
                JOIN cad_alunos al ON e.id_aluno = al.id
                JOIN cad_livros l ON e.id_livro = l.id
                WHERE e.atraso = TRUE"; //
        $stmt = $con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
>>>>>>> 45dc7415ca70ca8361231fb3426e49cd8ce72483
?>
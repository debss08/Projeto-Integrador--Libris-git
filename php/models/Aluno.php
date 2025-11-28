<<<<<<< HEAD
<?php
require_once 'Conexao.php';

class Aluno {

    /**
     * Busca um aluno e seus dados de login pela matrícula.
     * Usado no ProcessaLoginAluno.php
     */
    public static function buscarPorMatricula($matricula) {
        $con = Conexao::getConexao();
        // Busca o login E os dados do aluno
        $sql = "SELECT l.id AS login_id, l.matricula, l.senha_hash, l.nivel, a.id AS aluno_id, a.nome 
                FROM Login l
                JOIN cad_alunos a ON l.id = a.login_id
                WHERE l.matricula = :matricula AND l.nivel = 'usuario'";
        
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cadastra um novo aluno usando uma transação.
     * Usado no ProcessaCadastroAluno.php
     */
    public static function cadastrar($nome, $cpf, $data_nascimento, $matricula, $senha) {
        $con = Conexao::getConexao();
        $con->beginTransaction();
        try {
            // 1. Inserir na tabela 'Login'
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sqlLogin = "INSERT INTO Login (matricula, senha_hash, nivel) VALUES (:matricula, :senha, 'usuario')";
            $stmtLogin = $con->prepare($sqlLogin);
            $stmtLogin->bindParam(':matricula', $matricula);
            $stmtLogin->bindParam(':senha', $hash);
            $stmtLogin->execute();
            
            $login_id = $con->lastInsertId();

            // 2. Inserir na tabela 'cad_alunos'
            $sqlAluno = "INSERT INTO cad_alunos (login_id, nome, cpf, data_nascimento)
                         VALUES (:login_id, :nome, :cpf, :data_nascimento)";
            $stmtAluno = $con->prepare($sqlAluno);
            $stmtAluno->bindParam(':login_id', $login_id);
            $stmtAluno->bindParam(':nome', $nome);
            $stmtAluno->bindParam(':cpf', $cpf);
            $stmtAluno->bindParam(':data_nascimento', $data_nascimento);
            $stmtAluno->execute();

            $con->commit();
            return true; // Sucesso
        } catch (PDOException $e) {
            $con->rollBack();
            return $e->getMessage(); // Retorna a mensagem de erro
        }
    }

    /**
     * Busca os empréstimos ativos de um aluno usando a VIEW.
     * Usado na area_aluno.php
     */
    public static function getEmprestimosAtivos($aluno_login_id) {
        $con = Conexao::getConexao();
        $sql = "SELECT * FROM vw_emprestimos_ativos WHERE login_id = :login_id"; 
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':login_id', $aluno_login_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca o histórico de empréstimos de um aluno usando a VIEW.
     * Usado na area_aluno.php
     */
    public static function getHistoricoEmprestimos($aluno_login_id) {
        $con = Conexao::getConexao();
        $sql = "SELECT * FROM vw_historico_emprestimos WHERE login_id = :login_id ORDER BY data_devolucao DESC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':login_id', $aluno_login_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
=======
<?php
require_once 'Conexao.php';

class Aluno {

    /**
     * Busca um aluno e seus dados de login pela matrícula.
     * Usado no ProcessaLoginAluno.php
     */
    public static function buscarPorMatricula($matricula) {
        $con = Conexao::getConexao();
        // Busca o login E os dados do aluno
        $sql = "SELECT l.id AS login_id, l.matricula, l.senha_hash, l.nivel, a.id AS aluno_id, a.nome 
                FROM Login l
                JOIN cad_alunos a ON l.id = a.login_id
                WHERE l.matricula = :matricula AND l.nivel = 'usuario'";
        
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cadastra um novo aluno usando uma transação.
     * Usado no ProcessaCadastroAluno.php
     */
    public static function cadastrar($nome, $cpf, $data_nascimento, $matricula, $senha) {
        $con = Conexao::getConexao();
        $con->beginTransaction();
        try {
            // 1. Inserir na tabela 'Login'
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sqlLogin = "INSERT INTO Login (matricula, senha_hash, nivel) VALUES (:matricula, :senha, 'usuario')";
            $stmtLogin = $con->prepare($sqlLogin);
            $stmtLogin->bindParam(':matricula', $matricula);
            $stmtLogin->bindParam(':senha', $hash);
            $stmtLogin->execute();
            
            $login_id = $con->lastInsertId();

            // 2. Inserir na tabela 'cad_alunos'
            $sqlAluno = "INSERT INTO cad_alunos (login_id, nome, cpf, data_nascimento)
                         VALUES (:login_id, :nome, :cpf, :data_nascimento)";
            $stmtAluno = $con->prepare($sqlAluno);
            $stmtAluno->bindParam(':login_id', $login_id);
            $stmtAluno->bindParam(':nome', $nome);
            $stmtAluno->bindParam(':cpf', $cpf);
            $stmtAluno->bindParam(':data_nascimento', $data_nascimento);
            $stmtAluno->execute();

            $con->commit();
            return true; // Sucesso
        } catch (PDOException $e) {
            $con->rollBack();
            return $e->getMessage(); // Retorna a mensagem de erro
        }
    }

    /**
     * Busca os empréstimos ativos de um aluno usando a VIEW.
     * Usado na area_aluno.php
     */
    public static function getEmprestimosAtivos($aluno_login_id) {
        $con = Conexao::getConexao();
        $sql = "SELECT * FROM vw_emprestimos_ativos WHERE login_id = :login_id"; 
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':login_id', $aluno_login_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca o histórico de empréstimos de um aluno usando a VIEW.
     * Usado na area_aluno.php
     */
    public static function getHistoricoEmprestimos($aluno_login_id) {
        $con = Conexao::getConexao();
        $sql = "SELECT * FROM vw_historico_emprestimos WHERE login_id = :login_id ORDER BY data_devolucao DESC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':login_id', $aluno_login_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
>>>>>>> 45dc7415ca70ca8361231fb3426e49cd8ce72483
?>
<?php
require_once "../models/Conexao.php"; // Caminho ajustado

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ... (Seu código de validação e upload de imagem) ...
    $titulo = $_POST['titulo'] ?? '';
    // ... (etc) ...
    $quantidade = $_POST['quantidade'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $caminhoImagem = null; // Defina um valor padrão

    // Lógica de Upload (a sua estava ótima)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        // ... (seu código de upload) ...
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('capa_') . '.' . $extensao;
        $diretorio = "../../uploads/"; // Caminho ajustado (volta 2 níveis)
        
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        $caminhoImagem = "uploads/" . $nomeArquivo; // Caminho salvo no BD
        move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $nomeArquivo);
    }
    
    try {
        $con = Conexao::getConexao();
        $con->beginTransaction(); 

        $sqlLivro = "INSERT INTO cad_livros (titulo, autor, resumo, data_lancamento, imagem_capa, id_categoria)
                     VALUES (:titulo, :autor, :resumo, :data_lancamento, :imagem, :categoria)";
        $stmt = $con->prepare($sqlLivro);
        // ... (seus bindParams) ...
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

        // Caminho ajustado para a view
        echo "<script>alert('Livro cadastrado com sucesso!'); window.location.href='../../views/html/biblio.php';</script>";
        exit;
    } catch (PDOException $e) {
        $con->rollBack();
        echo "<script>alert('Erro ao cadastrar livro: " . addslashes($e->getMessage()) . "'); history.back();</script>";
    }
}
?>
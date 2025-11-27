<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/global.css">
</head>
<body>
<main id="welcomePage">
    <div class="containerWelcome">
        <h1 class="subtitulo">Criar conta</h1>
        <form action="../../php/controllers/ProcessaCadastroAluno.php" method="POST" class="flexColumn cadastroForm">
            <label>Nome</label>
            <input type="text" class="input signin" name="nome" required>

            <label>CPF</label>
            <input type="text" class="input signin" name="cpf" maxlength="11" required>

            <label>Data de nascimento</label>
            <input type="date" class="input signin" name="data_nascimento" required>

            <label>Matrícula</label>
            <input type="text" class="input signin" name="matricula" required>

            <label>Senha</label>
            <input type="password" class="input signin" name="senha" required>

            <button type="submit" class="btn login">Finalizar cadastro</button>
        </form>

        <a class="btn signin" href="login.html">Voltar para o login</a>
    </div>
</main>
</body>
</html>

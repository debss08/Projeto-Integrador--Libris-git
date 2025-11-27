<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login do Aluno</title>
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
<main id="welcomePage">
    <div class="containerWelcome">
        <h1>Login do Aluno</h1>
        <p>Acesse sua conta para solicitar empréstimos.</p>
        
        <form action="php/processa_login_aluno.php" method="POST" class="flexColumn">
            <input type="text" class="input welcome" name="matricula" placeholder="Matrícula" required>
            <input type="password" class="input welcome" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn login">Login</button>
        </form>

        <p>Primeira vez?</p>
        <a class="btn signin" href="cadastro_aluno.php">Cadastre-se aqui</a>
        <hr>
        <a class="btn signin" style="background: #eee;" href="html/login_admin.html">Sou Administrador</a>
    </div>
</main>
</body>
</html>
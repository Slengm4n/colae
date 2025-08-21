<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro & Login</title>
</head>

<body>

    <!-- Formulário de Cadastro -->
    <form action="http://localhost/colae/usuarios/salvar" method="post"" class=" sign-up-form">
        <input type="text" id="signup_name" name="name" placeholder="Nome de usuário" required>
        <input type="email" id="signup_email" name="email" placeholder="Email" required>
        <input type="date" id="signup_birthdate" name="birthdate" placeholder="Aniversario" required>
        <input type="password" id="signup_password" name="password" placeholder="Senha" required>
        <input type="password" id="signup_password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required>
        <input type="submit" class="btn" value="Cadastrar" />
    </form>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <!-- Incluindo Bootstrap para um estilo básico -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Usuário</h2>
        <hr>

        <?php
            // Verifica se a variável com os dados do usuário existe.
            // Esta variável é enviada pelo método 'edit' do seu UserController.
            if (!isset($userData) || !$userData) {
                echo "<div class='alert alert-danger'>Dados do usuário não encontrados.</div>";
                exit;
            }
        ?>

        <!-- 
            O formulário envia os dados via POST para a rota de atualização.
            O seu roteador irá direcionar este pedido para o método 'update' do UserController.
        -->
        <form action="/colae/usuarios/atualizar" method="POST">

            <!-- 
                CAMPO OCULTO (HIDDEN):
                Este campo é crucial. Ele envia o ID do usuário de volta para o servidor
                para que o método 'update' saiba qual registo deve ser atualizado no banco de dados.
            -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userData['id']); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Endereço de E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="birthdate" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($userData['birthdate']); ?>" required>
            </div>

            <!-- Você pode adicionar outros campos aqui, como 'role', se necessário -->

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/colae/usuarios" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

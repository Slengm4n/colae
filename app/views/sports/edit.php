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
        <h2>Editar esporte</h2>
        <hr>

        <?php
            // Verifica se a variável com os dados do usuário existe.
            // Esta variável é enviada pelo método 'edit' do seu UserController.
            if (!isset($sportData) || !$sportData) {
                echo "<div class='alert alert-danger'>Dados do esporte não encontrado.</div>";
                exit;
            }
        ?>

        <!-- 
            O formulário envia os dados via POST para a rota de atualização.
            O seu roteador irá direcionar este pedido para o método 'update' do UserController.
        -->
        <form action="/colae/esportes/atualizar" method="POST">

            <!-- 
                CAMPO OCULTO (HIDDEN):
                Este campo é crucial. Ele envia o ID do usuário de volta para o servidor
                para que o método 'update' saiba qual registo deve ser atualizado no banco de dados.
            -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($sportData['id']); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Nome do esporte</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($sportData['name']); ?>" required>
            </div>


            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="/colae/usuarios" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

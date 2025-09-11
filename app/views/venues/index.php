<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Quadras</title>
    <!-- Adicionando um link para o Bootstrap para melhorar a aparência da tabela -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="mb-4">Lista de Quadras</h1>

        <a href="<?php echo BASE_URL; ?>/quadras/criar" class="btn btn-primary mb-3">Adicionar Nova Quadra</a>

        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Preço/Hora</th>
                    <th>Tipo de Piso</th>
                    <th>Coberto?</th>
                    <th>Iluminação?</th>
                    <th>Área de Lazer?</th>
                    <th>Cap. Lazer</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($venues && count($venues) > 0): ?>
                    <?php foreach ($venues as $venue): ?>
                        <tr>
                            <td><?php echo $venue['id']; ?></td>
                            <td><?php echo htmlspecialchars($venue['name']); ?></td>
                            <!-- Combina os campos de endereço para exibição, incluindo o número -->
                            <td><?php echo htmlspecialchars($venue['street'] . ', ' . $venue['number'] . ' - ' . $venue['city']); ?></td>
                            <td>R$ <?php echo number_format($venue['average_price_per_hour'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($venue['floor_type'])); ?></td>
                            <!-- Exibe 'Sim' ou 'Não' em vez de 1 ou 0 -->
                            <td><?php echo $venue['is_covered'] ? 'Sim' : 'Não'; ?></td>
                            <td><?php echo $venue['has_lighting'] ? 'Sim' : 'Não'; ?></td>
                            <td><?php echo $venue['has_leisure_area'] ? 'Sim' : 'Não'; ?></td>
                            <td><?php echo htmlspecialchars($venue['leisure_area_capacity']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($venue['status'])); ?></td>
                            <td>
                                <!-- Links corrigidos para apontar para /quadras -->
                                <a href="<?php echo BASE_URL; ?>/quadras/editar/<?php echo $venue['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo BASE_URL; ?>/quadras/excluir/<?php echo $venue['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta quadra?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Nenhuma quadra encontrada!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

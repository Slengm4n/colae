<h2>Lista de Usuários</h2>

<a href="http://localhost/colae/quadras/criar" class="btn btn-primary">Novo Usuário</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Endereço</th>
            <th>Preço médio por hora</th>
            <th>Capacidade máxima da quadra</th>
            <th>Capacidade máxima da área de laser</th>
            <th>Tipo de piso</th>
            <th>Tem Cobertura?</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($venues && count($venues) > 0):
            foreach ($venues as $row):
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['price_per_hour']); ?></td>
                    <td><?php echo htmlspecialchars($row['court_capacity']); ?></td>
                    <td><?php echo htmlspecialchars($row['play_area_capacity']); ?></td>
                    <td><?php echo htmlspecialchars($row['floor_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['is_covered']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="http://localhost/colae/usuarios/editar/<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="http://localhost/colae/usuarios/excluir/<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="8" class="text-center">Nenhum usuário encontrado!</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<h2>Lista de Usuários</h2>

<a href="http://localhost/colae/usuarios/criar" class="btn btn-primary">Novo Usuário</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>Função</th>
            <th>Status</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($users && count($users) > 0):
            foreach ($users as $row):
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['birthdate'])); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="http://localhost/colae/admin/usuarios/editar/<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="http://localhost/colae/admin/usuarios/excluir/<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
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
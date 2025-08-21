<h2>Lista de esportes cadastrados</h2>

<a href="http://localhost/colae/esportes/criar">Cadastrar esporte</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de criação</th>
            <th>Ações</th>
        </tr>
    </thead>
<tbody>
    <?php
    if($sports && count($sports)> 0):
        foreach($sports as $row):
    ?>
        <td><?php echo $row['id'];?></td>
        <td><?php echo htmlspecialchars($row['name']);?></td>
        <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
        <td>
            <a href="http://localhost/esportes/editar/<?php echo $row['id']; ?>">Editar</a>
            <a href="http://localhost/esporte/excluir/<?php echo $row['id']; ?>">Excluir</a>
        </td>
    </tr>
    <?php
    endforeach;
else:   
    ?>
    <tr>
        <td colspan="8" class="text-center">Nenhum usuário!</td>
    </tr> 
    <?php endif ?>
</tbody>

</table>
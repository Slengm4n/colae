<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Esportes - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="#" class="text-xl font-bold text-gray-800">Kolaê Admin</a>
                <a href="<?php echo BASE_URL; ?>/admin" class="text-gray-600 hover:text-blue-500">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="text-gray-600 hover:text-blue-500">Usuários</a>
                <a href="<?php echo BASE_URL; ?>/admin/esportes" class="font-bold text-blue-600">Esportes</a> <a href="<?php echo BASE_URL; ?>/admin/mapa" class="text-gray-600 hover:text-blue-500">Mapa</a>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout" class="text-red-500 hover:text-red-700 font-semibold">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Lista de Esportes</h1>
            <div class="flex items-center space-x-2">
                <a href="<?php echo BASE_URL; ?>/admin" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg">
                    Voltar
                </a>
                <a href="<?php echo BASE_URL; ?>/esportes/criar" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Cadastrar Esporte
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Criação</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (isset($sports) && count($sports) > 0): ?>
                            <?php foreach ($sports as $row): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo BASE_URL; ?>/esportes/editar/<?php echo $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <a href="<?php echo BASE_URL; ?>/esportes/excluir/<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('Tem certeza?')">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Nenhum esporte encontrado!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
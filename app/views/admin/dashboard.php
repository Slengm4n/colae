<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard do Administrador - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="#" class="text-xl font-bold text-gray-800">Kolaê Admin</a>
                <a href="<?php echo BASE_URL; ?>/admin" class="text-gray-600 hover:text-blue-500">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="text-gray-600 hover:text-blue-500">Usuários</a>
                <a href="<?php echo BASE_URL; ?>/admin/esportes" class="text-gray-600 hover:text-blue-500">Esportes</a>
                <a href="<?php echo BASE_URL; ?>/admin/mapa" class="text-gray-600 hover:text-blue-500">Mapa</a>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout" class="text-red-500 hover:text-red-700 font-semibold">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard do Administrador</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Usuários Cadastrados</h2>
            
            <?php if (!empty($data['users'])): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($data['users'] as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo htmlspecialchars($user['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <a href="#" class="text-red-600 hover:text-red-900 ml-4">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-500">Nenhum usuário encontrado.</p>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>
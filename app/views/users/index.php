<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Kolae Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome (para ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>

<body class="bg-[#0D1117] text-gray-200">

    <div>
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#161B22] border-r border-gray-800 flex flex-col transition-transform -translate-x-full md:translate-x-0">
            <!-- Botão de Fechar para Mobile -->
            <button id="sidebar-close-btn" class="md:hidden absolute top-4 right-4 text-gray-500 hover:text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <!-- Logo & User Info -->
            <div class="p-6 text-center border-b border-gray-800">
                <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-user-shield text-4xl text-cyan-400"></i>
                </div>
                <h2 class="text-xl font-bold">
                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </h2>
                <p class="text-sm text-gray-400">Admin Kolae</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="<?php echo BASE_URL; ?>/admin" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Início</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/usuarios" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold bg-cyan-500/10 text-cyan-400 rounded-lg">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Usuários</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/esportes" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-running w-5 text-center"></i>
                    <span>Esportes</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/mapa" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-map-marker-alt w-5 text-center"></i>
                    <span>Locais</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-800">
                <a href="<?php echo BASE_URL; ?>/logout" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span>Sair</span>
                </a>
            </div>
        </aside>

        <!-- Overlay para fechar o menu em mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden md:hidden"></div>

        <!-- Main Content -->
        <main class="md:ml-64 flex-1 p-6 sm:p-10">
            <!-- Botão Hamburger para Mobile -->
            <button id="sidebar-toggle" class="md:hidden mb-6 text-gray-400 hover:text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <h1 class="text-3xl font-bold mb-4 sm:mb-0">Gerenciar Usuários</h1>
                <a href="http://localhost/colae/admin/usuarios/criar" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg inline-flex items-center transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Usuário
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-[#161B22] p-6 rounded-2xl border border-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Data Criada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Cargo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php if (isset($users) && count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-gray-800/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400"><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white"><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 capitalize"><?php echo htmlspecialchars($user['role']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full <?php echo $user['status'] === 'active' ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300'; ?>">
                                                <span class="w-2 h-2 mr-2 rounded-full <?php echo $user['status'] === 'active' ? 'bg-green-400' : 'bg-red-400'; ?>"></span>
                                                <?php echo $user['status'] === 'active' ? 'Ativo' : 'Inativo'; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="<?php echo BASE_URL; ?>/admin/usuarios/editar/<?php echo $user['id']; ?>" class="text-cyan-400 hover:text-cyan-300">Editar</a>
                                            <a href="<?php echo BASE_URL; ?>/admin/usuarios/excluir/<?php echo $user['id']; ?>" class="text-red-400 hover:text-red-300 ml-4" onclick="return confirm('Tem certeza?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum usuário encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('sidebar-close-btn');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        toggleBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>

</body>

</html>
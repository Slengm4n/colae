<?php
// No início do seu ficheiro, garanta que a sessão está iniciada.
// session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Kolae</title>

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

    <!-- ==================== CABEÇALHO DO USUÁRIO ==================== -->
    <header class="bg-[#161B22] border-b border-gray-800 sticky top-0 z-30 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-bold tracking-widest text-white">KOLAE</a>
            
            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="font-semibold text-gray-300 hover:text-cyan-400 transition-colors">Meu Painel</a>
                <a href="<?php echo BASE_URL; ?>/quadras" class="font-semibold text-gray-300 hover:text-cyan-400 transition-colors">Meus Locais</a>
            </nav>

            <div class="relative">
                <div id="user-menu-button" class="flex items-center gap-3 p-2 border border-gray-700 rounded-full cursor-pointer transition-colors hover:bg-gray-700/50">
                    <i class="fas fa-bars text-lg"></i>
                    <i class="fas fa-user-circle text-xl"></i>
                </div>

                <div id="profile-dropdown" class="absolute top-full right-0 mt-3 w-72 bg-[#1c2128] border border-gray-700 rounded-xl shadow-2xl opacity-0 invisible transform -translate-y-2 transition-all duration-300">
                    <div class="p-4 border-b border-gray-700">
                        <p class="font-semibold text-white"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuário'); ?></p>
                        <a href="<?php echo BASE_URL; ?>/profile" class="text-sm text-gray-400 hover:text-cyan-400">Ver perfil</a>
                    </div>
                    <ul class="py-2">
                        <li class="md:hidden"><a href="<?php echo BASE_URL; ?>/quadras" class="flex items-center gap-4 px-5 py-3 text-sm hover:bg-gray-800 transition-colors"><i class="fas fa-store w-5 text-center text-gray-400"></i> Meus Locais</a></li>
                        <li class="border-t border-gray-700 my-2 md:hidden"></li>
                        
                        <li><a href="<?php echo BASE_URL; ?>/profile" class="flex items-center gap-4 px-5 py-3 text-sm hover:bg-gray-800 transition-colors"><i class="fas fa-cog w-5 text-center text-gray-400"></i> Configurações</a></li>
                        <li><a href="#" class="flex items-center gap-4 px-5 py-3 text-sm hover:bg-gray-800 transition-colors"><i class="fas fa-question-circle w-5 text-center text-gray-400"></i> Ajuda</a></li>
                        <li class="border-t border-gray-700 my-2"></li>
                        <li><a href="<?php echo BASE_URL; ?>/logout" class="flex items-center gap-4 px-5 py-3 text-sm text-red-400 hover:bg-gray-800 transition-colors"><i class="fas fa-sign-out-alt w-5 text-center"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- ==================== CONTEÚDO PRINCIPAL ==================== -->
    <main class="container mx-auto px-4 py-10">
        
        <h1 class="text-4xl font-bold text-white mb-10">Configurações da Conta</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <!-- Navegação Lateral das Configurações -->
            <aside class="md:col-span-1">
                <nav class="bg-[#161B22] p-4 rounded-2xl border border-gray-800">
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold bg-cyan-500/10 text-cyan-400 rounded-lg">
                                <i class="fas fa-user-edit w-5 text-center"></i>
                                <span>Editar Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                                <i class="fas fa-shield-alt w-5 text-center"></i>
                                <span>Segurança</span>
                            </a>
                        </li>
                         <li>
                            <a href="#" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                                <i class="fas fa-bell w-5 text-center"></i>
                                <span>Notificações</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Conteúdo da Secção -->
            <section class="md:col-span-3">
                <div class="bg-[#161B22] p-8 rounded-2xl border border-gray-800">
                    <h2 class="text-2xl font-bold text-white mb-6">Informações Pessoais</h2>
                    
                    <?php if (isset($data['user'])): $user = $data['user']; ?>
                    <form action="<?php echo BASE_URL; ?>/profile/update" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Foto do Perfil -->
                        <div class="flex items-center gap-6">
                            <?php 
                                $avatarPath = !empty($user['avatar_path']) 
                                    ? BASE_URL . '/public/uploads/avatars/' . $user['avatar_path'] 
                                    : 'https://placehold.co/100x100/1f2937/9ca3af?text=Foto';
                            ?>
                            <img id="avatar-preview" src="<?php echo $avatarPath; ?>" alt="Foto do perfil" class="w-24 h-24 object-cover rounded-full">
                            <div>
                                <!-- AQUI ESTÁ A CORREÇÃO -->
                                <label for="avatar-upload" class="cursor-pointer bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg text-sm transition-colors">
                                    Carregar Nova Foto
                                </label>
                                <input type="file" name="avatar" id="avatar-upload" class="hidden" accept="image/png, image/jpeg, image/gif">
                                <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF até 10MB.</p>
                            </div>
                        </div>

                        <!-- Linha Divisória -->
                        <hr class="border-gray-700">

                        <!-- Campos do Formulário -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300">Nome Completo</label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                        </div>

                         <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Endereço de Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" disabled class="w-full bg-gray-900 border border-gray-700 rounded-md px-4 py-3 text-sm text-gray-400 cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">O email não pode ser alterado.</p>
                            </div>
                        </div>

                         <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-300">Data de Nascimento</label>
                            <div class="mt-1">
                                <input id="birthdate" name="birthdate" type="date" value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                        </div>
                        
                        <!-- Botão de Salvar -->
                        <div class="pt-4 text-right">
                             <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-6 rounded-lg transition-colors">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                    <?php else: ?>
                        <p class="text-gray-400">Não foi possível carregar os dados do usuário.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('user-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', (event) => {
                    event.stopPropagation();
                    profileDropdown.classList.toggle('opacity-0');
                    profileDropdown.classList.toggle('invisible');
                    profileDropdown.classList.toggle('-translate-y-2');
                });
            }

            window.addEventListener('click', (event) => {
                if (profileDropdown && !profileDropdown.classList.contains('invisible')) {
                    if (!profileDropdown.contains(event.target) && !userMenuButton.contains(event.target)) {
                        profileDropdown.classList.add('opacity-0', 'invisible', '-translate-y-2');
                    }
                }
            });

            // Lógica para pré-visualização da imagem de perfil
            const avatarUpload = document.getElementById('avatar-upload');
            const avatarPreview = document.getElementById('avatar-preview');

            if (avatarUpload && avatarPreview) {
                avatarUpload.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

</body>

</html>


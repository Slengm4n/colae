<?php
// No início do seu ficheiro, garanta que a sessão está iniciada.
// session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segurança - Configurações da Conta</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; -webkit-font-smoothing: antialiased; }
        #password-strength-bar-container { height: 8px; background-color: #374151; }
        #password-strength-bar { height: 100%; width: 0%; transition: width 0.3s ease, background-color 0.3s ease; }
    </style>
</head>
<body class="bg-[#0D1117] text-gray-200">

    <header class="bg-[#161B22] border-b border-gray-800 sticky top-0 z-30 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-bold tracking-widest text-white">KOLAE</a>
            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="font-semibold text-gray-300 hover:text-cyan-400">Meu Painel</a>
            </nav>
            <div class="relative">
                <div id="user-menu-button" class="flex items-center gap-3 p-2 border border-gray-700 rounded-full cursor-pointer hover:bg-gray-700/50">
                    <i class="fas fa-bars text-lg"></i>
                    <i class="fas fa-user-circle text-xl"></i>
                </div>
                <div id="profile-dropdown" class="absolute top-full right-0 mt-3 w-72 bg-[#1c2128] border border-gray-700 rounded-xl shadow-2xl opacity-0 invisible transform -translate-y-2 transition-all duration-300">
                    </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-white mb-10">Configurações da Conta</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            
            <aside class="md:col-span-1">
                <nav class="bg-[#161B22] p-4 rounded-2xl border border-gray-800">
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo BASE_URL; ?>/dashboard/perfil" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold text-gray-400 hover:bg-gray-700/50 hover:text-white rounded-lg transition-colors">
                                <i class="fas fa-user-edit w-5 text-center"></i>
                                <span>Editar Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/dashboard/seguranca" class="flex items-center gap-4 px-4 py-3 text-sm font-semibold bg-cyan-500/10 text-cyan-400 rounded-lg">
                                <i class="fas fa-shield-alt w-5 text-center"></i>
                                <span>Segurança</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <section class="md:col-span-3">
                <div class="bg-[#161B22] p-8 rounded-2xl border border-gray-800">
                    <h2 class="text-2xl font-bold text-white mb-6">Alterar Senha</h2>
                    
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="p-4 mb-4 text-sm rounded-lg <?php echo $_SESSION['flash_message']['type'] === 'success' ? 'bg-green-800 text-green-200' : 'bg-red-800 text-red-200'; ?>" role="alert">
                            <?php echo htmlspecialchars($_SESSION['flash_message']['message']); ?>
                        </div>
                        <?php unset($_SESSION['flash_message']); ?>
                    <?php endif; ?>

                    <form action="http://localhost/colae/dashboard/perfil/seguranca/atualizar" method="POST" class="space-y-6 max-w-lg">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-300">Senha Atual</label>
                            <div class="mt-1">
                                <input type="password" name="current_password" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-300">Nova Senha</label>
                            <div class="mt-1">
                                <input type="password" name="new_password" id="new_password" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                            <div id="password-strength-bar-container" class="w-full rounded-full mt-2 overflow-hidden">
                                <div id="password-strength-bar"></div>
                            </div>
                            <p id="password-strength-text" class="text-xs text-gray-500 mt-1"></p>
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-300">Confirmar Nova Senha</label>
                            <div class="mt-1">
                                <input type="password" name="confirm_password" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-6 rounded-lg transition-colors">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script>
        // SEU SCRIPT PARA O MENU DROPDOWN PODE VIR AQUI
        document.addEventListener('DOMContentLoaded', function() {
            // ...
        });

        // SCRIPT PARA A VALIDAÇÃO DE FORÇA DA SENHA
        const newPasswordInput = document.getElementById('new_password');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        if(newPasswordInput) {
            newPasswordInput.addEventListener('input', () => {
                const password = newPasswordInput.value; let score = 0;
                if (password.length >= 8) score++; if (password.length >= 12) score++; if (/[A-Z]/.test(password)) score++; if (/[0-9]/.test(password)) score++; if (/[^A-Za-z0-9]/.test(password)) score++;
                let barColor = 'bg-red-500'; let text = 'Muito Fraca';
                if (score >= 2) { text = 'Fraca'; barColor = 'bg-orange-500'; } if (score >= 3) { text = 'Razoável'; barColor = 'bg-yellow-500'; } if (score >= 4) { text = 'Forte'; barColor = 'bg-green-500'; } if (score === 5) { text = 'Muito Forte'; barColor = 'bg-emerald-500'; }
                strengthBar.style.width = (score / 5) * 100 + '%'; strengthBar.className = 'h-full rounded-full ' + barColor; strengthText.textContent = 'Força: ' + text;
            });
        }
    </script>
</body>
</html>
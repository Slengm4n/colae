<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="icon" href="https://i.postimg.cc/Ss21pvVJ/Favicon.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kolae</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

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

<body class="bg-[#0D1117] text-white">

    <div class="flex min-h-screen">
        <!-- Seção da Imagem (Esquerda) -->
        <div class="hidden lg:flex w-1/2 bg-cover bg-center relative items-center justify-center" style="background-image: url('https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 text-center px-12 animate-fadeInUp">
                <img src="<?php echo BASE_URL; ?>/assets/img/kolae_branca.png" alt="Logo Kolae" class="h-16 mx-auto mb-6">
                <h1 class="text-4xl font-bold leading-tight">Sua jornada esportiva começa aqui.</h1>
                <p class="mt-4 text-lg text-gray-300">Conecte-se, treine e evolua com a maior comunidade de atletas.</p>
            </div>
        </div>

        <!-- Seção do Formulário (Direita) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8">
            <div class="relative w-full max-w-md bg-[#161B22] p-8 rounded-2xl border border-gray-800 lg:border-none lg:bg-transparent lg:p-0 animate-fadeInUp" style="animation-delay: 200ms;">

                <!-- Botão de Voltar para Home -->
                <a href="<?php echo BASE_URL; ?>/" class="absolute top-4 left-4 lg:top-0 lg:left-0 text-gray-400 hover:text-white transition-colors" title="Voltar para a Home">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>

                <a href="index.html" class="lg:hidden mb-6 inline-block w-full text-center">
                    <img src="./assets/img/kolae_branca.png" alt="Logo Kolae" class="h-10 mx-auto">
                </a>

                <h2 class="text-3xl font-bold text-center mb-2">Bem-vindo de volta!</h2>
                <p class="text-gray-400 text-center mb-8">Acesse sua conta para continuar.</p>

                <!-- Bloco para exibir mensagens de erro ou sucesso -->
                <?php if (isset($_GET['error']) && $_GET['error'] === 'credentials'): ?>
                    <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg text-center mb-6 text-sm">
                        Email ou senha inválidos. Por favor, tente novamente.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['status']) && $_GET['status'] === 'registered'): ?>
                    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg text-center mb-6 text-sm">
                        Cadastro realizado com sucesso! Faça o login.
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>/login/authenticate" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Senha</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full bg-gray-800 border border-gray-700 rounded-md px-4 py-3 text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 bg-gray-700 border-gray-600 text-cyan-500 focus:ring-cyan-400 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-300">Lembrar de mim</label>
                        </div>
                        <div class="text-sm">
                            <a href="<?php echo BASE_URL; ?>/forgot-password" class="font-medium text-cyan-400 hover:text-cyan-300">Esqueceu a senha?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-black bg-cyan-400 hover:bg-cyan-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-cyan-400 transition-colors">
                            Entrar
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-gray-400">
                    Não tem uma conta?
                    <a href="<?php echo BASE_URL; ?>/register" class="font-medium text-cyan-400 hover:text-cyan-300">Cadastre-se</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
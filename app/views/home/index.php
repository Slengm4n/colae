<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo ao Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-800 to-gray-900 text-white min-h-screen flex flex-col items-center justify-center font-sans">

    <main class="container mx-auto px-4 text-center">
        
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">
            Bem-vindo ao Kolaê!
        </h1>

        <p class="text-lg md:text-xl text-gray-300 mb-8">
            Sua plataforma para organizar e gerenciar eventos esportivos.
        </p>

        <div class="actions flex flex-col sm:flex-row justify-center gap-4">
            <a 
                href="<?php echo BASE_URL; ?>/login" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105 duration-300"
            >
                Entrar
            </a>
            <a 
                href="<?php echo BASE_URL; ?>/register" 
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition-transform transform hover:scale-105 duration-300"
            >
                Criar Conta
            </a>
        </div>

    </main>
    
    <footer class="absolute bottom-5 text-gray-500 text-sm">
        <p>&copy; <?php echo date('Y'); ?> Kolaê. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
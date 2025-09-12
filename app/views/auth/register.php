<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Conta - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen py-8">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Crie sua Conta</h1>
            <p class="text-gray-500">É rápido e fácil!</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 text-center" role="alert">
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/register/store" method="POST">
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome Completo:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                    required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">E-mail:</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                    required>
            </div>
            
            <div class="mb-4">
                <label for="birthdate" class="block text-gray-700 text-sm font-bold mb-2">Data de Nascimento:</label>
                <input 
                    type="date" 
                    id="birthdate" 
                    name="birthdate"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                    required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                    required>
            </div>
            
            <button 
                type="submit"
                class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-colors duration-300"
            >
                Registrar
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Já possui conta? 
                <a href="<?php echo BASE_URL; ?>/login" class="text-blue-500 font-bold hover:underline">
                    Faça Login
                </a>
            </p>
        </div>
    </div>
</body>

</html>
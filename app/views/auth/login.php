<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Acessar Sistema</h1>
            <p class="text-gray-500">Faça login para continuar</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 text-center" role="alert">
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/login/authenticate" method="POST">
            
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
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                    required>
            </div>

            <div class="text-right text-sm mb-6">
                <a href="<?php echo BASE_URL; ?>/forgot-password" class="text-blue-500 hover:underline">
                    Esqueci minha senha
                </a>
            </div>
            
            <button 
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-colors duration-300"
            >
                Entrar
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Não tem uma conta? 
                <a href="<?php echo BASE_URL; ?>/register" class="text-blue-500 font-bold hover:underline">
                    Crie uma aqui
                </a>
            </p>
        </div>
    </div>
</body>

</html>
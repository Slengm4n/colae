<?php
AuthHelper::start(); // Garante que a sessão está iniciada 
// Verifica se há mensagens de erro ou sucesso na URL
$error = $_GET['error'] ?? null;
$status = $_GET['status'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meu Painel - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="text-xl font-bold text-gray-800">Kolaê</a>
                <a href="<?php echo BASE_URL; ?>/dashboard" class="font-semibold text-blue-600">Meu Painel</a>
                <a href="<?php echo BASE_URL; ?>/quadras" class="text-gray-600 hover:text-blue-500">Minhas Quadras</a>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>/logout" class="text-gray-600 hover:text-red-500 font-medium">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p class="text-gray-600">Gerencie suas informações e quadras aqui.</p>
        </div>

        <?php if (empty($_SESSION['user_cpf'])): ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="py-1"><svg class="w-6 h-6 text-yellow-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                    <div>
                        <p class="font-bold">Cadastro Pendente</p>
                        <p class="text-sm">Para cadastrar e gerenciar suas quadras, por favor, valide seu CPF.
                            <a href="<?php echo BASE_URL; ?>/dashboard/cpf" class="font-semibold text-yellow-800 hover:underline">Adicionar CPF agora</a>.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error === 'cpf_required'): ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                 <p class="font-bold">Ação necessária:</p>
                 <p class="text-sm">Você precisa adicionar um CPF válido para poder cadastrar uma nova quadra. 
                    <a href="<?php echo BASE_URL; ?>/dashboard/cpf" class="font-semibold text-yellow-800 hover:underline">Clique aqui para adicionar</a>.
                </p>
            </div>
        <?php endif; ?>

        <?php if ($status === 'cpf_success'): ?>
             <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                 <p class="font-bold">Sucesso!</p>
                 <p class="text-sm">Seu CPF foi validado e agora você pode cadastrar suas quadras.</p>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Acesso Rápido</h2>
            <p>Use os links no menu superior para navegar entre as seções.</p>
        </div>

    </main>

</body>
</html>
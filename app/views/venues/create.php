<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Quadra - Kolaê</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Cadastrar Nova Quadra</h1>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="<?php echo BASE_URL; ?>/quadras/salvar" method="POST" enctype="multipart/form-data">
                    
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-6">Dados da Quadra</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome do Local:</label>
                                <input type="text" id="name" name="name" required minlength="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label for="average_price_per_hour" class="block text-gray-700 text-sm font-bold mb-2">Preço Médio/Hora:</label>
                                <input type="number" step="0.01" min="0.01" id="average_price_per_hour" name="average_price_per_hour" placeholder="Ex: 50.00" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label for="court_capacity" class="block text-gray-700 text-sm font-bold mb-2">Capacidade da Quadra:</label>
                                <input type="number" id="court_capacity" name="court_capacity" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label for="leisure_area_capacity" class="block text-gray-700 text-sm font-bold mb-2">Cap. Área de Lazer:</label>
                                <input type="number" id="leisure_area_capacity" name="leisure_area_capacity" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label for="floor_type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de Piso:</label>
                                <select id="floor_type" name="floor_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="grama natural">Grama Natural</option>
                                    <option value="grama sintética">Grama Sintética</option>
                                    <option value="cimento">Cimento</option>
                                    <option value="areia">Areia</option>
                                    <option value="saibro">Saibro</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
                            <fieldset>
                                <legend class="text-gray-700 text-sm font-bold mb-2">Área de Lazer?</legend>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center"><input type="radio" name="has_leisure_area" value="1" class="mr-2"> Sim</label>
                                    <label class="flex items-center"><input type="radio" name="has_leisure_area" value="0" checked class="mr-2"> Não</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="text-gray-700 text-sm font-bold mb-2">Iluminação?</legend>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center"><input type="radio" name="has_lighting" value="1" class="mr-2"> Sim</label>
                                    <label class="flex items-center"><input type="radio" name="has_lighting" value="0" checked class="mr-2"> Não</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend class="text-gray-700 text-sm font-bold mb-2">É Coberto?</legend>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center"><input type="radio" name="is_covered" value="1" class="mr-2"> Sim</label>
                                    <label class="flex items-center"><input type="radio" name="is_covered" value="0" checked class="mr-2"> Não</label>
                                </div>
                            </fieldset>
                        </div>
                    </section>
                    
                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-6">Endereço</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="md:col-span-1">
                                <label for="cep" class="block text-gray-700 text-sm font-bold mb-2">CEP:</label>
                                <input type="text" id="cep" name="cep" required placeholder="00000-000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                             <div class="md:col-span-3">
                                <label for="street" class="block text-gray-700 text-sm font-bold mb-2">Rua/Avenida:</label>
                                <input type="text" id="street" name="street" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="md:col-span-1">
                                <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Número:</label>
                                <input type="text" id="number" name="number" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="md:col-span-3">
                                <label for="neighborhood" class="block text-gray-700 text-sm font-bold mb-2">Bairro:</label>
                                <input type="text" id="neighborhood" name="neighborhood" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="md:col-span-3">
                                <label for="city" class="block text-gray-700 text-sm font-bold mb-2">Cidade:</label>
                                <input type="text" id="city" name="city" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="md:col-span-1">
                                <label for="state" class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
                                <input type="text" id="state" name="state" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </section>
                    
                    <section>
                         <h2 class="text-xl font-semibold text-gray-700 border-b pb-2 mb-6">Imagens da Quadra</h2>
                         <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                             <label for="images" class="cursor-pointer">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="mt-2 block text-sm font-medium text-gray-600">Clique para selecionar as imagens</span>
                                <span class="mt-1 block text-xs text-gray-500">PNG, JPG, JPEG</span>
                             </label>
                             <input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png" class="sr-only">
                         </div>
                    </section>
                    
                    <div class="flex justify-end space-x-4 mt-8">
                         <a href="<?php echo BASE_URL; ?>/quadras" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                            Salvar Local
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
</body>
</html>
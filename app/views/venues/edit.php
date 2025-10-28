<?php
// Garante que a sessão está iniciada e os dados do local existem.
// session_start();
$venue = $data['venue'] ?? null; // A variável $data virá do seu controller
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="https://i.postimg.cc/Ss21pvVJ/Favicon.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Local - <?php echo htmlspecialchars($venue['name'] ?? 'Kolae'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; -webkit-font-smoothing: antialiased; }
        /* Estilos de card selecionado */
        .option-card.selected, .checkbox-card.selected {
            border-color: #22d3ee; /* cyan-400 */
            background-color: rgba(34, 211, 238, 0.1); /* cyan-500/10 */
        }
        .checkbox-card.selected i {
            color: #22d3ee; /* cyan-400 */
        }
        /* Destaque da área de drop */
        #drop-area.highlight {
            border-color: #22d3ee; /* cyan-400 */
            background-color: rgba(34, 211, 238, 0.1);
        }
    </style>
</head>
<body class="bg-[#0D1117] text-gray-200">

    <div class="flex flex-col min-h-screen">
            <header class="bg-[#161B22] border-b border-gray-800 sticky top-0 z-30 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="<?php echo BASE_URL; ?>/" class="text-2xl font-bold tracking-widest text-white">KOLAE</a>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="<?php echo BASE_URL; ?>/dashboard" class="font-semibold text-cyan-400 transition-colors">Meu Painel</a>
            </nav>

            <div class="relative">
                <div id="user-menu-button" class="flex items-center gap-3 p-2 border border-gray-700 rounded-full cursor-pointer transition-colors hover:bg-gray-700/50">
                    <i class="fas fa-bars text-lg"></i>
                    <i class="fas fa-user-circle text-xl"></i>
                </div>

                <div id="profile-dropdown" class="absolute top-full right-0 mt-3 w-72 bg-[#1c2128] border border-gray-700 rounded-xl shadow-2xl opacity-0 invisible transform -translate-y-2 transition-all duration-300">
                    <div class="p-4 border-b border-gray-700">
                        <p class="font-semibold text-white"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilizador'); ?></p>
                        <a href="<?php echo BASE_URL; ?>/dashboard/perfil" class="text-sm text-gray-400 hover:underline">Ver perfil</a>
                    </div>
                    <ul class="py-2">
                        <li><a href="<?php echo BASE_URL; ?>/dashboard/perfil" class="flex items-center gap-4 px-5 py-3 text-sm hover:bg-gray-800 transition-colors"><i class="fas fa-cog w-5 text-center text-gray-400"></i> Configurações</a></li>
                        <li><a href="#" class="flex items-center gap-4 px-5 py-3 text-sm hover:bg-gray-800 transition-colors"><i class="fas fa-question-circle w-5 text-center text-gray-400"></i> Ajuda</a></li>
                        <li class="border-t border-gray-700 my-2"></li>
                        <li><a href="<?php echo BASE_URL; ?>/logout" class="flex items-center gap-4 px-5 py-3 text-sm text-red-400 hover:bg-gray-800 transition-colors"><i class="fas fa-sign-out-alt w-5 text-center"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>


            <main class="flex-grow w-full max-w-3xl mx-auto p-8">
           <?php if (!$venue): ?>
                <div class="text-center p-8">
                    <h2 class="text-3xl font-bold text-red-400">Erro</h2>
                    <p class="text-gray-400 mt-2">Os dados do local não foram encontrados.</p>
                </div>
            <?php else: ?>
            <form id="venue-form" action="<?php echo BASE_URL; ?>/quadras/atualizar/<?php echo $venue['id']; ?>" method="POST" enctype="multipart/form-data" class="w-full h-full flex flex-col space-y-12">
                <input type="hidden" name="address_id" value="<?php echo $venue['address_id']; ?>">
                
                <input type="hidden" id="floor_type_input" name="floor_type" value="<?php echo htmlspecialchars($venue['floor_type']); ?>">
                <input type="hidden" id="court_capacity_input" name="court_capacity" value="<?php echo htmlspecialchars($venue['court_capacity']); ?>">
                <input type="hidden" id="leisure_area_capacity_input" name="leisure_area_capacity" value="<?php echo htmlspecialchars($venue['leisure_area_capacity']); ?>">

                        <section id="section-details">
                    <h2 class="text-3xl font-bold text-white mb-6">Detalhes Principais</h2>
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-gray-400 text-sm font-bold mb-2">Nome do Local</label>
                            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($venue['name']); ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500">
                        </div>
                        <div>
                            <label for="average_price_per_hour" class="block text-gray-400 text-sm font-bold mb-2">Preço Médio por Hora (R$)</label>
                            <input type="number" step="0.01" id="average_price_per_hour" name="average_price_per_hour" value="<?php echo htmlspecialchars($venue['average_price_per_hour']); ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500">
                        </div>
                    </div>
                </section>
                
                        <section id="section-floor-type">
                    <h2 class="text-3xl font-bold text-white mb-6">Tipo de Piso</h2>
                    <div class="space-y-4" data-input-name="floor_type">
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="grama sintética"><h3 class="font-semibold text-lg">Grama Sintética</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="cimento"><h3 class="font-semibold text-lg">Cimento / Poliesportivo</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="areia"><h3 class="font-semibold text-lg">Areia</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="saibro"><h3 class="font-semibold text-lg">Saibro</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="grama natural"><h3 class="font-semibold text-lg">Grama Natural</h3></div>
                    </div>
                </section>

                        <section id="section-capacity">
                    <h2 class="text-3xl font-bold text-white mb-6">Capacidade da Quadra</h2>
                    <p class="text-gray-400 mb-6">Refere-se ao número de jogadores em campo ao mesmo tempo.</p>
                    <div class="flex justify-between items-center max-w-xs">
                        <label class="font-semibold text-lg">Jogadores</label>
                        <div class="counter-input flex items-center gap-4" data-input-name="court_capacity" data-min-value="2" data-target-input="court_capacity_input">
                            <button type="button" class="counter-btn minus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">-</button>
                            <span class="counter-value text-lg font-bold"><?php echo $venue['court_capacity']; ?></span>
                            <button type="button" class="counter-btn plus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">+</button>
                        </div>
                    </div>
                </section>

                        <section id="section-amenities">
                    <h2 class="text-3xl font-bold text-white mb-6">Comodidades</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <label class="checkbox-card border border-gray-700 rounded-lg p-4 flex flex-col items-start justify-start space-y-2 cursor-pointer hover:border-cyan-400 transition-colors">
                            <input type="checkbox" name="has_lighting" value="1" class="hidden" <?php echo $venue['has_lighting'] ? 'checked' : ''; ?>>
                            <i class="fas fa-lightbulb text-2xl text-gray-400 mb-2"></i><span class="font-semibold text-base">Iluminação</span>
                        </label>
                        <label class="checkbox-card border border-gray-700 rounded-lg p-4 flex flex-col items-start justify-start space-y-2 cursor-pointer hover:border-cyan-400 transition-colors">
                            <input type="checkbox" name="is_covered" value="1" class="hidden" <?php echo $venue['is_covered'] ? 'checked' : ''; ?>>
                            <i class="fas fa-cloud-sun text-2xl text-gray-400 mb-2"></i><span class="font-semibold text-base">Quadra Coberta</span>
                        </label>
                        <label id="leisure-area-checkbox-card" class="checkbox-card border border-gray-700 rounded-lg p-4 flex flex-col items-start justify-start space-y-2 cursor-pointer hover:border-cyan-400 transition-colors">
                            <input type="checkbox" name="has_leisure_area" value="1" class="hidden" <?php echo $venue['has_leisure_area'] ? 'checked' : ''; ?>>
                            <i class="fas fa-utensils text-2xl text-gray-400 mb-2"></i><span class="font-semibold text-base">Área de Lazer</span>
                        </label>
                    </div>
                    <div id="leisure-capacity-container" class="hidden mt-8">
                        <hr class="border-gray-800 mb-8">
                        <h3 class="text-2xl font-bold text-white mb-4">Qual a capacidade da sua área de lazer?</h3>
                        <div class="flex justify-between items-center max-w-xs">
                            <label class="font-semibold text-lg">Pessoas</label>
                            <div class="counter-input flex items-center gap-4" data-input-name="leisure_area_capacity" data-min-value="0" data-target-input="leisure_area_capacity_input">
                                <button type="button" class="counter-btn minus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">-</button>
                                <span class="counter-value text-lg font-bold"><?php echo $venue['leisure_area_capacity']; ?></span>
                                <button type="button" class="counter-btn plus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">+</button>
                            </div>
                        </div>
                    </div>
                </section>

                        <section id="section-address">
                    <h2 class="text-3xl font-bold text-white mb-6">Endereço</h2>
                    <div class="space-y-4">
                        <div><label for="cep" class="block text-gray-400 text-sm font-bold mb-2">CEP</label><input type="text" id="cep" name="cep" required value="<?php echo htmlspecialchars($venue['cep']); ?>" class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2"><label for="street" class="block text-gray-400 text-sm font-bold mb-2">Rua</label><input type="text" id="street" name="street" value="<?php echo htmlspecialchars($venue['street']); ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                            <div><label for="number" class="block text-gray-400 text-sm font-bold mb-2">Número</label><input type="text" id="number" name="number" value="<?php echo htmlspecialchars($venue['number']); ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                        </div>
                        <div><label for="neighborhood" class="block text-gray-400 text-sm font-bold mb-2">Bairro</label><input type="text" id="neighborhood" name="neighborhood" value="<?php echo htmlspecialchars($venue['neighborhood']); ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2"><label for="city" class="block text-gray-400 text-sm font-bold mb-2">Cidade</label><input type="text" id="city" name="city" value="<?php echo htmlspecialchars($venue['city']); ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                            <div><label for="state" class="block text-gray-400 text-sm font-bold mb-2">Estado</label><input type="text" id="state" name="state" value="<?php echo htmlspecialchars($venue['state']); ?>" required class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-cyan-500"></div>
                        </div>
                    </div>
                </section>

                        <section id="section-photos">
                    <h2 class="text-3xl font-bold text-white mb-6">Fotos</h2>
                    <div id="drop-area" class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-cyan-400 transition-colors">
                        <label for="images" class="cursor-pointer"><i class="fas fa-cloud-upload-alt text-5xl text-gray-500"></i><p class="mt-4 font-semibold">Arraste e solte novas fotos aqui</p><p class="text-sm text-gray-500">ou clique para selecionar</p><input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png" class="hidden"></label>
                    </div>
                    <div id="preview-container" class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        
                        <?php // Loop para exibir imagens existentes
                        if (!empty($venue['images']) && is_array($venue['images'])) {
                            foreach ($venue['images'] as $image) {
                                $imgUrl = htmlspecialchars($image['url']);
                                $imgId = htmlspecialchars($image['id'] ?? $imgUrl); // Usa ID se existir, senão URL
                                echo '<div class="relative existing-image-preview">';
                                echo '  <img src="'.$imgUrl.'" alt="Foto do local" class="w-full h-32 object-cover rounded-lg">';
                                // Botão para marcar imagem existente para exclusão
                                echo '  <button type="button" class="delete-existing-image absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-lg" data-image-id="'.$imgId.'">&times;</button>';
                                echo '</div>';
                            }
                        }
                        ?>
                        
                    </div>
                </section>
            
            <?php endif; ?>
            </form>
        </main>

            <footer class="w-full p-4 border-t border-gray-800 sticky bottom-0 bg-[#0D1117] z-10">
            <div class="max-w-3xl mx-auto flex justify-end">
                <button type="submit" form="venue-form" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-8 rounded-lg transition-colors">Salvar Alterações</button>
            </div>
        </footer>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const venueData = <?php echo json_encode($venue ?? null); ?>;
            if (!venueData) return;

            const form = document.getElementById('venue-form');

            // --- Lógica dos Contadores (Capacidade) ---
            document.querySelectorAll('.counter-input').forEach(counter => {
                const valueSpan = counter.querySelector('.counter-value');
                const targetInputId = counter.dataset.targetInput; // ID do input hidden
                const hiddenInput = document.getElementById(targetInputId);
                const minValue = parseInt(counter.dataset.minValue, 10);
                let value = parseInt(valueSpan.textContent, 10);
                
                counter.querySelector('.minus').addEventListener('click', () => {
                    if (value > minValue) value--;
                    valueSpan.textContent = value;
                    hiddenInput.value = value; // Atualiza o input hidden
                });
                counter.querySelector('.plus').addEventListener('click', () => {
                    value++;
                    valueSpan.textContent = value;
                    hiddenInput.value = value; // Atualiza o input hidden
                });
            });

            // --- Lógica dos Cards de Opção (Tipo de Piso) ---
            const optionCards = document.querySelectorAll('.option-card');
            const floorTypeInput = document.getElementById('floor_type_input');
            
            optionCards.forEach(card => {
                card.addEventListener('click', () => {
                    optionCards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    floorTypeInput.value = card.dataset.value; // Atualiza o input hidden
                });
            });

            // --- Lógica dos Checkbox-Cards (Comodidades) ---
            const leisureCapacityContainer = document.getElementById('leisure-capacity-container');
            const leisureCapacityInput = document.getElementById('leisure_area_capacity_input');
            const leisureCapacityValueSpan = leisureCapacityContainer.querySelector('.counter-value');
            
            document.querySelectorAll('.checkbox-card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                
                // Função para atualizar o estado visual
                const updateVisual = (isChecked) => {
                    card.classList.toggle('selected', isChecked);
                
                    if (card.id === 'leisure-area-checkbox-card') {
                        leisureCapacityContainer.classList.toggle('hidden', !isChecked);
                        if (!isChecked) {
                            // Zera a capacidade se a área de lazer for desmarcada
                            leisureCapacityValueSpan.textContent = '0';
                            leisureCapacityInput.value = '0';
                        }
                    }
                };

                // **CORREÇÃO DO BUG DE CLIQUE DUPLO**
                card.addEventListener('click', (e) => {
                    // Se o clique foi no próprio input, deixa o navegador agir
                    if (e.target.tagName === 'INPUT') {
                        updateVisual(checkbox.checked);
                        return;
                    }
                    
                    // Previne o comportamento padrão do <label> (que é clicar no input)
                    e.preventDefault();
                    
                    // Inverte manualmente o estado do checkbox
                    checkbox.checked = !checkbox.checked;
                    
                    // Atualiza o visual
                    updateVisual(checkbox.checked);
                });
            });

            // --- Lógica do ViaCEP ---
            document.getElementById('cep').addEventListener('blur', async function() {
                const cep = this.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    try {
                        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                        const data = await response.json();
                        if (!data.erro) {
                            document.getElementById('street').value = data.logradouro;
                            document.getElementById('neighborhood').value = data.bairro;
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                            document.getElementById('number').focus();
                        }
                    } catch (error) { console.error('Erro ao buscar CEP:', error); }
                }
            });
            
            // --- Lógica de Upload/Preview de Imagens (COMPLETA) ---
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('images');
            const previewContainer = document.getElementById('preview-container');
            // DataTransfer é usado para armazenar os arquivos que serão enviados
            const newFilesDataTransfer = new DataTransfer();

            // Previne comportamentos padrão do navegador
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Adiciona/Remove classe de destaque
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
            });

            // Lida com arquivos soltos
            dropArea.addEventListener('drop', (e) => {
                handleFiles(e.dataTransfer.files);
            }, false);

            // Lida com arquivos do input
            fileInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });

            // Função principal para processar arquivos
            function handleFiles(files) {
                for (const file of files) {
                    if (file.type.startsWith('image/') && !isFileInTransfer(file.name)) {
                        newFilesDataTransfer.items.add(file);
                        previewNewFile(file);
                    }
                }
                // Atualiza o input real com os arquivos do DataTransfer
                fileInput.files = newFilesDataTransfer.files;
            }

            function isFileInTransfer(fileName) {
                return Array.from(newFilesDataTransfer.files).some(f => f.name === fileName);
            }

            // Cria o preview para novas imagens
            function previewNewFile(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const previewDiv = document.createElement('div');
                    previewDiv.classList.add('relative', 'new-image-preview');
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                        <button type="button" class="delete-new-image absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-lg" data-file-name="${file.name}">&times;</button>
                    `;
                    previewContainer.appendChild(previewDiv);
                };
                reader.readAsDataURL(file);
            }

            // Lida com cliques nos botões de exclusão
            previewContainer.addEventListener('click', function(e) {
                // Excluir NOVA imagem (preview)
                if (e.target.classList.contains('delete-new-image')) {
                    e.preventDefault();
                    const fileName = e.target.dataset.fileName;
                    
                    // Remove do DataTransfer
                    const newFiles = Array.from(newFilesDataTransfer.files);
                    const filteredFiles = newFiles.filter(file => file.name !== fileName);
                    
                    newFilesDataTransfer.items.clear();
                    filteredFiles.forEach(file => newFilesDataTransfer.items.add(file));
                    fileInput.files = newFilesDataTransfer.files;

                    // Remove do DOM
                    e.target.parentElement.remove();
                }

                // Excluir IMAGEM EXISTENTE
                if (e.target.classList.contains('delete-existing-image')) {
                    e.preventDefault();
                    const imageId = e.target.dataset.imageId;

                    // Adiciona um input hidden para o back-end saber qual excluir
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'delete_images[]'; // Envia como um array
                    deleteInput.value = imageId;
                    form.appendChild(deleteInput);

                    // Remove do DOM
                    e.target.parentElement.remove();
                }
            });


            // --- Pré-preenchimento Visual ---
            function prefillVisuals() {
                // Pré-seleciona o tipo de piso
                const floorCard = document.querySelector(`.option-card[data-value="${venueData.floor_type}"]`);
                if(floorCard) floorCard.classList.add('selected');

                // Pré-seleciona as comodidades
                document.querySelectorAll('.checkbox-card input').forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.parentElement.classList.add('selected');
                        // Mostra a capacidade de lazer se estiver marcada
                        if(checkbox.name === 'has_leisure_area') {
                            leisureCapacityContainer.classList.remove('hidden');
                        }
                    }
                });
            }

            prefillVisuals();
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Lógica do menu dropdown do cabeçalho
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
        });
    </script>
</body>
</html>
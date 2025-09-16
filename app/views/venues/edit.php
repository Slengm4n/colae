<?php
// Garante que a sessão está iniciada e os dados do local existem.
// session_start();
$venue = $data['venue'] ?? null; // A variável $data virá do seu controller
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
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
        .step { display: none; }
        .step.active { display: block; animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-[#0D1117] text-gray-200">

    <div class="flex flex-col h-screen">
        <!-- Cabeçalho -->
        <header class="py-4 px-8 flex justify-between items-center border-b border-gray-800">
            <a href="<?php echo BASE_URL; ?>/dashboard" class="text-2xl font-bold tracking-widest text-white">KOLAE</a>
            <a href="<?php echo BASE_URL; ?>/quadras" class="text-sm font-semibold bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-full transition-colors">Sair da Edição</a>
        </header>

        <!-- Conteúdo Principal -->
        <main class="flex-grow flex items-center justify-center">
             <?php if (!$venue): ?>
                <div class="text-center p-8">
                    <h2 class="text-3xl font-bold text-red-400">Erro</h2>
                    <p class="text-gray-400 mt-2">Os dados do local não foram encontrados.</p>
                </div>
            <?php else: ?>
            <form id="venue-form" action="<?php echo BASE_URL; ?>/quadras/atualizar/<?php echo $venue['id']; ?>" method="POST" enctype="multipart/form-data" class="w-full h-full flex flex-col">
                <input type="hidden" name="address_id" value="<?php echo $venue['address_id']; ?>">
                
                <!-- Etapa 1: Tipo de Piso -->
                <div id="step-1" class="step active w-full max-w-2xl mx-auto p-8">
                    <h2 class="text-4xl font-bold text-white mb-8">Qual o tipo de piso principal do seu local?</h2>
                    <div class="space-y-4" data-input-name="floor_type">
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="grama sintética"><h3 class="font-semibold text-lg">Grama Sintética</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="cimento"><h3 class="font-semibold text-lg">Cimento / Poliesportivo</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="areia"><h3 class="font-semibold text-lg">Areia</h3></div>
                         <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="saibro"><h3 class="font-semibold text-lg">Saibro</h3></div>
                        <div class="option-card border border-gray-700 rounded-lg p-6 cursor-pointer hover:border-cyan-400 transition-colors" data-value="grama natural"><h3 class="font-semibold text-lg">Grama Natural</h3></div>
                    </div>
                </div>

                <!-- Etapa 2: Detalhes Básicos (Capacidade da Quadra) -->
                <div id="step-2" class="step w-full max-w-2xl mx-auto p-8">
                    <h2 class="text-4xl font-bold text-white mb-8">Qual a capacidade da sua quadra?</h2>
                    <p class="text-gray-400 mb-8">Refere-se ao número de jogadores em campo ao mesmo tempo.</p>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-lg">Jogadores</label>
                            <div class="counter-input flex items-center gap-4" data-input-name="court_capacity" data-min-value="2" data-initial-value="<?php echo $venue['court_capacity']; ?>">
                                <button type="button" class="counter-btn minus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">-</button>
                                <span class="counter-value text-lg font-bold"><?php echo $venue['court_capacity']; ?></span>
                                <button type="button" class="counter-btn plus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Etapa 3: Comodidades -->
                <div id="step-3" class="step w-full max-w-3xl mx-auto p-8">
                     <h2 class="text-4xl font-bold text-white mb-8">Informe aos jogadores o que seu espaço tem a oferecer</h2>
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
                            <div class="counter-input flex items-center gap-4" data-input-name="leisure_area_capacity" data-min-value="0" data-initial-value="<?php echo $venue['leisure_area_capacity']; ?>">
                                <button type="button" class="counter-btn minus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">-</button>
                                <span class="counter-value text-lg font-bold"><?php echo $venue['leisure_area_capacity']; ?></span>
                                <button type="button" class="counter-btn plus w-10 h-10 rounded-full border border-gray-600 text-gray-400 hover:bg-gray-700">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Etapa 4: Nome e Preço -->
                <div id="step-4" class="step w-full max-w-2xl mx-auto p-8">
                    <h2 class="text-4xl font-bold text-white mb-8">Confirme o nome e o preço do local</h2>
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
                </div>

                <!-- Etapa 5: Endereço -->
                <div id="step-5" class="step w-full max-w-2xl mx-auto p-8">
                     <h2 class="text-4xl font-bold text-white mb-8">Confirme o endereço</h2>
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
                </div>

                <!-- Etapa 6: Upload de Fotos -->
                <div id="step-6" class="step w-full max-w-2xl mx-auto p-8">
                    <h2 class="text-4xl font-bold text-white mb-8">Atualize as fotos do seu local</h2>
                    <div id="drop-area" class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center cursor-pointer hover:border-cyan-400 transition-colors">
                        <label for="images" class="cursor-pointer"><i class="fas fa-cloud-upload-alt text-5xl text-gray-500"></i><p class="mt-4 font-semibold">Arraste e solte novas fotos aqui</p><p class="text-sm text-gray-500">ou clique para selecionar</p><input type="file" id="images" name="images[]" multiple accept="image/jpeg, image/png" class="hidden"></label>
                    </div>
                    <div id="preview-container" class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                         <!-- Imagens existentes serão carregadas aqui -->
                    </div>
                </div>
            <?php endif; ?>
            </form>
        </main>

        <!-- Rodapé de Navegação -->
        <footer class="w-full p-4 border-t border-gray-800">
            <div class="max-w-2xl mx-auto">
                <div class="w-full bg-gray-700 rounded-full h-1.5 mb-4">
                    <div id="progress-bar" class="bg-cyan-400 h-1.5 rounded-full" style="width: 16.6%"></div>
                </div>
                <div class="flex justify-between items-center">
                    <button id="prev-btn" class="font-bold py-2 px-4 rounded-lg hover:bg-gray-800 transition-colors underline">Voltar</button>
                    <button id="next-btn" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-8 rounded-lg transition-colors">Avançar</button>
                </div>
            </div>
        </footer>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bloco PHP para injetar os dados do local no JavaScript
            const venueData = <?php echo json_encode($venue ?? null); ?>;
            if (!venueData) return;

            const form = document.getElementById('venue-form');
            const steps = Array.from(document.querySelectorAll('.step'));
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const progressBar = document.getElementById('progress-bar');
            let currentStep = 0;
            const totalSteps = steps.length;
            const formData = {};

            function updateUI() {
                steps.forEach((step, index) => step.classList.toggle('active', index === currentStep));
                prevBtn.classList.toggle('invisible', currentStep === 0);
                nextBtn.textContent = currentStep === totalSteps - 1 ? 'Salvar Alterações' : 'Avançar';
                progressBar.style.width = `${((currentStep + 1) / totalSteps) * 100}%`;
            }

            nextBtn.addEventListener('click', () => {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateUI();
                } else {
                    for (const key in formData) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = key;
                        hiddenInput.value = formData[key];
                        form.appendChild(hiddenInput);
                    }
                    form.submit();
                }
            });
            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateUI();
                }
            });

            // Pré-preenche os campos com os dados existentes
            function prefillData() {
                // Etapa 1: Tipo de Piso
                const floorCard = document.querySelector(`.option-card[data-value="${venueData.floor_type}"]`);
                if(floorCard) floorCard.click();

                // Etapa 3: Comodidades
                document.querySelectorAll('.checkbox-card input').forEach(checkbox => {
                    if (venueData[checkbox.name] == "1") {
                        checkbox.parentElement.click();
                    }
                });

                // Etapa 2 & 3: Contadores
                document.querySelectorAll('.counter-input').forEach(counter => {
                    const inputName = counter.dataset.inputName;
                    if(venueData[inputName]){
                        counter.querySelector('.counter-value').textContent = venueData[inputName];
                    }
                });
            }

            // (O resto do seu JS para CEP, Upload, etc. permanece o mesmo)
            document.querySelectorAll('.counter-input').forEach(counter => {
                const valueSpan = counter.querySelector('.counter-value');
                const inputName = counter.dataset.inputName;
                const minValue = parseInt(counter.dataset.minValue, 10);
                let value = parseInt(valueSpan.textContent, 10);
                formData[inputName] = value;
                counter.querySelector('.minus').addEventListener('click', () => {
                    if (value > minValue) value--;
                    valueSpan.textContent = value;
                    formData[inputName] = value;
                });
                counter.querySelector('.plus').addEventListener('click', () => {
                    value++;
                    valueSpan.textContent = value;
                    formData[inputName] = value;
                });
            });

            document.querySelectorAll('.checkbox-card').forEach(card => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const icon = card.querySelector('i');
                card.addEventListener('click', () => {
                    checkbox.checked = !checkbox.checked;
                    card.classList.toggle('border-cyan-400', checkbox.checked);
                    card.classList.toggle('bg-cyan-500/10', checkbox.checked);
                    icon.classList.toggle('text-cyan-400', checkbox.checked);
                    
                    if (card.id === 'leisure-area-checkbox-card') {
                        document.getElementById('leisure-capacity-container').classList.toggle('hidden', !checkbox.checked);
                        if (!checkbox.checked) {
                            const leisureCounter = document.querySelector('[data-input-name="leisure_area_capacity"]');
                            leisureCounter.querySelector('.counter-value').textContent = '0';
                            formData['leisure_area_capacity'] = 0;
                        }
                    }
                });
            });

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

            prefillData();
            updateUI();
        });
    </script>
</body>
</html>

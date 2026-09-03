<!-- nossos serviços fixos em grid -->
<section id="service" class="service py-5" style="background-color: #1c1c1c;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="ourheading">
                    <h2 style="font-weight: 700; color: #f0c674;">
                        Nossos<strong class="white_ll" style="color:#f0c674;"> Serviços</strong>
                    </h2>
                    <span style="color: #ccc; font-size: 1.1rem;">
                        Oferecemos serviços exclusivos para homens que valorizam qualidade e estilo
                    </span>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <?php foreach ($servicos as $servico): ?>

                <?php
                // imagem padrão
                $img = BASE_URL . "uploads/servico/sem-foto-servico.png";

                // Ajuste aqui: foto_servico já contém 'servico/nome_do_arquivo.ext'
                if (!empty($servico['foto_servico'])) {
                    $caminhoArquivo = BASE_URL . "uploads/" . $servico['foto_servico']; // corrigido aqui
                    $headers = @get_headers($caminhoArquivo);
                    if ($headers && strpos($headers[0], '200') !== false) {
                        $img = $caminhoArquivo;
                    }
                }
                ?>

                <!-- Serviço (loop) -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="service_box text-center h-100"
                         style="background: #111; border-radius: 12px; padding: 1rem; 
                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5); transition: transform 0.3s ease;">
                        <figure style="margin-bottom: 1rem; overflow: hidden; border-radius: 12px;">
                            <img src="<?= htmlspecialchars($img) ?>" alt="Foto Serviço"
                                 style="width: 100%; height: 200px; object-fit: cover; display: block;">
                        </figure>
                        <h3 style="color: #f0c674; font-weight: 700; margin-bottom: 0.5rem;">
                            <?= htmlspecialchars($servico['nome_servico'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p style="color: #eee; font-size: 0.95rem; font-style: italic; min-height: 70px;">
                            <?= htmlspecialchars($servico['descricao_servico'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>

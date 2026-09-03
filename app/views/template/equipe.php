<!-- nossos barbeiros -->
<section class="resip_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ourheading" style="margin-bottom: 30px;">
                    <h2>Conheça <strong class="white">Nossos Barbeiros</strong></h2>
                    <span>Profissionais qualificados prontos para oferecer o melhor serviço</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="equipe-grid">
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <?php if ($funcionario['cargo'] == 'Barbeiro'): ?>
                            <div class="item">
                                <div class="product_blog_img">
                                    <?php
                                    $img = BASE_URL . 'uploads/sem-foto.jpg';
                                    $fotoFuncionario = trim((string) ($funcionario['foto_funcionario'] ?? ''));
                                    $caminhoFisico = __DIR__ . '/../../../public/uploads/' . ltrim($fotoFuncionario, '/\\');

                                    if ($fotoFuncionario !== '' && file_exists($caminhoFisico)) {
                                        $img = BASE_URL . 'uploads/' . ltrim($fotoFuncionario, '/\\');
                                    }
                                    ?>
                                    <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>" alt="Foto de <?= htmlspecialchars($funcionario['nome_funcionario'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                                </div>
                                <div class="product_blog_cont">
                                    <h3><?= htmlspecialchars($funcionario['nome_funcionario'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <h4><?= htmlspecialchars($funcionario['cargo'], ENT_QUOTES, 'UTF-8') ?></h4>
                                    <p><?= !empty($funcionario['especialidade']) ? htmlspecialchars($funcionario['especialidade']) : 'Especialista em cortes modernos' ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- estilo apenas da imagem circular -->
<style>
    .equipe-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 2rem;
    }

    .product_blog_img {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 1rem;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product_blog_img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .product_blog_cont p {
        font-size: 0.95rem;
        font-style: italic;
        color: #eee;
    }

    @media (max-width: 767px) {
        .equipe-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
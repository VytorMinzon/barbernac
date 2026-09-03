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
                <div class="owl-carousel owl-theme">
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <?php if ($funcionario['cargo'] == 'Barbeiro'): ?>
                            <div class="item">
                                <div class="product_blog_img">
                                    <?php
                                    $img = BASE_URL . "uploads/sem-foto.jpg";
                                    if (!empty($funcionario['foto_funcionario'])) {
                                        $caminhoArquivo = BASE_URL . "uploads/" . $funcionario['foto_funcionario'];
                                        $headers = @get_headers($caminhoArquivo);
                                        if ($headers && strpos($headers[0], '200') !== false) {
                                            $img = $caminhoArquivo;
                                        }
                                    }
                                    ?>
                                    <img src="<?= $img ?>" alt="Foto de <?= htmlspecialchars($funcionario['nome_funcionario']) ?>" loading="lazy">
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
    </div>
</section>

<!-- estilo apenas da imagem circular -->
<style>
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
</style>
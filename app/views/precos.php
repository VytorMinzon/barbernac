<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once('template/head.php'); ?>
</head>

<body class="main-layout" id="conteudo">
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="wrapper">
        <?php require_once('template/topo.php'); ?>

        <div class="yellow_bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h2>Nossos Preços</h2>
                            <p>Qualidade premium por um preço justo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ourheading">
                            <h2>Tabela de<strong class="white"> Preços</strong></h2>
                            <p>Confira nossos valores competitivos para serviços de primeira qualidade</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mar_bottom">
                        <div class="pricing_img">
                            <figure><img src="<?= BASE_URL ?>assets/img/vvv.png" alt="Ferramentas de barbeiro" /></figure>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 pad_left">
                        <div class="pricing_box">
                            <?php
                            $categorias = [
                                'Corte' => [],
                                'Barba' => [],
                                'Tratamento' => []
                            ];

                            if (!empty($servicos)) {
                                foreach ($servicos as $servico) {
                                    if (stripos($servico['nome_servico'], 'corte') !== false) {
                                        $categorias['Corte'][] = $servico;
                                    } elseif (stripos($servico['nome_servico'], 'barba') !== false) {
                                        $categorias['Barba'][] = $servico;
                                    } else {
                                        $categorias['Tratamento'][] = $servico;
                                    }
                                }
                            }
                            ?>

                            <div class="price_tables row">
                                <?php foreach ($categorias as $categoria => $lista) : ?>
                                    <?php if (!empty($lista)) : ?>
                                        <div class="col-md-6">
                                            <div class="price_column mb-4">
                                                <h3><?= $categoria ?></h3>
                                                <ul>
                                                    <?php foreach ($lista as $servico) : ?>
                                                        <li>
                                                            <span class="float-left"><?= htmlspecialchars($servico['nome_servico']) ?></span>
                                                            <span class="float-right">R$ <?= number_format($servico['preco_base_servico'], 2, ',', '.') ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="opening">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ourheading">
                                    <h2>Horário de<strong class="white"> Funcionamento</strong></h2>
                                </div>
                            </div>
                        </div>
                        <div class="opening_bg">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="times">
                                        <ul>
                                            <li><span>Segunda-feira</span><span class="float-right">9:00 <strong class="bbbb">19:00</strong></span></li>
                                            <li><span>Terça-feira</span><span class="float-right">9:00 <strong class="bbbb">19:00</strong></span></li>
                                            <li><span>Quarta-feira</span><span class="float-right">9:00 <strong class="bbbb">19:00</strong></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="times">
                                        <ul>
                                            <li><span>Quinta-feira</span><span class="float-right">9:00 <strong class="bbbb">19:00</strong></span></li>
                                            <li><span>Sexta-feira</span><span class="float-right">9:00 <strong class="bbbb">20:00</strong></span></li>
                                            <li><span>Sábado</span><span class="float-right">9:00 <strong class="bbbb">18:00</strong></span></li>
                                            <li><span>Domingo</span><span class="float-right">Fechado</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="promo_box">
                                        <h3>Promoções Especiais</h3>
                                        <p><strong>Quarta do Degradê:</strong> Todos os cortes degradê por R$ 60</p>
                                        <p><strong>Aniversariante:</strong> 20% de desconto no mês do seu aniversário*</p>
                                        <small>*Apresentar documento com data de nascimento</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once('template/rodape.php'); ?>
    </div>

    <div class="overlay"></div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
    <script src="<?= BASE_URL ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

    <style>
        .price_column {
            background: #1c1c1c;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            height: 100%;
        }

        .price_column h3 {
            color: #f0c674;
            font-size: 1.3rem;
            border-bottom: 2px solid #f0c674;
            padding-bottom: 10px;
            margin-bottom: 15px;
            text-transform: capitalize;
        }

        .price_column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .price_column li {
            padding: 10px 0;
            border-bottom: 1px solid #444;
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
        }

        .btn_agendar {
            background: #f0c674;
            color: #333;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            display: inline-block;
        }

        .btn_agendar:hover {
            background: #e0a800;
            text-decoration: none;
        }

        .promo_box {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            color: #333;
        }
    </style>
</body>

</html>

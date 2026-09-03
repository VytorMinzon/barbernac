<!-- Pricing -->
<section class="pricing">
  <div class="container text-center">
    <div class="ourheading">
      <h2>Tabela<strong class="white"> de Preços</strong></h2>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row align-items-center">
      <!-- Imagem -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="pricing_img">
          <figure><img src="<?= BASE_URL ?>assets/img/vvv.png" alt="Ferramentas de barbeiro" /></figure>
        </div>
      </div>

      <!-- Tabela de preços -->
      <div class="col-lg-6">
        <div class="pricing_box">
          <ul class="list-unstyled">
            <?php
              // Pega os primeiros 4 serviços
              $servicos_mostrar = array_slice($servicos, 0, 4);

              if (count($servicos_mostrar) > 0) {
                foreach ($servicos_mostrar as $servico) {
                  echo '<li class="d-flex justify-content-between py-2 border-bottom">';
                  echo '<span>' . htmlspecialchars($servico['nome_servico']) . '</span>';
                  echo '<span>R$ ' . number_format($servico['preco_base_servico'], 2, ',', '.') . '</span>';
                  echo '</li>';
                }
              } else {
                echo '<li>Nenhum serviço disponível.</li>';
              }
            ?>
          </ul>

          <div class="text-end mt-4">
            <a href="<?= rtrim(BASE_URL, '/') ?>/precos" class="btn-ver-todos">Ver todos</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Opening Hours -->
<section class="opening">
  <div class="container text-center">
    <div class="ourheading">
      <h2>Horário<strong class="white"> de Funcionamento</strong></h2>
    </div>
    <div class="opening_bg row justify-content-center">
      <div class="col-md-6">
        <div class="times">
          <ul class="list-unstyled">
            <li class="d-flex justify-content-between"><span>Segunda-feira</span><span>9:00 <strong class="bbbb">19:00</strong></span></li>
            <li class="d-flex justify-content-between"><span>Terça-feira</span><span>9:00 <strong class="bbbb">19:00</strong></span></li>
            <li class="d-flex justify-content-between"><span>Quarta-feira</span><span>9:00 <strong class="bbbb">19:00</strong></span></li>
            <li class="d-flex justify-content-between"><span>Quinta-feira</span><span>9:00 <strong class="bbbb">19:00</strong></span></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6">
        <div class="times">
          <ul class="list-unstyled">
            <li class="d-flex justify-content-between"><span>Sexta-feira</span><span>9:00 <strong class="bbbb">20:00</strong></span></li>
            <li class="d-flex justify-content-between"><span>Sábado</span><span>9:00 <strong class="bbbb">18:00</strong></span></li>
            <li class="d-flex justify-content-between"><span>Domingo</span><span>Fechado</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* Lista preços */
  .pricing_box ul {
    padding-left: 0;
    margin: 0;
  }

  .pricing_box ul li {
    font-size: 1.1rem;
  }

  .btn-ver-todos {
    background-color: #f0c674;
    color: #000;
    padding: 10px 25px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
  }
  .btn-ver-todos:hover {
    background-color: #e0a800;
    color: #000;
    text-decoration: none;
  }

  /* Responsividade */
  @media (max-width: 767.98px) {
    .pricing_box ul li {
      font-size: 1rem;
    }
  }
</style>

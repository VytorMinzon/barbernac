<footer class="modern-footer">
  <div class="modern-footer-inner">
    <div class="modern-footer-main">
      <section class="modern-footer-brand">
        <a href="<?= BASE_URL ?>home" aria-label="BarberNac, início">
          <img src="<?= BASE_URL ?>assets/img/logo1.png" alt="BarberNac">
        </a>
        <p>Tradição, estilo e cuidado para valorizar sua identidade. Uma experiência de barbearia feita para você.</p>
        <a class="modern-footer-cta" href="<?= BASE_URL ?>contato">Agendar horário <span aria-hidden="true">&rarr;</span></a>
      </section>

      <section class="modern-footer-column">
        <h2>Explorar</h2>
        <a href="<?= BASE_URL ?>home">Início</a>
        <a href="<?= BASE_URL ?>servico">Serviços</a>
        <a href="<?= BASE_URL ?>barbeiros">Barbeiros</a>
        <a href="<?= BASE_URL ?>contato">Contato</a>
      </section>

      <section class="modern-footer-column">
        <h2>Funcionamento</h2>
        <p><strong>Terça a sexta</strong><br>09:00 às 20:00</p>
        <p><strong>Sábado</strong><br>09:00 às 18:00</p>
        <p class="modern-footer-muted">Domingo e segunda: fechado</p>
      </section>

      <section class="modern-footer-column">
        <h2>Fale conosco</h2>
        <p>Rua dos Barbeiros, 123<br>Centro, São Paulo - SP</p>
        <a href="tel:+5511987654321">(11) 98765-4321</a>
        <a href="mailto:contato@corteestilo.com">contato@corteestilo.com</a>
        <div class="modern-footer-socials" aria-label="Redes sociais">
          <a href="#" aria-label="Instagram">ig</a>
          <a href="#" aria-label="Facebook">fb</a>
          <a href="#" aria-label="YouTube">yt</a>
        </div>
      </section>
    </div>

    <div class="modern-footer-bottom">
      <span>&copy; <?= date('Y') ?> BarberNac</span>
      <span>Feito com cuidado para quem valoriza estilo.</span>
    </div>
  </div>
</footer>


<!-- Modal -->
<div class="modal fade modalLogin" id="modalLogin" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login - BarberNac</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


        <!-- Corpo do modal com o formulário -->
        <form method="POST" action="<?= BASE_URL ?>auth/login">
          <div class="modal-body">
            <div class="form-group">
              <label for="email">E-mail:</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="senha">Senha:</label>
              <input type="password" name="senha" id="senha" class="form-control" required>
            </div>


            <?php if (isset($_GET['login-erro'])): ?>
              <div class="alert alert-danger">
                <?php echo "Preencha todos os dados"; ?>
              </div>
            <?php endif; ?>

          </div>
          <!-- Rodapé do modal com os botões -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>
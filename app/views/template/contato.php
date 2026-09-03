<!-- Contact -->
<section id="contact" class="contact py-5" style="background-color: #1c1c1c; color: #f0c674;">
  <div class="container">
    <!-- Título -->
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h2 class="fw-bold" style="font-size: 2.5rem;">Acesse o <span style="color: #ffffff;">Aplicativo</span></h2>
        <p class="text-white fs-5">
          Escaneie o QR Code para agendar seu horário com facilidade
        </p>
      </div>
    </div>

    <!-- QR Code e texto -->
    <div class="row align-items-center">
      <!-- QR Code -->
      <div class="col-lg-6 mb-4 mb-lg-0 d-flex justify-content-center">
        <div class="p-4" style="background-color: #2a2a2a; border-radius: 1rem; box-shadow: 0 0 20px rgba(240,198,116,0.2);">
          <img src="<?= BASE_URL ?>assets/img/qrcode.png" alt="QR Code" class="img-fluid" style="max-width: 280px;">
        </div>
      </div>

      <!-- Chamada ao lado -->
      <div class="col-lg-6 text-center text-lg-start">
        <div class="p-4 rounded" style="background-color: #2a2a2a;">
          <h4 class="fw-bold" style="color: #ffffff;">Agende seu horário com rapidez</h4>
          <p style="color: #dddddd;">Com o nosso aplicativo, você pode escolher o serviço, o profissional e o horário de forma simples e prática. Basta escanear o código ao lado para começar!</p>
          <a href="<?= BASE_URL ?>auth/login" class="btn mt-3" style="background-color: #f0c674; color: #000; font-weight: bold; border-radius: 0.5rem;">
            Baixar Aplicativo
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
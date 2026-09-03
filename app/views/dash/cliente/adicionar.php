<form method="POST" action="<?= BASE_URL ?>cliente/adicionar" enctype="multipart/form-data">


  <div class="container my-5">
    <div class="row">
      <!-- Imagem do Cliente -->
      <div class="col-md-4">
        <img src="<?= BASE_URL ?>uploads/cliente/sem-foto-cliente.png" alt="barbernac Logo" class="img-fluid" id="preview-img" style="width:100%; cursor:pointer;">
        <input type="file" name="foto_cliente" id="foto_cliente" style="display: none;" accept="image/*">
      </div>

      <div class="col-md-8">
        <!-- Nome -->
        <div class="mb-3">
          <label for="nome_cliente" class="form-label">Nome Completo:</label>
          <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
        </div>

        <!-- Tipo Cliente e CPF/CNPJ -->
        <div class="row g-3">
          <div class="col-md-6">
            <label for="tipo_cliente" class="form-label">Tipo de Cliente:</label>
            <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
              <option value="Física">Pessoa Física</option>
              <option value="Jurídica">Pessoa Jurídica</option>
            </select>
          </div>
        </div>

        <!-- E-mail e Senha -->
        <div class="row g-3">
          <div class="col-md-6">
            <label for="email_cliente" class="form-label">E-mail:</label>
            <input type="email" class="form-control" id="email_cliente" name="email_cliente" required>
          </div>
          <div class="col-md-6">
            <label for="senha_cliente" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" required maxlength="8">
          </div>
        </div>

        <!-- Data de Nascimento, Telefone e Status -->
        <div class="row g-3">
          <div class="col-md-4">
            <label for="data_nasc_cliente" class="form-label">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nasc_cliente" name="data_nasc_cliente" required>
          </div>
          <div class="col-md-4">
            <label for="telefone_cliente" class="form-label">Telefone:</label>
            <input type="tel" class="form-control" id="telefone_cliente" name="telefone_cliente"
              required maxlength="15" placeholder="(11) 99999-9999">
          </div>
          <div class="col-md-4">
            <label for="status_cliente" class="form-label">Status:</label>
            <select class="form-select" id="status_cliente" name="status_cliente" required>
              <option>Ativo</option>
              <option>Inativo</option>
            </select>
          </div>
        </div>

        <!-- Estado -->
        <div class="row g-3">
          <div class="col-md-4">
            <label for="id_uf" class="form-label">Estado:</label>
            <select class="form-select" id="id_uf" name="id_uf" required>
              <option selected>Selecione</option>
              <?php foreach ($estados as $linha): ?>
                <option value="<?php echo $linha['id_uf']; ?>"><?php echo $linha['nome_uf']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Botões -->
        <div class="mt-4">
          <button type="submit" class="btn btn-success">Salvar</button>
          <a href="<?= BASE_URL ?>cliente/listar" class="btn btn-secondary">Cancelar</a>
        </div>
      </div>
    </div>
  </div>
</form>


<style>
  /* Mesmos estilos do form de edição para inputs e selects */
  input.form-control,
  select.form-select {
    background-color: rgba(28, 30, 34, 0.8);
    color: #f0c674 !important;
    border: 1.8px solid #f0c674;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    box-shadow: none;
    width: 100%;
    appearance: none;
    outline: none;
    cursor: text;
  }

  input.form-control::placeholder {
    color: #d4b94fcc;
  }

  select.form-select {
    cursor: pointer;
    background-image:
      url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" fill="none" stroke="%23f0c674" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 1 6 6 11 1"/></svg>');
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 12px 8px;
  }

  input.form-control:hover,
  select.form-select:hover,
  input.form-control:focus,
  select.form-select:focus {
    border-color: #e5b84e;
    box-shadow: 0 0 8px rgba(224, 183, 68, 0.6);
    background-color: rgba(28, 30, 34, 0.95);
    color: #f0c674 !important;
  }

  select.form-select option:checked {
    background-color: #f0c674;
    color: #1c1e22;
    font-weight: 600;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // --- Preview da imagem ---
    const visualizarImg = document.getElementById('preview-img');
    const arquivo = document.getElementById('foto_cliente');

    visualizarImg.addEventListener('click', function() {
      arquivo.click();
    });

    arquivo.addEventListener('change', function() {
      if (arquivo.files && arquivo.files[0]) {
        let file = arquivo.files[0];

        if (!file.type.startsWith("image/")) {
          alert("Por favor, selecione um arquivo de imagem válido!");
          return;
        }

        let reader = new FileReader();
        reader.onload = function(e) {
          visualizarImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    // --- Máscara de telefone ---
    const telefone = document.getElementById('telefone_cliente');

    telefone.addEventListener('input', function(e) {
      let input = e.target.value.replace(/\D/g, '');

      if (input.length > 11) input = input.slice(0, 11);

      let formatado = '';

      if (input.length > 0) {
        formatado = '(' + input.substring(0, 2);
      }
      if (input.length >= 3) {
        formatado += ') ' + input.substring(2, 7);
      }
      if (input.length >= 8) {
        formatado += '-' + input.substring(7, 11);
      }

      e.target.value = formatado;
    });

  });
</script>
<style>
  input.form-control,
  select.form-select {
    background-color: rgba(28, 30, 34, 0.8);
    color: #f0c674 !important;
    border: 1.8px solid #f0c674;
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: none;
    appearance: none;
    outline: none;
  }

  input.form-control::placeholder {
    color: #d4b94fcc;
  }

  select.form-select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='none' stroke='%23f0c674' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='1 1 6 6 11 1'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 12px 8px;
  }

  input.form-control:focus,
  select.form-select:focus {
    border-color: #e5b84e;
    box-shadow: 0 0 8px rgba(224, 183, 68, 0.6);
    background-color: rgba(28, 30, 34, 0.95);
    color: #fff !important;
    /* texto branco ao focar */
  }

  .senha-wrapper {
    position: relative;
  }

  .toggle-senha {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #f0c674;
    cursor: pointer;
  }
</style>

<form method="POST" action="<?= BASE_URL ?>cliente/editar/<?= $cliente['id']; ?>" enctype="multipart/form-data">
  <div class="container my-5">
    <div class="row">
      <!-- Imagem -->
      <div class="col-md-4">
        <?php
        $caminhoArquivo = BASE_URL . "uploads/" . $cliente['foto_cliente'];
        $img = BASE_URL . "uploads/sem-foto.jpg";

        if (!empty($cliente['foto_cliente'])) {
          $headers = @get_headers($caminhoArquivo);
          if ($headers && strpos($headers[0], '200') !== false) {
            $img = $caminhoArquivo;
          }
        }
        ?>
        <img src="<?= $img ?>" alt="Foto do Cliente" class="img-fluid" id="preview-img" style="width:100%; cursor:pointer;">
        <input type="file" name="foto_cliente" id="foto_cliente" style="display: none;" accept="image/*">
      </div>

      <div class="col-md-8">
        <!-- Nome -->
        <div class="mb-3">
          <label for="nome_cliente" class="form-label">Nome Completo:</label>
          <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
        </div>

        <!-- Tipo e CPF/CNPJ -->
        <div class="row g-3">
          <div class="col-md-6">
            <label for="tipo_cliente" class="form-label">Tipo de Cliente:</label>
            <select class="form-select" id="tipo_cliente" name="tipo_cliente" required>
              <option value="Física" <?= ($cliente['tipo_cliente'] == 'Física') ? 'selected' : '' ?>>Pessoa Física</option>
              <option value="Jurídica" <?= ($cliente['tipo_cliente'] == 'Jurídica') ? 'selected' : '' ?>>Pessoa Jurídica</option>
            </select>
          </div>
        </div>

        <!-- Email e Senha -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label for="email_cliente" class="form-label">E-mail:</label>
            <input type="email" class="form-control" id="email_cliente" name="email_cliente" value="<?= htmlspecialchars($cliente['email']) ?>" required>
          </div>
          <div class="col-md-6">
            <label for="senha_cliente" class="form-label">Senha:</label>
            <div class="senha-wrapper">
              <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="••••••••" maxlength="8">
              <button type="button" class="toggle-senha" onclick="toggleSenha()">
                <i class="fas fa-eye" id="icone-olho"></i>
              </button>
            </div>
            <small class="text-muted">Deixe em branco para manter a senha atual.</small>
          </div>
        </div>

        <!-- Nascimento, Telefone, Status -->
        <div class="row g-3 mt-2">
          <div class="col-md-4">
            <label for="data_nasc_cliente" class="form-label">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nasc_cliente" name="data_nasc_cliente" value="<?= $cliente['data_nasc_cliente'] ?>" required>
          </div>
          <div class="col-md-4">
            <label for="telefone_cliente" class="form-label">Telefone:</label>
            <input type="tel" class="form-control" id="telefone_cliente" name="telefone_cliente" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>
          </div>
          <div class="col-md-4">
            <label for="status_cliente" class="form-label">Status:</label>
            <select class="form-select" id="status_cliente" name="status_cliente" required>
              <option value="Ativo" <?= ($cliente['status_cliente'] == 'Ativo') ? 'selected' : '' ?>>Ativo</option>
              <option value="Inativo" <?= ($cliente['status_cliente'] == 'Inativo') ? 'selected' : '' ?>>Inativo</option>
            </select>
          </div>
        </div>

        <!-- Estado -->
        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label for="id_uf" class="form-label">Estado:</label>
            <select class="form-select" id="id_uf" name="id_uf" required>
              <option value="">Selecione</option>
              <?php foreach ($estados as $linha): ?>
                <option value="<?= $linha['id_uf'] ?>" <?= ($cliente['id_uf'] == $linha['id_uf']) ? 'selected' : '' ?>>
                  <?= $linha['nome_uf'] ?>
                </option>
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

<!-- Scripts -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('preview-img');
    const input = document.getElementById('foto_cliente');

    preview.addEventListener('click', () => input.click());

    input.addEventListener('change', function() {
      if (input.files && input.files[0]) {
        let file = input.files[0];
        if (!file.type.startsWith("image/")) {
          alert("Por favor, selecione uma imagem válida.");
          return;
        }
        let reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  });

  function toggleSenha() {
    const campo = document.getElementById('senha_cliente');
    const icone = document.getElementById('icone-olho');
    if (campo.type === 'password') {
      campo.type = 'text';
      icone.classList.remove('fa-eye');
      icone.classList.add('fa-eye-slash');
    } else {
      campo.type = 'password';
      icone.classList.remove('fa-eye-slash');
      icone.classList.add('fa-eye');
    }
  }


  // Máscara de telefone
document.addEventListener('DOMContentLoaded', function () {
  const telefone = document.getElementById('telefone_cliente');

  telefone.addEventListener('input', function (e) {
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
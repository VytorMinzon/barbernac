

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

<form method="POST" action="<?= BASE_URL ?>funcionario/adicionar" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">
            <!-- Foto do Funcionário -->
            <div class="col-md-4">
                <img src="<?= BASE_URL ?>uploads/sem-foto.png" alt="Foto do Funcionário" class="img-fluid" id="preview-img" style="width:100%; cursor:pointer;">
                <input type="file" name="foto_funcionario" id="foto_funcionario" style="display:none;" accept="image/*">
            </div>

            <div class="col-md-8">
                <!-- Nome -->
                <div class="mb-3">
                    <label for="nome_funcionario" class="form-label">Nome do Funcionário:</label>
                    <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" required>
                </div>

                <!-- Tipo e CPF/CNPJ -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tipo_funcionario" class="form-label">Tipo de Funcionário:</label>
                        <select class="form-select" id="tipo_funcionario" name="tipo_funcionario" required>
                            <option value="Física">Pessoa Física</option>
                            <option value="Jurídica">Pessoa Jurídica</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cpf_cnpj_funcionario" class="form-label">CPF/CNPJ:</label>
                        <input type="text" class="form-control" id="cpf_cnpj_funcionario" name="cpf_cnpj_funcionario" required>
                    </div>
                </div>

                <!-- E-mail e Senha -->
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 position-relative">
                        <label for="senha" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required maxlength="8" style="padding-right: 70px;">
                        <button type="button" id="toggleSenha" class="btn btn-outline-secondary position-absolute"
                            style="top: 38px; right: 10px; padding: 2px 8px; font-size: 0.85rem;">
                            Mostrar
                        </button>
                    </div>
                </div>

                <!-- Telefone, Cargo e Salário -->
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cargo" class="form-label">Cargo:</label>
                        <select class="form-select" id="cargo" name="cargo" required>
                            <option value="">Selecione</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Barbeiro">Barbeiro</option>
                            <option value="Recepcionista">Recepcionista</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="salario_funcionario" class="form-label">Salário:</label>
                        <input type="number" step="0.01" class="form-control" id="salario_funcionario" name="salario_funcionario">
                    </div>
                </div>

                <!-- Estado e Status -->
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="id_uf" class="form-label">Estado:</label>
                        <select class="form-select" id="id_uf" name="id_uf" required>
                            <option value="">Selecione</option>
                            <?php foreach ($estados as $linha): ?>
                                <option value="<?php echo $linha['id_uf']; ?>"><?php echo $linha['nome_uf']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status_funcionario" class="form-label">Status:</label>
                        <select class="form-select" id="status_funcionario" name="status_funcionario" required>
                            <option value="Ativo" selected>Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
                    </div>
                </div>

                <!-- Botões -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="<?= BASE_URL ?>funcionario/listar" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview da imagem
        const preview = document.getElementById('preview-img');
        const inputFile = document.getElementById('foto_funcionario');

        preview.addEventListener('click', () => inputFile.click());

        inputFile.addEventListener('change', function() {
            if (inputFile.files && inputFile.files[0]) {
                const file = inputFile.files[0];
                if (!file.type.startsWith("image/")) {
                    alert("Por favor, selecione uma imagem válida.");
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Toggle senha mostrar/ocultar
        const senhaInput = document.getElementById('senha');
        const toggleBtn = document.getElementById('toggleSenha');

        toggleBtn.addEventListener('click', function() {
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                toggleBtn.textContent = 'Ocultar';
            } else {
                senhaInput.type = 'password';
                toggleBtn.textContent = 'Mostrar';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const telefone = document.getElementById('telefone');

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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const campoCpfCnpj = document.getElementById('cpf_cnpj_funcionario');

        campoCpfCnpj.addEventListener('input', function (e) {
            let input = e.target.value.replace(/\D/g, ''); // remove tudo que não for dígito

            if (input.length <= 11) {
                // CPF: 000.000.000-00
                input = input.substring(0, 11);
                if (input.length >= 3) {
                    input = input.replace(/^(\d{3})(\d)/, '$1.$2');
                }
                if (input.length >= 6) {
                    input = input.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                }
                if (input.length >= 9) {
                    input = input.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
                }
            } else {
                // CNPJ: 00.000.000/0000-00
                input = input.substring(0, 14);
                if (input.length >= 2) {
                    input = input.replace(/^(\d{2})(\d)/, '$1.$2');
                }
                if (input.length >= 5) {
                    input = input.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                }
                if (input.length >= 8) {
                    input = input.replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4');
                }
                if (input.length >= 12) {
                    input = input.replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/, '$1.$2.$3/$4-$5');
                }
            }

            e.target.value = input;
        });
    });
</script>
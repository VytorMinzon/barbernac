<?php
$fotoServico = $servico['foto_servico'] ?? '';
$caminhoFoto = BASE_URL . "uploads/servico/" . $fotoServico;
$img = BASE_URL . "uploads/servico/sem-foto-servico.png";

if (!empty($fotoServico)) {
    $headers = @get_headers($caminhoFoto);
    if ($headers && strpos($headers[0], '200') !== false) {
        $img = $caminhoFoto;
    }
}
?>

<style>
    /* Mesma estilização dos inputs e botões que do funcionário */
    input.form-control,
    select.form-select,
    textarea.form-control {
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

    input.form-control::placeholder,
    textarea.form-control::placeholder {
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
    textarea.form-control:hover,
    input.form-control:focus,
    select.form-select:focus,
    textarea.form-control:focus {
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

    .img-fluid {
        border-radius: 0.5rem;
        border: 2px solid #f0c674;
        object-fit: cover;
        width: 100%;
        max-height: 250px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .img-fluid:hover {
        transform: scale(1.02);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
        border-color: #5a6268;
    }
</style>

<form method="POST" action="<?= BASE_URL ?>servico/editar/<?= $servico['id_servico'] ?>" enctype="multipart/form-data">
    <div class="container my-5">
        <div class="row">
            <!-- Imagem do Serviço -->
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($img) ?>" alt="Foto do Serviço" class="img-fluid" id="preview-img" title="Clique para trocar a foto">
                <input type="file" name="foto_servico" id="foto_servico" style="display: none;" accept="image/*">
            </div>

            <!-- Campos do formulário -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="nome_servico" class="form-label">Nome do Serviço:</label>
                    <input type="text" class="form-control" id="nome_servico" name="nome_servico" value="<?= htmlspecialchars($servico['nome_servico']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descricao_servico" class="form-label">Descrição do Serviço:</label>
                    <textarea id="descricao_servico" name="descricao_servico" rows="3" class="form-control" required><?= htmlspecialchars($servico['descricao_servico']) ?></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="preco_base_servico" class="form-label">Preço Base:</label>
                        <input type="number" step="0.01" class="form-control" id="preco_base_servico" name="preco_base_servico" value="<?= htmlspecialchars($servico['preco_base_servico']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tempo_estimado_servico" class="form-label">Tempo Estimado:</label>
                        <input type="time" class="form-control" id="tempo_estimado_servico" name="tempo_estimado_servico" value="<?= htmlspecialchars($servico['tempo_estimado_servico']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="status_servico" class="form-label">Status:</label>
                        <select name="status_servico" id="status_servico" class="form-select" required>
                            <option value="Ativo" <?= $servico['status_servico'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="Inativo" <?= $servico['status_servico'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="<?= BASE_URL ?>servico/listar" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewImg = document.getElementById('preview-img');
        const inputFile = document.getElementById('foto_servico');

        previewImg.addEventListener('click', () => inputFile.click());

        inputFile.addEventListener('change', function () {
            if (inputFile.files && inputFile.files[0]) {
                const file = inputFile.files[0];
                if (!file.type.startsWith("image/")) {
                    alert("Por favor, selecione uma imagem válida.");
                    inputFile.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

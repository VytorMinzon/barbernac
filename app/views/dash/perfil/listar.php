<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && isset($_SESSION['tipo-msg'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipo = $_SESSION['tipo-msg'];

    if ($tipo == 'sucesso') {
        echo '<div class="alert alert-success" role="alert">' . $mensagem . '</div>';
    } elseif ($tipo == 'erro') {
        echo '<div class="alert alert-danger" role="alert">' . $mensagem . '</div>';
    }

    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo-msg']);
}
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        background: rgba(28, 30, 34, 0.6);
        border: 1px solid #f0c674;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(240, 198, 116, 0.15);
        backdrop-filter: blur(8px);
        padding: 2rem;
        color: #fff;
    }

    .form-container label {
        color: #f0c674;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Estilo base uniforme */
    .form-control,
    select.form-control {
        background-color: rgba(17, 17, 17, 0.6) !important;
        color: #ffffff !important;
        border: 1px solid #ccc !important;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        margin-bottom: 1rem;
        font-size: 1rem;
        box-shadow: none !important;
        outline: none !important;
        transition: none !important;
    }

    /* Remove hover e focus background/text color */
    .form-control:hover,
    .form-control:focus,
    select.form-control:hover,
    select.form-control:focus {
        background-color: rgba(17, 17, 17, 0.6) !important;
        color: #ffffff !important;
        border-color: #f0c674 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    select.form-control option {
        background-color: #1c1e22;
        color: #ffffff;
    }

    .btn-save {
        background-color: #f0c674;
        color: #1c1e22;
        font-weight: bold;
        border: none;
        border-radius: 0.5rem;
        padding: 0.6rem 1.2rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-save:hover {
        background-color: #e5b84e;
        color: #000;
        transform: translateY(-2px);
    }


    .profile-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #f0c674;
        margin-bottom: 1rem;
        cursor: pointer;
    }

    .form-control::placeholder {
        color: #ccc;
    }

    input[type="file"].form-control.d-none {
        display: none;
    }

    /* Remove highlight azul em navegadores */
    input:focus-visible,
    select:focus-visible {
        outline: none !important;
    }
</style>


<div class="form-container">
    <h2 class="text-center mb-4" style="color: #f0c674;">Perfil do Cliente</h2>

    <?php if (!empty($cliente)): ?>
        <form action="<?= BASE_URL ?>clientes/salvarAlteracoes/<?= $cliente['id'] ?>" method="POST" enctype="multipart/form-data">

            <?php
            $basePath = BASE_URL . "uploads/clientes/";
            $fotoPath = $basePath . ($cliente['foto_cliente'] ?? 'sem-foto.jpg');
            $localPath = $_SERVER['DOCUMENT_ROOT'] . "/barbernac/public/uploads/clientes/" . ($cliente['foto_cliente'] ?? '');

            if (empty($cliente['foto_cliente']) || !file_exists($localPath)) {
                $fotoPath = $basePath . "sem-foto.jpg";
            }
            ?>

            <div class="text-center mb-3">
                <label for="foto_cliente" title="Clique para alterar a foto">
                    <img src="<?= $fotoPath ?>" alt="Foto do Cliente" class="profile-photo" id="previewFoto">
                </label>
                <input type="file" name="foto_cliente" id="foto_cliente" class="form-control d-none" accept="image/*" onchange="previewFoto(event)">
                <div class="mt-2">
                    <button type="button" class="btn btn-save btn-sm" onclick="document.getElementById('foto_cliente').click();">
                        <i class="fas fa-upload"></i> Selecionar nova foto
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="senha">Senha (deixe em branco para manter a atual)</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite uma nova senha, se quiser">
            </div>

            <div class="mb-3">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>">
            </div>

            <div class="mb-3">
                <label for="id_uf">Estado (UF)</label>
                <select name="id_uf" id="id_uf" class="form-control" required>
                    <option value="">Selecione o estado</option>
                    <?php if (!empty($estados)): ?>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= $estado['id_uf'] ?>" <?= ($cliente['id_uf'] == $estado['id_uf']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($estado['nome_uf']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="data_nasc_cliente">Data de Nascimento</label>
                <input type="date" name="data_nasc_cliente" id="data_nasc_cliente" class="form-control" value="<?= htmlspecialchars($cliente['data_nasc_cliente']) ?>">
            </div>

            <div class="mb-3">
                <label for="tipo_cliente">Tipo de Cliente</label>
                <select name="tipo_cliente" id="tipo_cliente" class="form-control">
                    <option value="Física" <?= ($cliente['tipo_cliente'] == 'Física') ? 'selected' : '' ?>>Física</option>
                    <option value="Jurídica" <?= ($cliente['tipo_cliente'] == 'Jurídica') ? 'selected' : '' ?>>Jurídica</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cpf_cnpj_cliente">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj_cliente" id="cpf_cnpj_cliente" class="form-control" value="<?= htmlspecialchars($cliente['cpf_cnpj_cliente']) ?>">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save me-2"></i>Salvar Alterações
                </button>
            </div>
        </form>
    <?php else: ?>
        <p class="text-center">Cliente não encontrado.</p>
    <?php endif; ?>
</div>

<script>
    function previewFoto(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
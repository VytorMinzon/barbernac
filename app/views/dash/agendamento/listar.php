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

<div class="my-5">
    <h2 class="text-center fw-bold py-3" style="background:rgba(37, 37, 37, 0.57); color: #f0c674; border-radius: 12px;">
        Agendamentos Cadastrados
    </h2>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle table-glass">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Funcionário</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Status</th>
                <th>Editar</th>
                <th>Cancelar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?= htmlspecialchars($agendamento['nome_cliente']) ?></td>
                    <td><?= htmlspecialchars($agendamento['nome_funcionario']) ?></td>
                    <td><?= htmlspecialchars($agendamento['nome_servico']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($agendamento['data_agendamento'])) ?></td>
                    <td>
                        <?php
                        $status = $agendamento['status'];
                        $classeStatus = '';
                        switch ($status) {
                            case 'Agendado':
                                $classeStatus = 'text-success';
                                break;
                            case 'Concluído':
                                $classeStatus = 'text-primary';
                                break;
                            case 'Cancelado':
                                $classeStatus = 'text-danger';
                                break;
                        }
                        ?>
                        <span class="<?= $classeStatus ?>"><?= $status ?></span>
                    </td>
                    <td>
                        <a href="<?= BASE_URL . 'agendamento/editar/' . $agendamento['id'] ?>" class="btn btn-glass" title="Editar">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-glass btn-glass-danger" title="Cancelar" onclick="abrirModalCancelar(<?= $agendamento['id'] ?>)">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de Cancelamento -->
<div class="modal" tabindex="-1" id="modalCancelar">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar Agendamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja cancelar esse agendamento?</p>
                <input type="hidden" id="idAgendamentoCancelar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarCancelamento">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalCancelar(id) {
        document.getElementById('idAgendamentoCancelar').value = id;
        var modal = new bootstrap.Modal(document.getElementById('modalCancelar'));
        modal.show();
    }

    document.getElementById('btnConfirmarCancelamento').addEventListener('click', function() {
        const id = document.getElementById('idAgendamentoCancelar').value;

        fetch("<?= BASE_URL ?>agendamento/desativar/" + id)
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    window.location.reload();
                } else {
                    alert("Erro ao cancelar o agendamento.");
                }
            });
    });
</script>


<!-- Estilo e FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .table-glass {
        min-width: 900px;
        background: rgba(28, 30, 34, 0.33);
        border: 1px solid #f0c674;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(240, 198, 116, 0.15);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .table-glass:hover {
        box-shadow: 0 12px 28px rgba(240, 198, 116, 0.25);
        transform: translateY(-2px);
    }

    .table-glass th {
        background: linear-gradient(90deg, rgba(32, 32, 32, 1), rgba(24, 24, 24, 1));
        color: #f0c674 !important;
        font-weight: bold;
        text-align: center;
        padding: 1rem;
        white-space: nowrap;
    }

    .table-glass td {
        background-color: rgba(17, 17, 17, 0.5);
        color: #f8f8f8;
        padding: 0.75rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: background 0.2s ease;
    }

    .table-glass tr:hover td {
        background-color: rgba(240, 198, 116, 0.06);
    }

    .img-thumbnail {
        border-radius: 50%;
        border: 2px solid #f0c674;
        background-color: rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
    }

    .btn-glass {
        border: 1px solid transparent;
        border-radius: 0.5rem;
        padding: 0.4rem 0.6rem;
        background: rgba(255, 255, 255, 0.05);
        color: #f0c674;
        transition: all 0.3s ease;
    }

    .btn-glass:hover {
        background: rgba(240, 198, 116, 0.2);
        color: #fff;
    }

    .btn-glass-danger:hover {
        background: rgba(255, 0, 0, 0.25);
        color: #fff;
    }

    .btn-add {
        background-color: #f0c674;
        color: #1c1e22;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background-color: #e5b84e;
        transform: translateY(-2px);
    }
</style>
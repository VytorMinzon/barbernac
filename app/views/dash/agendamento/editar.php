<style>
  .custom-select-style {
    background-color: #f0c674 !important;
    color: #000 !important;
    height: 44px !important;
    padding: 0.375rem 0.75rem !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    box-shadow: none !important;
    outline: none !important;
    appearance: none;
    width: 200px !important;
    display: block;
  }

  .custom-select-style:focus {
    box-shadow: none !important;
    border-color: #ced4da !important;
  }

  .custom-select-style option:checked {
    background-color: #d4a94a;
    color: #000;
  }

  .custom-width {
    width: 200px !important;
  }

  .form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }
</style>

<form method="POST" action="<?= BASE_URL ?>agendamento/editar/<?= $agendamento['id'] ?>">
  <div class="container my-5">
    <h2 class="mb-4" style="color: #f0c674; font-weight: 700;">Editar Agendamento</h2>

    <!-- Funcionário -->
    <div class="mb-4">
      <label for="funcionario_id" class="form-label">Funcionário</label>
      <select class="custom-select-style" name="id_funcionario" id="funcionario_id" required>
        <option value="" disabled>Selecione o funcionário</option>
        <?php foreach ($funcionarios as $func): ?>
          <option value="<?= $func['id'] ?>" <?= $agendamento['id_funcionario'] == $func['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($func['nome_funcionario']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Serviço -->
    <div class="mb-4">
      <label for="servico_id" class="form-label">Serviço</label>
      <select class="custom-select-style" name="id_servico" id="servico_id" required>
        <option value="" disabled>Selecione o serviço</option>
        <?php foreach ($servicos as $serv): ?>
          <option value="<?= $serv['id_servico'] ?>" <?= $agendamento['id_servico'] == $serv['id_servico'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($serv['nome_servico']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Data e Hora -->
    <div class="mb-4">
      <label for="data_agendamento" class="form-label">Data e Hora</label>
      <input
        type="datetime-local"
        class="form-control custom-width"
        name="data_agendamento"
        id="data_agendamento"
        value="<?= date('Y-m-d\TH:i', strtotime($agendamento['data_agendamento'])) ?>"
        required
      >
    </div>

    <!-- Status -->
    <div class="mb-4">
      <label for="status" class="form-label">Status</label>
      <select name="status_agendamento" id="status" class="custom-select-style" required>
        <?php
          $statusPossiveis = ['Concluído', 'Cancelado', 'Em análise', 'Confirmado'];
          foreach ($statusPossiveis as $statusOption) {
            $selected = ($agendamento['status_agendamento'] === $statusOption) ? 'selected' : '';
            echo "<option value=\"$statusOption\" $selected>$statusOption</option>";
          }
        ?>
      </select>
    </div>

    <!-- Botões com espaçamento -->
    <div class="mt-4 d-flex">
      <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
      <a href="<?= BASE_URL ?>agendamento/listar" class="btn btn-outline-secondary px-4" style="margin-left: 1rem;">Cancelar</a>
    </div>
  </div>
</form>

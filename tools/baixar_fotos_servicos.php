<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("Execute este script pelo terminal.\n");
}

require_once __DIR__ . '/../config/config.php';

$diretorioUploads = __DIR__ . '/../public/uploads/';
$diretorioImagens = $diretorioUploads . 'servico/';
$executar = in_array('--execute', $argv, true);

if (!is_dir($diretorioImagens) && !mkdir($diretorioImagens, 0755, true) && !is_dir($diretorioImagens)) {
    throw new RuntimeException('Nao foi possivel criar o diretorio de imagens.');
}

try {
    $pdo = new PDO(
        'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $servicos = $pdo->query(
        "SELECT id_servico, nome_servico, foto_servico
         FROM tbl_servico
         ORDER BY id_servico"
    )->fetchAll(PDO::FETCH_ASSOC);

    if (!$servicos) {
        echo "Nenhum servico foi encontrado.\n";
        exit(0);
    }

    if (!$executar) {
        echo "Modo simulacao. Nenhuma alteracao foi gravada. Use --execute para confirmar.\n";
    }

    $atualizacoes = [];
    foreach ($servicos as $servico) {
        $id = (int) $servico['id_servico'];
        $fotoBanco = trim((string) $servico['foto_servico']);
        $fotoFisica = $fotoBanco !== ''
            ? $diretorioUploads . ltrim($fotoBanco, '/\\')
            : '';

        if ($fotoBanco !== '' && !file_exists($fotoFisica)) {
            printf(
                "AUSENTE | #%d | %s | %s\n",
                $id,
                $servico['nome_servico'],
                $fotoBanco
            );
        } elseif ($fotoBanco !== '') {
            continue;
        }

        $nomeArquivo = 'servico-' . $id . '.jpg';
        $caminhoFisico = $diretorioImagens . $nomeArquivo;
        $urlImagem = 'https://loremflickr.com/1200/800/barbershop,haircut,beard?lock=' . $id;

        if ($executar) {
            $curl = curl_init($urlImagem);
            curl_setopt_array($curl, [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_USERAGENT => 'BarberNac image updater',
            ]);
            $conteudo = curl_exec($curl);
            $statusHttp = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $tipoConteudo = (string) curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            $erroCurl = curl_error($curl);
            curl_close($curl);

            if ($conteudo === false || $statusHttp < 200 || $statusHttp >= 300 || strpos($tipoConteudo, 'image/') !== 0) {
                throw new RuntimeException(
                    "Falha ao baixar a imagem do servico #{$id}: " . ($erroCurl ?: "HTTP {$statusHttp}")
                );
            }

            if (file_put_contents($caminhoFisico, $conteudo, LOCK_EX) === false) {
                throw new RuntimeException("Falha ao salvar {$caminhoFisico}.");
            }
        }

        $atualizacoes[] = [
            'id' => $id,
            'nome' => $servico['nome_servico'],
            'antes' => $servico['foto_servico'] ?: '(vazio)',
            'depois' => 'servico/' . $nomeArquivo,
            'url' => $urlImagem,
        ];
    }

    if ($executar) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare(
            'UPDATE tbl_servico SET foto_servico = :foto_servico WHERE id_servico = :id_servico'
        );

        foreach ($atualizacoes as $atualizacao) {
            $stmt->execute([
                ':foto_servico' => $atualizacao['depois'],
                ':id_servico' => $atualizacao['id'],
            ]);
        }

        $pdo->commit();
        echo "Downloads e atualizacoes gravados com sucesso.\n";
    }

    foreach ($atualizacoes as $atualizacao) {
        printf(
            "%s | #%d | %s | %s -> %s\n",
            $executar ? 'ATUALIZADO' : 'PREVISTO',
            $atualizacao['id'],
            $atualizacao['nome'],
            $atualizacao['antes'],
            $atualizacao['depois']
        );
    }
} catch (Throwable $erro) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    fwrite(STDERR, "Erro: " . $erro->getMessage() . "\n");
    exit(1);
}

<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("Execute este script pelo terminal.\n");
}

require_once __DIR__ . '/../config/config.php';

$diretorioUploads = __DIR__ . '/../public/uploads/';
$diretorioImagens = $diretorioUploads . 'servico/';
$executar = in_array('--execute', $argv, true);

$imagensPorCategoria = [
    'low-fade' => [
        'termos' => ['low fade', 'low-fade'],
        'busca' => 'mens haircut fade',
    ],
    'mid-fade' => [
        'termos' => ['mid fade', 'mid-fade'],
        'busca' => 'mens haircut mid fade',
    ],
    'reflexo' => [
        'termos' => ['reflexo', 'luzes', 'mechas'],
        'busca' => 'hair highlights',
    ],
    'sobrancelha' => [
        'termos' => ['sobrancelha', 'sobrancelhas'],
        'busca' => 'eyebrow grooming barber',
    ],
    'corte-barba' => [
        'termos' => ['corte + barba', 'corte e barba'],
        'busca' => 'barber haircut beard trim',
    ],
    'barba' => [
        'termos' => ['barba'],
        'busca' => 'barbershop razor',
    ],
    'corte' => [
        'termos' => ['corte', 'fade'],
        'busca' => 'mens haircut',
    ],
    'generica' => [
        'termos' => [],
        'busca' => 'barbershop razor',
    ],
];

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
        'SELECT id_servico, nome_servico, foto_servico FROM tbl_servico ORDER BY id_servico'
    )->fetchAll(PDO::FETCH_ASSOC);

    $atualizacoes = [];
    foreach ($servicos as $servico) {
        $id = (int) $servico['id_servico'];
        $nomeNormalizado = strtolower(trim((string) $servico['nome_servico']));
        $fotoBanco = trim((string) $servico['foto_servico']);
        $caminhoAtual = $fotoBanco !== ''
            ? $diretorioUploads . ltrim($fotoBanco, '/\\')
            : '';

        if ($fotoBanco !== '' && file_exists($caminhoAtual)) {
            continue;
        }

        $nomeArquivo = 'servico-' . $id . '.jpg';
        $caminhoNovo = $diretorioImagens . $nomeArquivo;
        $categoria = $imagensPorCategoria['generica'];

        foreach ($imagensPorCategoria as $categoriaAtual) {
            foreach ($categoriaAtual['termos'] as $termo) {
                if (strpos($nomeNormalizado, $termo) !== false) {
                    $categoria = $categoriaAtual;
                    break 2;
                }
            }
        }

        $urlImagem = 'https://source.unsplash.com/1200x800/?' . rawurlencode($categoria['busca']);

        if ($executar) {
            $contexto = stream_context_create([
                'http' => [
                    'follow_location' => 1,
                    'timeout' => 30,
                    'user_agent' => 'BarberNac image updater',
                ],
            ]);
            $conteudo = @file_get_contents($urlImagem, false, $contexto);

            if ($conteudo === false || @getimagesizefromstring($conteudo) === false) {
                throw new RuntimeException("Falha ao baixar uma imagem valida para o servico #{$id}.");
            }

            if (file_put_contents($caminhoNovo, $conteudo, LOCK_EX) === false) {
                throw new RuntimeException("Falha ao salvar {$caminhoNovo}.");
            }
        }

        $atualizacoes[] = [
            'id' => $id,
            'nome' => $servico['nome_servico'],
            'antes' => $fotoBanco !== '' ? $fotoBanco : '(vazio)',
            'depois' => 'servico/' . $nomeArquivo,
        ];
    }

    if (!$executar) {
        echo "Modo simulacao. Nenhuma alteracao foi gravada. Use --execute para confirmar.\n";
    } elseif ($atualizacoes) {
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

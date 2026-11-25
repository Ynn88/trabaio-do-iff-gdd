<?php
// =========================================================================
// TEMPLATE DA ARENA E MOTOR DE TURNOS: template_batalha.php
// (Arquivo enviado pronto aos alunos: processa o turno, salva sessão e exibe HTML)
// =========================================================================

$heroi_hp_max   = $personagens[$heroi_id ?? 0]['hp'] ?? 100;
$inimigo_hp_max = $personagens[$inimigo_id ?? 0]['hp'] ?? 100;

// Processamento do Turno Padrão
// (Só roda se o aluno NÃO tiver mantido o motor próprio dele no batalha.php!)
if (!isset($turno_valido) && isset($_POST['acao']) && $heroi_hp > 0 && $inimigo_hp > 0) {
    $acao         = $_POST['acao'];
    $turno_valido = false;
    $relato_heroi = "";

    // 1. ATAQUE BÁSICO
    if ($acao == 'basico') {
        $dano = max(1, $heroi_ataque - $inimigo_defesa + rand(0, 3));
        $inimigo_hp -= $dano;
        $heroi_carga += 1;
        $turno_valido = true;
        $relato_heroi = "🗡️ Turno {$turno}: {$heroi} usou [{$nome_ataque_basico}] causando {$dano} de dano (+1 Carga).";
    }
    // 2. ATAQUE CARREGADO (Exige 2 Cargas)
    elseif ($acao == 'carregado') {
        if ($heroi_carga >= 2) {
            $dano = max(2, ($heroi_ataque * 2) - $inimigo_defesa);
            $inimigo_hp -= $dano;
            $heroi_carga -= 2;
            $turno_valido = true;
            $relato_heroi = "💥 Turno {$turno}: {$heroi} desferiu [{$nome_ataque_carregado}] causando {$dano} de dano crítico!";
        } else {
            $msg_turno = "⚠️ Carga insuficiente! Você tem {$heroi_carga}/2 de Carga.";
        }
    }
    // 3. HABILIDADE COM WHILE
    elseif ($acao == 'habilidade') {
        if ($heroi_carga >= 1) {
            $golpes = 0;
            $dano_total_combo = 0;

            while ($heroi_carga > 0) {
                $dano_total_combo += rand(9, 14);
                $heroi_carga--;
                $golpes++;
            }

            $inimigo_hp -= $dano_total_combo;
            $turno_valido = true;
            $relato_heroi = "✨ Turno {$turno}: [{$nome_habilidade}] acertou {$golpes} golpe(s) com WHILE, causando {$dano_total_combo} de dano!";
        } else {
            $msg_turno = "⚠️ Você precisa de pelo menos 1 Carga para ativar [{$nome_habilidade}]!";
        }
    }
    // 4. ITEM ÚNICO
    elseif ($acao == 'item') {
        if ($item_usado == false) {
            $cura = 35;
            $heroi_hp += $cura;
            if ($heroi_hp > $heroi_hp_max) {
                $heroi_hp = $heroi_hp_max;
            }
            $item_usado   = true;
            $turno_valido = true;
            $relato_heroi = "🧪 Turno {$turno}: {$heroi} usou [{$nome_item}] e recuperou +{$cura} de HP!";
        } else {
            $msg_turno = "⚠️ Você já utilizou [{$nome_item}] nesta partida!";
        }
    }

    // Contra-ataque da IA (usando os nomes dos golpes reais do oponente!)
    if ($turno_valido) {
        if ($inimigo_hp <= 0) {
            $inimigo_hp = 0;
            $msg_turno  = "{$relato_heroi} | 🏆 VITÓRIA! Você derrotou {$inimigo}!";
        } else {
            $sorteio_ia     = rand(1, 100);
            $atk_ini_basico = $personagens[$inimigo_id]['nome_ataque_basico'] ?? "Ataque Básico";
            $atk_ini_hab    = $personagens[$inimigo_id]['nome_habilidade'] ?? "Golpe Especial";

            if ($sorteio_ia <= 70) {
                $dano_ia = max(1, $inimigo_ataque - $heroi_defesa + rand(0, 3));
                $heroi_hp -= $dano_ia;
                $relato_ia = "👹 {$inimigo} usou [{$atk_ini_basico}] causando {$dano_ia} de dano!";
            } elseif ($sorteio_ia <= 90) {
                $dano_ia = max(2, ($inimigo_ataque + 6) - $heroi_defesa);
                $heroi_hp -= $dano_ia;
                $relato_ia = "🔥 {$inimigo} usou [{$atk_ini_hab}] causando {$dano_ia} de dano pesado!";
            } else {
                $cura_ia = 12;
                $inimigo_hp = min($inimigo_hp_max, $inimigo_hp + $cura_ia);
                $relato_ia = "🌑 {$inimigo} se concentrou e recuperou +{$cura_ia} de HP!";
            }

            $msg_turno = $relato_heroi . " | " . $relato_ia;
            $turno++;

            if ($heroi_hp <= 0) {
                $heroi_hp  = 0;
                $msg_turno = "💀 DERROTA! {$inimigo} venceu o combate...";
            }
        }
    }
}

// Compatibilidade caso o aluno tenha mantido o motor da Aula 04 com nomes antigos
if (isset($mensagem))         $msg_turno  = $mensagem;
if (isset($heroi_item_usado)) $item_usado = $heroi_item_usado;

// Salva automaticamente todas as variáveis na Sessão
if (session_status() === PHP_SESSION_ACTIVE) {
    $vars_sessao = [
        'batalha_iniciada', 'turno', 'titulo', 'msg_turno', 'log_batalha',
        'heroi_id', 'inimigo_id',
        'heroi', 'heroi_nome', 'heroi_hp', 'heroi_hp_max', 'heroi_ataque', 'heroi_atk', 'heroi_defesa', 'heroi_def', 'heroi_carga',
        'heroi_elemento', 'heroi_passiva', 'heroi_sprite', 'item_usado', 'heroi_item_usado',
        'nome_ataque_basico', 'nome_atk_basico', 'nome_ataque_carregado', 'nome_atk_carregado', 'nome_habilidade', 'nome_item',
        'inimigo', 'inimigo_nome', 'inimigo_hp', 'inimigo_hp_max', 'inimigo_ataque', 'inimigo_atk', 'inimigo_defesa', 'inimigo_def', 'inimigo_carga',
        'inimigo_elemento', 'inimigo_passiva', 'inimigo_sprite'
    ];
    foreach ($vars_sessao as $v) {
        if (isset($$v)) {
            $_SESSION[$v] = $$v;
        } elseif (isset($_SESSION[$v])) {
            $$v = $_SESSION[$v];
        }
    }
}

$titulo      = $titulo ?? "Arena das Lendas — RPG de Turnos";
$msg_turno   = $msg_turno ?? "Comece a batalha! Escolha uma ação:";
$heroi_pct   = ($heroi_hp_max > 0) ? max(0, min(100, round(($heroi_hp / $heroi_hp_max) * 100))) : 0;
$inimigo_pct = ($inimigo_hp_max > 0) ? max(0, min(100, round(($inimigo_hp / $inimigo_hp_max) * 100))) : 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">

        <header class="topo">
            <h1><?php echo $titulo; ?></h1>
            <p>Arena de Batalha no IFFAR <?php if (isset($turno)) echo "• Turno #" . $turno; ?></p>
        </header>

        <div class="painel">
            <p><strong><?php echo $msg_turno; ?></strong></p>
        </div>

        <div class="arena">
            <!-- Lado do Herói -->
            <div class="card heroi">
                <span class="tag">SEU HERÓI <?php if (!empty($heroi_elemento)) echo "• " . $heroi_elemento; ?></span>

                <?php if (!empty($heroi_sprite) && file_exists($heroi_sprite)): ?>
                    <img src="<?php echo $heroi_sprite; ?>" alt="Herói" class="sprite">
                <?php endif; ?>

                <h2>Herói: <?php echo $heroi; ?></h2>

                <div class="barra-fundo">
                    <div class="barra-hp" style="width: <?php echo $heroi_pct; ?>%;"></div>
                </div>

                <p>Pontos de Vida: <strong><?php echo $heroi_hp; ?> / <?php echo $heroi_hp_max; ?></strong></p>

                <div class="atributos">
                    <span>Ataque: <?php echo $heroi_ataque; ?></span>
                    <span>Defesa: <?php echo $heroi_defesa; ?></span>
                    <span>Carga: <?php echo $heroi_carga; ?></span>
                    <?php if (!empty($heroi_passiva)): ?>
                        <span>Passiva: <?php echo $heroi_passiva; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="versus"><strong>VS</strong></div>

            <!-- Lado do Inimigo -->
            <div class="card inimigo">
                <span class="tag">OPONENTE <?php if (!empty($inimigo_elemento)) echo "• " . $inimigo_elemento; ?></span>

                <?php if (!empty($inimigo_sprite) && file_exists($inimigo_sprite)): ?>
                    <img src="<?php echo $inimigo_sprite; ?>" alt="Inimigo" class="sprite espelhar">
                <?php endif; ?>

                <h2>Inimigo: <?php echo $inimigo; ?></h2>

                <div class="barra-fundo">
                    <div class="barra-hp inimigo-bar" style="width: <?php echo $inimigo_pct; ?>%;"></div>
                </div>

                <p>Pontos de Vida: <strong><?php echo $inimigo_hp; ?> / <?php echo $inimigo_hp_max; ?></strong></p>

                <div class="atributos">
                    <span>Ataque: <?php echo $inimigo_ataque; ?></span>
                    <span>Defesa: <?php echo $inimigo_defesa; ?></span>
                    <span>Carga: <?php echo $inimigo_carga ?? 0; ?></span>
                    <?php if (!empty($inimigo_passiva)): ?>
                        <span>Passiva: <?php echo $inimigo_passiva; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="painel">
            <h3>Escolha sua ação no turno:</h3>
            <form method="POST" class="grid-2">
                <button type="submit" name="acao" value="basico" class="btn btn-basico">
                    Ataque Básico
                    <small><?php echo $nome_ataque_basico; ?> (+1 de carga)</small>
                </button>
                <button type="submit" name="acao" value="carregado" class="btn btn-carregado">
                    Ataque Carregado
                    <small><?php echo $nome_ataque_carregado; ?> (Custo: 2 de carga)</small>
                </button>
                <button type="submit" name="acao" value="habilidade" class="btn btn-habilidade">
                    Habilidade
                    <small><?php echo $nome_habilidade; ?></small>
                </button>
                <button type="submit" name="acao" value="item" class="btn btn-item">
                    Usar Item
                    <small><?php echo $nome_item; ?> (1x por batalha)</small>
                </button>
            </form>

            <form method="POST" class="grid-2" style="margin-top: 12px;">
                <button type="submit" name="acao" value="nova_batalha" class="btn">
                    ⚔️ Nova Batalha (Próximo Oponente)
                </button>
                <button type="submit" name="acao" value="reiniciar" class="btn">
                    🔄 Trocar de Personagem
                </button>
            </form>
        </div>

    </div>

</body>
</html>

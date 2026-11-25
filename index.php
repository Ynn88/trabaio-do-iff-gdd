<?php
session_start();
require "personagens.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?> — Seleção de Personagem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header class="topo">
            <h1><?php echo $titulo; ?></h1>
            <p>Escolha seu Campeão para entrar na Arena!</p>
        </header>

        <div class="grid-3">
            <?php for ($i = 0; $i < count($personagens); $i++): ?>
                <?php $p = $personagens[$i]; ?>
                <div class="card">
                    <span class="tag"><?php echo $p['elemento'] ?? 'Lutador'; ?></span>

                    <?php if (!empty($p['sprite']) && file_exists($p['sprite'])): ?>
                        <img src="<?php echo $p['sprite']; ?>" alt="Sprite" class="sprite">
                    <?php endif; ?>

                    <h2><?php echo $p['nome']; ?></h2>

                    <div class="atributos">
                        <span>❤️ HP: <?php echo $p['hp']; ?></span>
                        <span>⚔️ ATK: <?php echo $p['ataque']; ?></span>
                        <span>🛡️ DEF: <?php echo $p['defesa']; ?></span>
                    </div>

                    <p style="margin-bottom: 12px;">
                        <small>
                            🗡️ <?php echo $p['nome_ataque_basico']; ?> |
                            ✨ <?php echo $p['nome_habilidade']; ?>
                        </small>
                    </p>

                    <form action="batalha.php" method="POST">
                        <input type="hidden" name="heroi_id" value="<?php echo $i; ?>">
                        <button type="submit" class="btn">
                            ⚔️ Jogar com <?php echo $p['nome']; ?>
                        </button>
                    </form>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</body>
</html>

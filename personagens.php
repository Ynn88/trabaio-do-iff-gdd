<?php
// =========================================================================
// AULA 1 (PASSAR NA LOUSA): personagens.php
// =========================================================================
$titulo = "Arena das Lendas — RPG de Turnos";

$personagens = [
    // Personagem 0 (Feito em aula com o professor)
    [
        "nome"                  => "Guerreiro de Teste",
        "elemento"              => "Luz",
        "hp"                    => 100,
        "ataque"                => 18,
        "defesa"                => 8,
        "nome_ataque_basico"    => "Golpe de Espada",
        "nome_ataque_carregado" => "Corte Furioso",
        "nome_habilidade"       => "Rajada Relâmpago",
        "nome_item"             => "Poção de Vida (+35 HP)",
        "passiva"               => "Escudo Radiante",
        "sprite"                => "assets/sprites/p1.svg"
    ],
    // Personagem 1 (Segundo exemplo para já testar Oponente e Troca!)
    [
        "nome"                  => "Sombra Misteriosa",
        "elemento"              => "Trevas",
        "hp"                    => 95,
        "ataque"                => 20,
        "defesa"                => 6,
        "nome_ataque_basico"    => "Lâmina Oculta",
        "nome_ataque_carregado" => "Golpe Sombrio",
        "nome_habilidade"       => "Dança do Vazio",
        "nome_item"             => "Elixir Sombrio (+35 HP)",
        "passiva"               => "Manto Noturno",
        "sprite"                => "assets/sprites/p2.svg"
    ],
    // TAREFA: Copie um bloco [ ... ], cole abaixo e cadastre os outros 7 personagens do seu GDD!
];
?>

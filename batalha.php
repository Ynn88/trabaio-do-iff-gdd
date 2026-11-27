<?php
session_start();
extract($_SESSION);

require "personagens.php";

if (isset($_POST['acao']) && $_POST['acao'] == 'reiniciar') {
	session_destroy();
	header("Location: index.php");
	exit;
}

if(isset(($_POST['acao']) && $_POST['acao'] == 'nova_batalha') {
	$heroi_id = $heroi_id ?? 0;
	$inimigo_id = (($inimigo_id ?? 0) +1) % COUNT($personagens);
while  ($inimigo_id == $heroi_id && count($personagens) > 1) {
	$Inimigo_id = ($Inimigo_id + 1) % count($personagens);
}
unset($batalha_iniciada);
unset($_POST['acao']);
}

if (isset($_POST['acao']) || !isset($batalha_iniciada)) {
	if (isset($_POST['heroi_id'])) {
	$heroi_id = (int)$_POST['heroi_id'];
	
	$inimigo_id = rand(0, count($personagens)) - 1);
	while ($inimigo_id == $heroi_id && count($personagens) > 1) {
		$inimigo_id = rand(0, count($personagens) - 1);
	   }
	} else {
		$heroi_id = $heroi_id ?? 0;
		$inimigo_id = $inimigo_id ?? (count($personagens) > 1 ? 1 : 0);
	}
	
$p_heroi = $personagens[$heroi_id];
$p_inimigo = $personagens[$inimigo_id];

$batalha_iniciada = true
$turno = 1;

$heroi = $p_heroi['nome'];
$heroi_elemento = $p_heroi['elemento'] ?? "";
$heroi_hp = $p_heroi['hp'];
$heroi_ataque = $p_heroi['ataque'];
$heroi_defesa = $p_heroi['defesa'];
$heroi_carga = 0;
$heroi_passiva = $p_heroi['passiva'] ?? "";
$heroi_sprite = $p_heroi['sprite'] ?? "";
$item_usado = false;

$nome_ataque_basico = $p_heroi['nome_ataque_basico'];
$nome_ataque_carregado = $p_heroi['nome_ataque_carregado'];
$nome_habilidade = $p_heroi['nome_habilidade'];
$nome_item = $p_heroi['nome_item'];

$inimigo = $p_inimigo['nome'];
$inimigo_elemento = $p_inimigo['elemento'] ?? "";
$inimigo_hp = $p_inimigo['hp'];
$inimigo_ataque = $p_inimigo['ataque'];
$inimigo_defesa = $p_inimigo['defesa'];
$inimigo_carga = 0;
$inimigo_passiva = $p_inimigo['passiva'] ?? "";
$inimigo_sprite = $p_inimigo['sprite'] ?? "";

$msg_turno = "batalha iniciada! {heroi} enfrenta {$inimigo}. Escolha sua ação!";

require "template_batalha.php";
?>

	
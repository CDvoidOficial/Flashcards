<?php
// estatisticas.php
include 'layout.php';
include 'db.php';

$total = $pdo->query("SELECT COUNT(*) FROM revisoes")->fetchColumn();
$aprendidos = $pdo->query("SELECT COUNT(*) FROM revisoes WHERE classificacao = 'Aprendi'")->fetchColumn();
$rever = $pdo->query("SELECT COUNT(*) FROM revisoes WHERE classificacao = 'Rever depois'")->fetchColumn();
$nao_entendi = $pdo->query("SELECT COUNT(*) FROM revisoes WHERE classificacao = 'N\u00e3o entendi'")->fetchColumn();
?>
<h2>Estat\u00edsticas</h2>
<p>Total revis\u00f5es: <?= $total ?></p>
<p>Aprendidos: <?= $aprendidos ?> (<?= round($aprendidos / max($total, 1) * 100, 2) ?>%)</p>
<p>Rever depois: <?= $rever ?> (<?= round($rever / max($total, 1) * 100, 2) ?>%)</p>
<p>Não entendi: <?= $nao_entendi ?> (<?= round($nao_entendi / max($total, 1) * 100, 2) ?>%)</p>
<?php include 'rodape.php'; ?>

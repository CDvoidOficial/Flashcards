<?php
session_start();
include 'layout.php';
include 'db.php';

$deck_id = $_GET['deck'] ?? 0;
$modo = $_GET['modo'] ?? 'normal';

if (!isset($_SESSION['revisados'][$deck_id])) {
  $_SESSION['revisados'][$deck_id] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['resetar'])) {
    unset($_SESSION['revisados'][$deck_id]);
    header("Location: revisar.php?deck=$deck_id");
    exit;
  }

  $classificacao = $_POST['classificacao'] ?? null;
  $flashcard_id = $_POST['flashcard_id'] ?? null;

  if ($classificacao && $flashcard_id) {
    $stmt = $pdo->prepare("INSERT INTO revisoes (flashcard_id, classificacao) VALUES (?, ?)");
    $stmt->execute([$flashcard_id, $classificacao]);
    $_SESSION['revisados'][$deck_id][] = $flashcard_id;
    header("Location: revisar.php?deck=$deck_id&modo=$modo");
    exit;
  }
}

if ($modo === 'naoentendi') {
  $stmt = $pdo->prepare("
    SELECT f.* FROM flashcards f
    JOIN revisoes r ON f.id = r.flashcard_id
    WHERE r.classificacao = 'Não entendi' AND f.deck_id = ? 
    GROUP BY f.id
  ");
  $stmt->execute([$deck_id]);
  $todos = $stmt->fetchAll();
} else {
  $stmt = $pdo->prepare("SELECT * FROM flashcards WHERE deck_id = ?");
  $stmt->execute([$deck_id]);
  $todos = $stmt->fetchAll();
  $todos = array_filter($todos, function($card) use ($deck_id) {
    return !in_array($card['id'], $_SESSION['revisados'][$deck_id]);
  });
}

$total = count($todos);
$revisados = count($_SESSION['revisados'][$deck_id]);
$progresso = $total > 0 ? round(($revisados / $total) * 100) : 0;

$card = null;
if (count($todos) > 0) {
  $card = $todos[array_rand($todos)];
}
?>

<h2>Revisar Flashcards</h2>
<p><a href="revisar.php?deck=<?= $deck_id ?>&modo=normal">Revisão normal</a> | 
<a href="revisar.php?deck=<?= $deck_id ?>&modo=naoentendi">Revisar "Não entendi"</a> | 
<a href="grafico.php?deck=<?= $deck_id ?>">Ver gráfico</a></p>

<div style="border: 1px solid #ccc; width: 100%; height: 20px; margin-bottom: 10px;">
  <div style="background: green; width: <?= $progresso ?>%; height: 100%;"></div>
</div>
<p><?= $revisados ?> revisados. <?= $total ?> restantes nesta sessão.</p>

<?php if ($card): ?>
  <p><strong>Pergunta:</strong> <?= nl2br(htmlspecialchars($card['pergunta'])) ?></p>
  <?php if ($card['imagem']): ?><img src="<?= $card['imagem'] ?>" alt="Imagem"><br><?php endif; ?>
  <?php if ($card['audio']): ?><audio controls src="<?= $card['audio'] ?>"></audio><br><?php endif; ?>

  <p><strong>Resposta:</strong> <button id="mostrarRespostaBtn">Clique para revelar</button></p>
  <p id="resposta" style="display:none;"> <?= nl2br(htmlspecialchars($card['resposta'])) ?> </p>

  <form method="post">
    <input type="hidden" name="flashcard_id" value="<?= $card['id'] ?>">
    <button name="classificacao" value="Aprendi">Aprendi</button>
    <button name="classificacao" value="Rever depois">Rever depois</button>
    <button name="classificacao" value="Não entendi">Não entendi</button>
  </form>

  <script>
    document.getElementById('mostrarRespostaBtn').addEventListener('click', function () {
      var resposta = document.getElementById('resposta');
      resposta.style.display = 'block';
      this.style.display = 'none';
    });
  </script>

<?php else: ?>
  <p><strong>Você revisou todos os flashcards disponíveis!</strong></p>
  <form method="post">
    <button name="resetar" value="1">Recomeçar Revisão</button>
  </form>
<?php endif; ?>

<?php include 'rodape.php'; ?>
<?php
include 'layout.php';
include 'db.php';

$deck_id = $_GET['deck'] ?? 0;
$card = $pdo->query("SELECT * FROM flashcards WHERE deck_id = $deck_id ORDER BY RAND() LIMIT 1")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $classificacao = $_POST['classificacao'];
  $flashcard_id = $_POST['flashcard_id'];
  $stmt = $pdo->prepare("INSERT INTO revisoes (flashcard_id, classificacao) VALUES (?, ?)");
  $stmt->execute([$flashcard_id, $classificacao]);
  header("Location: revisar.php?deck=$deck_id");
  exit;
}
?>
<h2>Revisar Flashcards</h2>
<?php if ($card): ?>
  <p><strong>Pergunta:</strong> <?= nl2br(htmlspecialchars($card['pergunta'])) ?></p>
  <?php if ($card['imagem']): ?><img src="<?= $card['imagem'] ?>" alt="Imagem"><br><?php endif; ?>
  <?php if ($card['audio']): ?><audio controls src="<?= $card['audio'] ?>"></audio><br><?php endif; ?>

  <p><strong>Resposta:</strong> <button id="mostrarRespostaBtn">Clique para revelar</button></p>
  <p id="resposta" style="display:none;"><?= nl2br(htmlspecialchars($card['resposta'])) ?></p>

  <form method="post">
    <input type="hidden" name="flashcard_id" value="<?= $card['id'] ?>">
    <button name="classificacao" value="Aprendi">Aprendi</button>
    <button name="classificacao" value="Rever depois">Rever depois</button>
    <button name="classificacao" value="Não entendi">Não entendi</button>
  </form>

  <script>
    document.getElementById('mostrarRespostaBtn').addEventListener('click', function() {
      var resposta = document.getElementById('resposta');
      if (resposta.style.display === 'none') {
        resposta.style.display = 'block';
        this.style.display = 'none';
      }
    });
  </script>

<?php else: ?>
  <p>Nenhum flashcard neste baralho.</p>
<?php endif; ?>
<?php include 'rodape.php'; ?>

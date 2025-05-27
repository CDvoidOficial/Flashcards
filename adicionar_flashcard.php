<?php
// adicionar_flashcard.php
include 'layout.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $deck_id = $_POST['deck_id'];
  $pergunta = $_POST['pergunta'];
  $resposta = $_POST['resposta'];

  $imagem = '';
  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $imagem = 'uploads/' . basename($_FILES['imagem']['name']);
    move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
  }

  $audio = '';
  if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
    $audio = 'uploads/' . basename($_FILES['audio']['name']);
    move_uploaded_file($_FILES['audio']['tmp_name'], $audio);
  }

  $stmt = $pdo->prepare("INSERT INTO flashcards (deck_id, pergunta, resposta, imagem, audio) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$deck_id, $pergunta, $resposta, $imagem, $audio]);
  echo "<p>Flashcard adicionado!</p>";
}

$decks = $pdo->query("SELECT * FROM decks")->fetchAll();
?>
<h2>Adicionar Flashcard</h2>
<form method="post" enctype="multipart/form-data">
  <label>Baralho:
    <select name="deck_id">
      <?php foreach ($decks as $deck): ?>
        <option value="<?= $deck['id'] ?>"><?= $deck['nome'] ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Pergunta: <textarea name="pergunta" required></textarea></label>
  <label>Resposta: <textarea name="resposta" required></textarea></label>
  <label>Imagem: <input type="file" name="imagem"></label>
  <label>Áudio: <input type="file" name="audio"></label>
  <button type="submit">Salvar</button>
</form>
<?php include 'rodape.php'; ?>

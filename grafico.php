<?php
include 'layout.php';
include 'db.php';

$deck_id = $_GET['deck'] ?? 0;
$stmt = $pdo->prepare("
  SELECT classificacao, COUNT(*) as total 
  FROM revisoes r
  JOIN flashcards f ON r.flashcard_id = f.id
  WHERE f.deck_id = ?
  GROUP BY classificacao
");
$stmt->execute([$deck_id]);
$dados = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<canvas id="grafico" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('grafico').getContext('2d');
  const grafico = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($dados)) ?>,
      datasets: [{
        label: 'Classificações',
        data: <?= json_encode(array_values($dados)) ?>,
        backgroundColor: ['green', 'orange', 'red']
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

<a href="revisar.php?deck=<?= $deck_id ?>">Voltar para revisão</a>
<?php include 'rodape.php'; ?>

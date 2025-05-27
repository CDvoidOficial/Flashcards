CREATE DATABASE IF NOT EXISTS flashcards;
USE flashcards;

CREATE TABLE decks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  descricao TEXT
);

CREATE TABLE flashcards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  deck_id INT NOT NULL,
  pergunta TEXT NOT NULL,
  resposta TEXT NOT NULL,
  imagem VARCHAR(255),
  audio VARCHAR(255),
  FOREIGN KEY (deck_id) REFERENCES decks(id) ON DELETE CASCADE
);

CREATE TABLE revisoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flashcard_id INT NOT NULL,
  classificacao ENUM('Aprendi', 'Rever depois', 'Não entendi') NOT NULL,
  data_revisao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (flashcard_id) REFERENCES flashcards(id) ON DELETE CASCADE
);

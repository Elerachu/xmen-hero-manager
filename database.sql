CREATE DATABASE IF NOT EXISTS xmen_hero_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE xmen_hero_manager;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE heroes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  hero_name VARCHAR(100) NOT NULL,
  real_name VARCHAR(100) NOT NULL,
  short_bio VARCHAR(255) NOT NULL,
  long_bio TEXT NOT NULL,
  powers VARCHAR(255) DEFAULT NULL,
  team VARCHAR(100) DEFAULT 'X-Men',
  image_url VARCHAR(500) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO heroes (hero_name, real_name, short_bio, long_bio, powers, team) VALUES
('Wolverine', 'James Howlett', 'A fiercely loyal mutant with a healing factor and adamantium claws.', 'Logan has lived through more than a century of conflict and loss. At Xavier''s school, he channels his fierce instincts into protecting young mutants and fighting for a better future.', 'Regeneration, enhanced senses, adamantium claws', 'X-Men'),
('Storm', 'Ororo Munroe', 'A poised leader who commands the forces of nature.', 'Raised in Cairo and worshipped as a goddess in Africa, Ororo became one of Professor Xavier''s most trusted X-Men. Her compassion, courage, and command of the weather make her a natural leader.', 'Weather manipulation, flight', 'X-Men'),
('Cyclops', 'Scott Summers', 'A disciplined field leader with powerful optic blasts.', 'Scott Summers was among the first students at Xavier''s School. His strategic mind and unwavering commitment to mutant rights have made him a cornerstone of the X-Men.', 'Optic energy blasts, tactical leadership', 'X-Men'),
('Jean Grey', 'Jean Grey', 'A gifted telepath and telekinetic with extraordinary potential.', 'Jean is one of the X-Men''s original members. Her empathy and immense psychic power have shaped the team through its greatest triumphs and most difficult trials.', 'Telepathy, telekinesis', 'X-Men');

-- Papildus klienti
INSERT INTO customers (name, last_name, email, birthday, points) VALUES
('Anna', 'Berzina', 'anna@piemers.lv', '1995-05-15', 150),
('Janis', 'Kalnins', 'janis@piemers.lv', '1988-10-20', 300),
('Laura', 'Ozola', 'laura@piemers.lv', '1992-03-12', 450),
('Kārlis', 'Zariņš', 'karlis@piemers.lv', '1980-07-04', 100),
('Marta', 'Liepiņa', 'marta@piemers.lv', '1998-12-30', 25);

-- Papildus pasūtījumi
-- Pieņemam, ka klienti ID 5-9 ir jaunie
INSERT INTO orders (date, status, comments, arrived_at, customer_id) VALUES
('2026-04-01', 'Pabeigts', 'Viss lieliski', '2026-04-05', 5),
('2026-04-10', 'Procesā', 'Gaidām piegādi', NULL, 6),
('2026-04-15', 'Jauns', 'Steidzams pasūtījums', NULL, 7),
('2026-04-18', 'Jauns', 'Dāvana dzimšanas dienā', NULL, 8),
('2026-04-20', 'Pabeigts', 'Saņemts veikalā', '2026-04-21', 9),
('2026-04-22', 'Procesā', 'Nav mājās', NULL, 5),
('2026-04-22', 'Jauns', 'Interesējas par atlaidi', NULL, 6),
('2026-04-23', 'Jauns', 'Pēdējā brīža pirkums', NULL, 7),
('2026-04-23', 'Procesā', 'Iepakošana', NULL, 1),
('2026-04-23', 'Pabeigts', 'Ātra piegāde', '2026-04-23', 2);

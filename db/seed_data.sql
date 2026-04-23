-- Papildus testa dati sistēmas demonstrācijai
-- Ietver gan klientus, gan to pasūtījumus

-- 1. Papildus klientu pievienošana
INSERT INTO customers (name, last_name, email, birthday, points) VALUES
('Anna', 'Berzina', 'anna@piemers.lv', '1995-05-15', 150),
('Janis', 'Kalnins', 'janis@piemers.lv', '1988-10-20', 300),
('Laura', 'Ozola', 'laura@piemers.lv', '1992-03-12', 450),
('Kārlis', 'Zariņš', 'karlis@piemers.lv', '1980-07-04', 100),
('Marta', 'Liepiņa', 'marta@piemers.lv', '1998-12-30', 25);

-- 2. Papildus pasūtījumu pievienošana jaunajiem klientiem
-- Tiek pieņemts, ka klienti ID 5-9 ir tikko pievienotie
INSERT INTO orders (date, status, comments, arrived_at, customer_id) VALUES
('2026-04-01', 'Pabeigts', 'Viss lieliski, klients apmierināts', '2026-04-05', 5),
('2026-04-10', 'Procesā', 'Gaidām piegādi no noliktavas', NULL, 6),
('2026-04-15', 'Jauns', 'Steidzams pasūtījums svētkiem', NULL, 7),
('2026-04-18', 'Jauns', 'Dāvana dzimšanas dienā, lūdzu iesaiņot', NULL, 8),
('2026-04-20', 'Pabeigts', 'Saņemts klātienē veikalā', '2026-04-21', 9),
('2026-04-22', 'Procesā', 'Klients nebija mājās pirmajā mēģinājumā', NULL, 5),
('2026-04-22', 'Jauns', 'Interesējas par apjoma atlaidēm', NULL, 6),
('2026-04-23', 'Jauns', 'Pēdējā brīža pirkums pirms brīvdienām', NULL, 7);

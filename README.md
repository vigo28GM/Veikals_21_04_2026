# Veikals - PHP MVC Lietotne

Vienkārša un droša PHP lietojumprogramma klientu un pasūtījumu pārvaldībai, izmantojot MVC (Model-View-Controller) arhitektūru un PDO datubāzes savienojumu.

## Funkcionalitāte

*   **Sākumlapas statistika:** Interaktīvs pārskats par kopējo klientu un pasūtījumu skaitu, kā arī pasūtījumu sadalījums pēc statusiem.
*   **Klientu pārvaldība (CRUD):** Pilns klientu saraksts, jaunu klientu pievienošana, esošo labošana un dzēšana.
*   **Hierarhiskais skats:** Klientu saraksts, kurā zem katra klienta uzreiz redzami viņa veiktie pasūtījumi.
*   **Pasūtījumu pārvaldība (CRUD):** Pasūtījumu saraksts ar piesaistītiem klientu vārdiem.
*   **Statusu filtrēšana:** Iespēja filtrēt pasūtījumus pēc to statusa (piemēram, "Jauns", "Procesā", "Pabeigts").
*   **Drošība:** Aizsardzība pret SQL injekcijām (PDO prepared statements) un XSS uzbrukumiem (htmlspecialchars).

## Kā tas strādā?

Projekts seko stingriem MVC principiem:

*   **Modeļi (Models):** `src/models/` mapē esošās klases (`Customer`, `Order`) atspoguļo datubāzes struktūru. Kopš Step 21 visas datubāzes operācijas atgriež klašu instances (objektus), nevis asociatīvus masīvus, nodrošinot labāku datu integritāti.
*   **Kontrolieri (Controllers):** `src/controllers/` mapē esošās klases vada lietotnes loģiku, saņem datus no modeļiem un nodod tos skatiem.
*   **Skati (Views):** `src/views/` mapē esošie PHP faili ir atbildīgi par vizuālo attēlojumu, izmantojot objektu sintaksi (piemēram, `$customer->name`).
*   **Maršrutēšana (Routing):** Visi pieprasījumi tiek apstrādāti caur `public/index.php` (Front Controller).
*   **Datubāze:** Izolēta `db/` mapē. Konfigurācija tiek lasīta no `config.php`.

## Uzstādīšana un Palaišana

1.  **Datubāzes sagatavošana:**
    *   Importējiet `db/setup.sql` savā MySQL serverī.
2.  **Konfigurācija:**
    *   Izveidojiet `config.php` failu saknes mapē un nodefinējiet datubāzes piekļuves datus:
      ```php
      <?php
      return [
          'host' => 'localhost',
          'db'   => 'store_dev',
          'user' => 'your_user',
          'pass' => 'your_password'
      ];
      ```
3.  **Servera palaišana:**
    *   Izpildiet komandu: `php -S localhost:8000 -t public`
    *   Atveriet pārlūkprogrammā: `http://localhost:8000`

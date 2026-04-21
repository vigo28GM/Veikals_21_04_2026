# Veikals - PHP CRUD Lietotne

Vienkārša PHP lietojumprogramma klientu un pasūtījumu pārvaldībai, izmantojot MVC arhitektūras principus un PDO datubāzes savienojumu.

## Uzstādīšana un Palaišana

1.  **Datubāzes sagatavošana:**
    *   Importējiet `db/setup.sql` failu savā MySQL/MariaDB serverī.
    *   Pārliecinieties, ka datubāze `store_dev` ir izveidota un tabulas ir aizpildītas ar testa datiem.

2.  **Konfigurācija:**
    *   Atveriet `db/DB.php` un, ja nepieciešams, pielāgojiet datubāzes piekļuves datus (host, username, password).

3.  **Servera palaišana:**
    *   Terminālī izpildiet šādu komandu no projekta saknes mapes:
      ```bash
      php -S localhost:8000 -t public
      ```
    *   Atveriet pārlūkprogrammu un dodieties uz: `http://localhost:8000`

## Kā tas strādā?

Projekts ir veidots, sadalot loģiku, datus un prezentāciju atsevišķos slāņos:

*   **Maršrutēšana (Routing):** Visi pieprasījumi nonāk `public/index.php`. Tas analizē URL ceļu un izsauc attiecīgo kontroliera metodi (piemēram, `/customers` vai `/orders`).
*   **Kontrolieri (Controllers):** Atrodas `src/controllers/`. Tie apstrādā lietotāja pieprasījumus, iegūst datus no datubāzes un sagatavo tos attēlošanai.
*   **Modeļi/Dati (Database):** `db/DB.php` klase nodrošina centralizētu pieslēgumu datubāzei, izmantojot PDO (PHP Data Objects), kas nodrošina drošību pret SQL injekcijām.
*   **Skati (Views):** HTML šabloni atrodas `src/views/`. Tie ir atbildīgi tikai par datu parādīšanu lietotājam. `layout.php` nodrošina kopējo lapas struktūru un navigāciju.

## Funkcionalitāte

*   **Klientu pārvaldība:** Saraksts, pievienošana, labošana un dzēšana.
*   **Pasūtījumu pārvaldība:** Saraksts (ar piesaistītiem klientu vārdiem), pievienošana, labošana un dzēšana.
*   **Drošība:** Izmantoti *Prepared Statements* un `htmlspecialchars()` datu izvadei.

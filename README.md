# Veikals2 - Profesionāla PHP MVC Lietotne

Šī ir modernizēta PHP lietojumprogramma, kas izveidota kā neliels "custom framework" pēc profesionāliem standartiem. Tā nodrošina klientu un pasūtījumu pārvaldību ar iebūvētu autentifikācijas sistēmu un atkarību injekciju (Dependency Injection).

## Sistēmas Arhitektūra

Lietotne izmanto **Front Controller** modeli, kurā visi pieprasījumi tiek virzīti caur vienu ieeju: `public/index.php`.

### 1. Backend Loģika (The Framework)

Backend ir sadalīts vairākos slāņos, lai nodrošinātu kodu modularitāti un testējamību:

*   **Bootstrap (`src/core/Bootstrap.php`):** Sistēmas sirds. Tā inicializē autoloaderi, sesijas un reģistrē galvenos pakalpojumus (services) DI konteinerā.
*   **Dependency Injection Container (`src/core/Container.php`):** Pārvalda objektu dzīves ciklu. Kontrolieri nesaņem globālus mainīgos, bet gan atkarības (piemēram, DB savienojumu) caur konstruktoru.
*   **Router (`src/core/Router.php`):** Atbild par maršrutēšanu. Atbalsta dažādas HTTP metodes (GET, POST) un ļauj katram maršrutam piesaistīt Middleware (filtrus).
*   **Middleware (`src/core/Middleware.php`):** Filtru sistēma. Piemēram, `AuthMiddleware` pārbauda, vai lietotājs ir ielogojies, pirms atļaut piekļuvi kontrolierim.
*   **Models (`src/models/`):** Objekti, kas reprezentē datubāzes tabulas. Izmanto PDO statisko wrapperi `DB.php` drošām operācijām.

### 2. Frontend Loģika

Frontend ir veidots, izmantojot **Server-Side Rendering (SSR)** principu:

*   **Views (`src/views/`):** Tīri PHP faili (templates), kuros dati tiek iepludināti caur `extract()` funkciju kontrolierī.
*   **Layout (`src/views/layout.php`):** Vienota HTML čaula visai aplikācijai, kas ietver navigāciju un kopējos CSS stilus.
*   **State Management:** Lietotāja stāvoklis (piemēram, "vai esmu ielogojies") tiek saglabāts servera puses sesijā (`$_SESSION`).

## Pieprasījuma Dzīves Cikls

1.  Lietotājs nosūta pieprasījumu (piem., `GET /orders`).
2.  `index.php` palaiž `Bootstrap::init()`.
3.  `Router` atrod atbilstošo maršrutu.
4.  Ja maršrutam ir `AuthMiddleware`, tas pārbauda sesiju.
5.  `Router` izveido `OrderController` instanci, injicējot tajā `Container`.
6.  `OrderController` izsauc `Order::all()` modeli.
7.  Dati tiek nodoti `render()` metodei, kas apvieno datus ar PHP skatu un atgriež HTML pārlūkam.

## Funkcionalitāte

*   **Autentifikācija:** Reģistrācija un pieslēgšanās ar `password_hash` šifrēšanu.
*   **Komentāru sistēma:** 1-to-many attiecība starp pasūtījumiem un papildu komentāriem.
*   **CRUD operācijas:** Klientu un pasūtījumu pilna pārvaldība.
*   **Statistika:** Dinamisks pārskats sākumlapā.

## Uzstādīšana

1.  Importēt SQL failus no `db/` mapes secībā: `setup.sql` -> `auth_setup.sql` -> `comments_setup.sql`.
2.  Konfigurēt `config.php`.
3.  Palaist vietējo serveri: `php -S localhost:8000 -t public`.

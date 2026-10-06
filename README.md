# Folio - platforma na tvorbu osobných portfólií

Dávid Krátky

5ZYI36

## Stručný opis projektu
Cieľom je navrhnúť a implementovať webovú aplikáciu, ktorá umožní používateľom vytvoriť si osobné portfólio a spravovať v ňom svoje projekty. Aplikácia by mala mať jednoduché a prehľadné ovládanie, aby si portfólio vedel zostaviť aj človek bez znalostí tvorby webu.
Každý projekt má vlastnú stránku, ktorú si používateľ poskladá z pripravených blokov obsahu (nadpis, text, text s obrázkom, obrázok, zoznam, ukážka kódu, odkaz). Vzhľad celého portfólia určuje téma, ktorú si používateľ vyberie z tém pripravených administrátorom. Projekty sa označujú štítkami rozdelenými do kategórií (napr. Programovanie, Ručné práce, výtvarné umenie), vďaka čomu sa platforma hodí na prezentáciu technických projektov aj koníčkov, ako je pletenie či kreslenie. Návštevníci môžu verejné portfólia a projekty prehliadať, vyhľadávať v nich a filtrovať ich podľa kategórií a štítkov. Aplikácia je určená každému, kto chce jednoducho ukázať svoju tvorbu.

## Role v projekte
V aplikácií budú tri typy používateľov:
- **Návštevník (neprihlásený)** - môže si prezerať verejné portfólia a projekty, vyhľadávať v nich a filtrovať ich. Môže sa zaregistrovať a prihlásiť.
- **Registrovaný používateľ** - po prihlásení si vytvára a upravuje vlastný profil a portfólio, pridáva, upravuje a maže svoje projekty, priraďuje im štítky, skladá obsah stránok projektov z blokov a volí vzhľad svojho portfólia výberom témy. Môže upravovať a mazať iba vlastný obsah.
- **Administrátor** - spravuje používateľov (vrátane zablokovania prístupu), dohliada na obsah platformy (môže mazať nevhodný projekt), spravuje témy portfólií, kategórie a štítky. Štítky vytvára výhradne administrátor, aby nevznikali duplicity.

## Prípady použitia podľa rolí
**Návštevník**
- Návštevník si prezerá zoznam verejných portfólií a projektov.
- Návštevník vyhľadá projekt alebo portfólio podľa názvu alebo mena autora.
- Návštevník vyberie kategóriu a následne filtruje projekty podľa štítkov z tejto kategórie.
- Návštevník si zobrazí portfólio konkrétneho používateľa a detail jeho projektu.
- Návštevník sa zaregistruje a prihlási.
**Registrovaný používateľ**
- Používateľ si upraví profil (zobrazované meno, krátke bio, profilová fotka).
- Používateľ si vyberie tému svojho portfólia.
- Používateľ vytvorí nový projekt (názov, krátky popis, titulný obrázok, štítky, verejný / súkromný).
- Používateľ upraví alebo zmaže svoj projekt.
- Používateľ na stránku projektu pridá blok obsahu, upraví ho, zmaže ho alebo zmení jeho poradie.
- Používateľ nahrá obrázok do bloku obsahu.
- Používateľ sa odhlási.
**Administrátor**
- Administrátor si zobrazí zoznam používateľov a zablokuje alebo odblokuje používateľa, ktorý sa nevhodne správa.
- Administrátor zmaže nevhodný projekt.
- Administrátor vytvorí, upraví alebo zmaže kategóriu štítkov.
- Administrátor vytvorí, upraví alebo zmaže štítok a zaradí ho do kategórie.

## Plánované entity
**Používateľ (`users`)** - tabuľka používateľov
- Atribúty: `id`, `username`, `email`, `password_hash`, `role` (user / admin), `display_name`, `bio`, `avatar_path`, `is_banned`, `theme_id`, `created_at`
- vzťahy: patrí mu viacero projektov, má zvolenú jednu tému.

**Téma (`themes`)** - vzhľad portfólia, ktorý vytvára administrátor. Nejde o nahrávaný súbor so šablónou, ale o súbor nastavení. Rozloženia sú pevne naprogramované v aplikácii a farby a písmo sa do stránky vkladajú ako CSS premenné.
- Atribúty: `id`, `name`, `layout` (mriežka / zoznam / ...), `color_primary`, `color_background`, `color_text`, `font` (z povoleneho zoznamu), `preview_image_path`
- Vzťahy: jednu tému môže používať viacero používateľov.

**Projekt (`projects`)** - projekt v portfóliu používateľa (technický projekt, výtvor z koníčka a pod.)
- Atribúty: `id`, `user_id`, `title`, `short_description`, `cover_image_path`, `is_public`, `created_at`, `updated_at`
- Vzťahy: patrí jednému používateľovi, obsahuje viacero blokov obsahu, má priradených viacero štítkov. 

**Blok obsahu (`project_blocks`)** - jeden komponent na stránke projektu. Bloky sa zobrazujú pod sebou podľa poradia, vzhľad každého typu bloku určuje CSS aplikácie v kombinácií s témou používateľa.
- Atribúty: `id`, `project_id`, `type` (heading, text, image, list, code, link), `position`, `heading`, `body`, `image_path`, `url`
- Využitie stĺpcov závisí od typu bloku (napr. nadpis používa iba `heading`, zoznam ukladá položky v `body` po jednej na riadok, ukážka kódu ukladá kód v `body`). Nepoužité stĺpce zostávajú prázdne.
- Vzťahy: patrí jednému projektu.

**Kategória (`categories`)** - oblasť tvorby, do ktorej patria štítky (napr. Programovanie, Ručné práce, Výtvarné umenie, Fotografia...), spravuje ju administrátor.
- Atribúty: `id`, `name`
- Vzťahy: obsahuje viacero štítkov.

**Štítok (`tags`)** – označenie projektu (napr. PHP, Docker, pletenie, akvarel), vytvára ho výhradne administrátor.

Atribúty: `id`, `category_id`, `name` (unikátny v rámci kategórie)
Vzťahy: patrí jednej kategórii, môže byť priradený viacerým projektom.

**Asociačná tabuľka (`project_tag`)** – dekompozícia vzťahu M:N medzi projektmi a štítkami (`project_id`, `tag_id`).

## Vzťahy medzi entitami
- **Používateľ - Projekt (1:N)** - používateľ má ľubovoľný počet projektov, každý projekt patrí práve jednému používateľovi.
- **Projekt - Blok obsahu (1:N)** - projekt sa skladá z ľubovoľného počtu blokov, každý blok patrí práve jednému projektu. Pri zmazaní projektu sa zmažú aj jeho bloky.
- **Téma - Používateľ (1:N)** - jednu tému môže používať viacero používatľov, každý používateľ má zvolenú najviac jednu tému.
- **Kategória - Štítok (1:N)** - kategória obsahuje ľubovoľný počet štítkov, každý štítok patrí práve jednej kategórií.
- **Projekt - Štítok (M:N)** - projekt môže mať viacero štítkov a jeden štítok sa môže vyskytovať vo viacerých projektoch. Vzťah je realizovaný asociačnou tabuľkou `project_tag`.

## Hlavné stránky aplikácie
1. **Úvodná stránka / prehľad projektov** – zoznam verejných projektov a portfólií s vyhľadávaním a filtrovaním podľa kategórie a štítkov (AJAX, po výbere kategórie sa načítajú jej štítky).
2. **Verejné portfólio používateľa** – profil používateľa a zoznam jeho verejných projektov zobrazený podľa zvolenej témy.
3. **Detail projektu** – stránka projektu poskladaná z blokov obsahu v štýle témy autora.
4. **Registrácia a prihlásenie** – formuláre na vytvorenie účtu a prihlásenie.
5. **Moje projekty (dashboard)** – prehľad projektov prihláseného používateľa s možnosťou vytvoriť, upraviť alebo zmazať projekt.
6. **Formulár projektu** – vytvorenie a úprava základných údajov projektu (názov, popis, titulný obrázok, štítky, viditeľnosť).
7. **Editor obsahu projektu** – pridávanie, úprava, mazanie a zmena poradia blokov bez prenačítania stránky (AJAX).
8. **Nastavenia profilu** – úprava profilu a výber témy portfólia s náhľadmi tém.
9. **Administrácia používateľov a projektov** – zoznam používateľov s možnosťou zablokovania, mazanie nevhodných projektov.
10. **Administrácia tém, kategórií a štítkov** – CRUD nad témami (vrátane nahrania náhľadového obrázka), kategóriami a štítkami.

## Rozdelenie funkcionality
**Základné funkcie**
- Registrácia, prihlásenie a odhlásenie, heslá uložené ako hash.
- Role používateľ a administrátor, kontrola oprávnení na strane servera (používateľ upravuje iba vlastný obsah, zablokovaný používateľ sa nevie prihlásiť).
- CRUD nad projektmi vrátane nahrania titulného obrázka.
- CRUD nad blokmi obsahu so zmenou poradia tlačidlami hore/dole, realizované cez AJAX.
- Nahrávanie obrázkov do blokov s kontrolou typu a veľkosti súboru.
- Priraďovanie štítkov k projektom (M:N).
- CRUD nad témami, kategóriami a štítkami pre administrátora.
- Výber témy používateľom a zobrazenie portfólia a projektov podľa témy (rozloženie + CSS premenné).
- Verejné portfólio a detail projektu, súkromné projekty viditeľné iba autorovi.
- Vyhľadávanie a filtrovanie projektov podľa kategórie a štítkov cez AJAX.
- Blokovanie používateľov a mazanie nevhodných projektov administrátorom.
- Validácia všetkých vstupov na strane klienta aj servera.
- Responzívny dizajn.
- Spustenie v prostredí Docker s importom ukážkových dát pri prvom spustení.

**Rozširujúce funkcie**
- Zmena poradia blokov presúvaním myšou (HTML5 Drag and Drop API).
- Varianty zobrazenia blokov (napr. obrázok vľavo/vpravo, zvýraznený text, obrázok na celú šírku), vyberané z pevného zoznamu.
- Blok typu galéria obrázkov (napr. na prezentáciu kresieb alebo fotografií).
- Živý náhľad témy pri jej vytváraní v administrácii.
- Stránkovanie alebo postupné načítavanie zoznamu projektov cez AJAX.
- Štýly písané v SASS.
- Import repozitárov z GitHub API ako podklad pre nový projekt.

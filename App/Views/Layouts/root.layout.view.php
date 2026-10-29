<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */

// Aktuálna stránka z URL
$currentController = strtolower(trim($_GET['c'] ?? '')) ?: 'home';
$currentAction = trim($_GET['a'] ?? '') ?: 'index';
$isActive = fn(string $controller, string $action = 'index') => $currentController === $controller && $currentAction === $action;

?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= App\Configuration::APP_NAME ?></title>
    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="<?= $link->asset('favicons/favicon.svg') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $link->asset('css/style.css') ?>">
</head>

<body>
    <header class="site-header">
        <nav class="navbar navbar-expand-lg container-xl py-2" aria-label="Hlavná navigácia">
            <a class="navbar-brand d-flex align-items-center" href="<?= $link->url("home.index") ?>">
                <img src="<?= $link->asset('images/folio-logo.svg') ?>" alt="Folio">
            </a>

            <!-- Na mobile: avatar ostáva viditeľný vedľa hamburgera -->
            <?php if ($user->isLoggedIn()) { ?>
                <div class="d-flex align-items-center gap-2 order-lg-last ms-auto ms-lg-3">
                    <div class="dropdown">
                        <button class="btn btn-link p-0 d-flex align-items-center gap-1 text-decoration-none text-body"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Používateľské menu">
                            <span class="avatar">JK</span>
                            <i class="bi bi-chevron-down small"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text small text-secondary">Prihlásený:
                                    <strong><?= $user->getName() ?></strong></span></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= $link->url('user.index') ?>"><i
                                        class="bi bi-person me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="<?= $link->url('auth.logout') ?>"><i
                                        class="bi bi-box-arrow-right me-2"></i>Odhlásiť sa</a>
                            </li>
                        </ul>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                        aria-controls="mainNav" aria-expanded="false" aria-label="Zobraziť menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            <?php } else { ?>
                <!-- Neprihlásený: na mobile iba hamburger, tlačidlá sú v zbalenom menu -->
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false"
                    aria-label="Zobraziť menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php } ?>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0 gap-lg-1">
                    <li class="nav-item"><a class="nav-link<?= $isActive('home', 'index') ? ' active' : '' ?>"
                            <?= $isActive('home', 'index') ? 'aria-current="page"' : '' ?>
                            href="<?= $link->url('home.index') ?>">Objavovať</a>
                    </li>
                    <li class="nav-item"><a class="nav-link<?= $isActive('home', 'projects') ? ' active' : '' ?>"
                            <?= $isActive('home', 'projects') ? 'aria-current="page"' : '' ?>
                            href="<?= $link->url('home.projects') ?>">Moje projekty</a>
                    </li>
                    <?php if ($user->isLoggedIn()) { ?>
                        <li class="nav-item"><a class="nav-link<?= $isActive('user', 'settings') ? ' active' : '' ?>"
                                <?= $isActive('user', 'settings') ? 'aria-current="page"' : '' ?>
                                href="<?= $link->url('user.settings') ?>">Nastavenia</a>
                        </li>
                    <?php } ?>
                    <?php if ($user->isLoggedIn() /** TODO: kontrola ci je admin */) { ?>
                        <li class="nav-item"><a class="nav-link nav-admin<?= $isActive('admin') ? ' active' : '' ?>"
                                <?= $isActive('admin') ? 'aria-current="page"' : '' ?>
                                href="<?= $link->url('admin.index') ?>">Administrácia</a></li>
                    <?php } ?>
                </ul>
                <form class="header-search flex-grow-1 my-2 my-lg-0" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input class="form-control" type="search" placeholder="Hľadať projekty, autorov…"
                            aria-label="Hľadať">
                    </div>
                </form>
                <?php if (!$user->isLoggedIn()) { ?>
                    <!-- Mobil: pod vyhľadávaním na celú šírku, desktop: vpravo v hlavičke -->
                    <div class="d-flex gap-2 mt-2 mt-lg-0 ms-lg-3">
                        <a class="btn btn-sm btn-outline-primary flex-fill" href="<?= $link->url('auth.login') ?>">Prihlásiť
                            sa</a>
                        <a class="btn btn-sm btn-primary flex-fill" href="<?= $link->url('auth.register') ?>">Registrovať
                            sa</a>
                    </div>
                <?php } ?>
            </div>
        </nav>
    </header>
    <main class="container-xl py-4">
        <?= $contentHTML ?>
    </main>
    <footer class="site-footer py-3 mt-auto">
        <div class="container-xl d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <span>&copy; 2026 Folio – platforma na tvorbu osobných portfólií</span>
            <nav aria-label="Pätička">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="<?= $link->url('home.about') ?>">O projekte</a></li>
                    <li class="list-inline-item"><a href="<?= $link->url('home.terms') ?>">Podmienky</a></li>
                    <li class="list-inline-item"><a href="<?= $link->url('home.contact') ?>">Kontakt</a></li>
                </ul>
            </nav>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
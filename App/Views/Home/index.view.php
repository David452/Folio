<?php

/** @var \Framework\Support\LinkGenerator $link */
?>
<h1 class="page-title mb-3">Objavovať projekty</h1>

<!-- Filtre: kategorie + stitky -->
<section class="mb-4" aria-label="Filtre projektov">
    <div class="filter-scroll mb-2" role="group" aria-label="Kategórie">
        <button type="button" class="btn btn-sm filter-pill">Všetky</button>
        <button type="button" class="btn btn-sm filter-pill active" aria-pressed="true">Programovanie</button>
        <button type="button" class="btn btn-sm filter-pill">Ručné práce</button>
        <button type="button" class="btn btn-sm filter-pill">Výtvarné umenie</button>
        <button type="button" class="btn btn-sm filter-pill">Fotografia</button>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2" role="group" aria-label="Štítky kategórie">
        <span class="section-label me-1">Štítky</span>
        <button type="button" class="btn btn-sm tag-filter active" aria-pressed="true">PHP</button>
        <button type="button" class="btn btn-sm tag-filter">Docker</button>
        <button type="button" class="btn btn-sm tag-filter">JavaScript</button>
        <button type="button" class="btn btn-sm tag-filter">Python</button>
        <button type="button" class="btn btn-sm tag-filter">SQL</button>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3 pt-3 border-top">
        <?php if (false /** TODO: aspon nejake projekty */) { ?><span
                class="text-secondary small"><?= /** TODO: pocet nacitanych */ 6 ?>
                projektov · najnovšie ako prvé</span> <?php } ?>
        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0">
            <i class="bi bi-x-circle me-1"></i>Zrušiť filtre
        </button>
    </div>

    <!-- zoznam projektov -->
    <?php if (false /** TODO: podmienka ak pocet filtrovanych projektov je > 0 */) { ?>
        <section aria-label="Zoznam projektov" hidden>
            <div class="row g-4">

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Webová aplikácia na správu úloh"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Webová aplikácia na správu úloh</h2>
                            <p class="card-text text-secondary small project-desc">Jednoduchý to-do manažér v PHP s
                                prihlásením, kategóriami a AJAX úpravami bez prenačítania.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">PHP</span>
                                <span class="badge tag-pill">SQL</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">JK</span>
                            <span class="small fw-medium">jana_k</span>
                            <span class="small text-secondary ms-auto">pred 2 dňami</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Pletená čiapka s vrkočom"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Pletená čiapka s vrkočom</h2>
                            <p class="card-text text-secondary small project-desc">Zimná čiapka z merino vlny. Postup,
                                spotreba priadze a vzor vrkoča krok za krokom.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">pletenie</span>
                                <span class="badge tag-pill">zima</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">MH</span>
                            <span class="small fw-medium">maria_h</span>
                            <span class="small text-secondary ms-auto">pred 4 dňami</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Akvarel – ranná hmla"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Akvarel – ranná hmla</h2>
                            <p class="card-text text-secondary small project-desc">Séria troch krajinomalieb v technike
                                mokré do mokrého, spolu s použitými farbami.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">akvarel</span>
                                <span class="badge tag-pill">krajina</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">PN</span>
                            <span class="small fw-medium">peter_n</span>
                            <span class="small text-secondary ms-auto">pred týždňom</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Docker prostredie pre PHP vývoj"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Docker prostredie pre PHP vývoj</h2>
                            <p class="card-text text-secondary small project-desc">Hotový docker-compose s Apache, PHP,
                                MariaDB a phpMyAdminom na rýchly štart školských projektov.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">Docker</span>
                                <span class="badge tag-pill">PHP</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">TB</span>
                            <span class="small fw-medium">tomas_b</span>
                            <span class="small text-secondary ms-auto">pred týždňom</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Portrétna séria v uliciach Bratislavy"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Portrétna séria v uliciach Bratislavy</h2>
                            <p class="card-text text-secondary small project-desc">Dvanásť čiernobielych portrétov
                                zachytených počas jedného leta, s popisom svetelných podmienok.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">portrét</span>
                                <span class="badge tag-pill">čiernobiela</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">LS</span>
                            <span class="small fw-medium">lucia_s</span>
                            <span class="small text-secondary ms-auto">pred 2 týždňami</span>
                        </div>
                    </article>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card project-card h-100">
                        <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                            aria-label="Detail projektu Hra Had v JavaScripte"></a>
                        <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                class="bi bi-image me-2"></i>titulný obrázok</div>
                        <div class="card-body">
                            <h2 class="h5 card-title mb-1">Hra Had v JavaScripte</h2>
                            <p class="card-text text-secondary small project-desc">Klasický Snake na canvase – ovládanie
                                klávesnicou aj dotykom, ukladanie najlepšieho skóre.</p>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge tag-pill">JavaScript</span>
                            </div>
                        </div>
                        <div class="card-footer project-author">
                            <span class="avatar avatar-sm">JK</span>
                            <span class="small fw-medium">jana_k</span>
                            <span class="small text-secondary ms-auto">pred mesiacom</span>
                        </div>
                    </article>
                </div>

            </div>

            <!-- Stránkovanie -->
            <nav class="mt-4 d-flex justify-content-center" aria-label="Stránkovanie projektov">
                <ul class="pagination mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#" aria-label="Predchádzajúca"><i
                                class="bi bi-chevron-left"></i></a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#" aria-label="Nasledujúca"><i
                                class="bi bi-chevron-right"></i></a></li>
                </ul>
            </nav>
        </section>
    <?php } ?>

    <!-- Filtre nic nenasli -->
    <?php if (false /** TODO: Filtre nic nenasli */) { ?>
        <section class="empty-state" aria-label="Žiadne výsledky" hidden>
            <i class="bi bi-search display-5 text-secondary"></i>
            <h2 class="h4 mt-3">Nenašli sa žiadne projekty</h2>
            <p class="text-secondary mx-auto mb-3" style="max-width: 32rem">
                Pre vybranú kombináciu kategórie a štítkov zatiaľ nič nemáme. Skús odstrániť niektorý štítok alebo zmeniť
                kategóriu.
            </p>
            <button type="button" class="btn btn-outline-primary">Zrušiť filtre</button>
        </section>
    <?php } ?>

    <!-- Este ziadny projekt neexistuje -->
    <?php if (true /** nie su ziadne projekty */) { ?>
        <section class="empty-state" aria-label="Zatiaľ žiadne projekty">
            <i class="bi bi-collection display-5 text-secondary"></i>
            <h2 class="h4 mt-3">Zatiaľ tu nie je žiadny projekt</h2>
            <p class="text-secondary mx-auto mb-3" style="max-width: 32rem">
                Buď prvý, kto ukáže svoju tvorbu. Vytvor si portfólio a pridaj prvý projekt – zvládne to aj bez znalostí
                tvorby webu.
            </p>
            <!-- Neprihlásený: Zaregistrovať sa / Prihlásiť sa; prihlásený: Vytvoriť projekt -->
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="<?= $link->url('home.projects') ?>" class="btn btn-primary"><i
                        class="bi bi-plus-lg me-1"></i>Vytvoriť projekt</a>
                <a href="#" class="btn btn-outline-primary">Zaregistrovať sa</a>
            </div>
        </section>
    <?php } ?>
</section>
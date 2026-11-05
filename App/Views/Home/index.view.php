<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Category[] $categories */
/** @var \App\Models\Tag[] $tags */
/** @var \App\Models\Project[] $projects */

?>
<h1 class="page-title mb-3">Objavovať projekty</h1>

<!-- Filtre: kategorie + stitky -->
<section class="mb-4" aria-label="Filtre projektov">
    <div class="filter-scroll mb-2" role="group" aria-label="Kategórie">
        <button type="button" class="btn btn-sm filter-pill active">Všetky</button>
        <?php foreach ($categories as $category) : ?>
            <button type="button" class="btn btn-sm filter-pill">
                <?= $category->name ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2" role="group" aria-label="Štítky kategórie">
        <span class="section-label me-1">Štítky</span>
        <?php foreach ($tags as $tag) : ?>
            <button type="button" class="btn btn-sm tag-filter">
                <?= $tag->name ?>
<!--                TODO: STITKY IBA PRE DANU KATEGORIU-->
            </button>
        <?php endforeach; ?>

    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3 pt-3 border-top">
        <?php if (count($projects) > 0) { ?><span
                class="text-secondary small"><?= count($projects) ?>
                projektov · najnovšie ako prvé</span> <?php } ?>
        <button type="button" class="btn btn-sm btn-link text-decoration-none p-0">
            <i class="bi bi-x-circle me-1"></i>Zrušiť filtre
        </button>
    </div>

    <!-- zoznam projektov -->
    <?php if (count($projects) > 0) { ?>
        <section aria-label="Zoznam projektov" hidden>
            <div class="row g-4">
                <?php foreach ($projects as $project) : ?>
<!--                TODO: spravne udaje-->
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card project-card h-100">
                            <a href="<?= $link->url('home.projects') ?>" class="stretched-link"
                               aria-label="Detail projektu Webová aplikácia na správu úloh"></a>
                            <div class="img-placeholder project-cover rounded-0 rounded-top"><i
                                        class="bi bi-image me-2"></i>titulný obrázok</div>
                            <div class="card-body">
                                <h2 class="h5 card-title mb-1"><?= $project->title ?></h2>
                                <p class="card-text text-secondary small project-desc"><?= $project->short_description ?></p>
                                <div class="d-flex flex-wrap gap-1">
<!--                                    TODO: nacitanie tags-->
                                    <span class="badge tag-pill">PHP</span>
                                    <span class="badge tag-pill">SQL</span>
                                </div>
                            </div>
                            <div class="card-footer project-author">
<!--                                TODO: nacitanie user informacii-->
                                <span class="avatar avatar-sm">JK</span>
                                <span class="small fw-medium">jana_k</span>
<!--                                TODO: formatovanie updated_at-->
                                <span class="small text-secondary ms-auto">pred 2 dňami</span>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>

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
    <?php if (true /** TODO: nie su ziadne projekty */) { ?>
        <section class="empty-state" aria-label="Zatiaľ žiadne projekty">
            <i class="bi bi-collection display-5 text-secondary"></i>
            <h2 class="h4 mt-3">Zatiaľ tu nie je žiadny projekt</h2>
            <p class="text-secondary mx-auto mb-3" style="max-width: 32rem">
                Buď prvý, kto ukáže svoju tvorbu. Vytvor si portfólio a pridaj prvý projekt – zvládne to aj bez znalostí
                tvorby webu.
            </p>
            <!-- Neprihlásený: Zaregistrovať sa / Prihlásiť sa; prihlásený: Vytvoriť projekt -->
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="<?= $link->url('home.projectForm') ?>" class="btn btn-primary"><i
                        class="bi bi-plus-lg me-1"></i>Vytvoriť projekt</a>
                <a href="#" class="btn btn-outline-primary">Zaregistrovať sa</a>
            </div>
        </section>
    <?php } ?>
</section>
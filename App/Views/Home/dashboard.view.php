<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Project[] $projects */

$publicCount = count(array_filter($projects, fn($p) => $p->is_public));
?>

<!-- Záhlavie dashboardu -->
<section
    class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4 pb-3 border-bottom">
    <div>
        <p class="section-label mb-1">Dashboard</p>
        <h1 class="page-title mb-0">Moje projekty</h1>
        <p class="text-secondary mb-0 mt-1">Vitaj späť, <strong class="text-body"><?= $user->getIdentity()->display_name ?></strong>. Tu spravuješ všetko,
            čo ukazuješ vo svojom portfóliu.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="#" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-up-right me-1"></i>Moje portfólio</a>
        <a href="<?= $link->url('home.projectForm') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nový
            projekt</a>
    </div>
</section>

<!-- Štatistiky -->
<section class="row g-3 mb-4" aria-label="Prehľad portfólia">
    <div class="col-6 col-lg-3">
        <div class="stat-tile">
            <span class="stat-icon"><i class="bi bi-collection"></i></span>
            <div>
                <div class="stat-value"><?= count($projects) ?></div>
                <div class="stat-label">Projekty spolu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-tile">
            <span class="stat-icon stat-icon-green"><i class="bi bi-eye"></i></span>
            <div>
                <div class="stat-value"><?= $publicCount ?></div>
                <div class="stat-label">Verejné</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-tile">
            <span class="stat-icon stat-icon-slate"><i class="bi bi-lock"></i></span>
            <div>
                <div class="stat-value"><?= count($projects) - $publicCount ?></div>
                <div class="stat-label">Súkromné</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-tile">
            <span class="stat-icon stat-icon-amber"><i class="bi bi-palette"></i></span>
            <div>
                <div class="stat-value stat-value-text">Minimal</div>
                <div class="stat-label">Téma portfólia · <a href="<?= $link->url('user.settings') ?>">zmeniť</a></div>
            </div>
        </div>
    </div>
</section>

<!-- Nástroje: filter viditeľnosti + vyhľadávanie -->
<section class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3"
    aria-label="Filter mojich projektov">
    <div class="filter-scroll" role="group" aria-label="Viditeľnosť">
        <button type="button" class="btn btn-sm filter-pill active">Všetky (<?= count($projects) ?>)</button>
        <button type="button" class="btn btn-sm filter-pill">Verejné (<?= $publicCount ?>)</button>
        <button type="button" class="btn btn-sm filter-pill">Súkromné (<?= count($projects) - $publicCount ?>)</button>
    </div>
    <div class="input-group dashboard-search">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="search" class="form-control" placeholder="Hľadať v mojich projektoch…"
            aria-label="Hľadať v mojich projektoch">
    </div>
</section>

<!-- Zoznam projektov -->
<section aria-label="Zoznam mojich projektov">
    <?php foreach ($projects as $i => $project) : ?>
        <article class="card dash-project mb-3">
            <div class="row g-0 align-items-stretch">
                <div class="col-sm-3 col-lg-2">
                    <div class="img-placeholder dash-cover h-100 rounded-0 rounded-start"><i
                            class="bi bi-image me-2"></i><span class="d-sm-none d-lg-inline">obrázok</span></div>
                </div>
                <div class="col-sm-9 col-lg-10">
                    <div class="card-body d-flex flex-column flex-lg-row gap-3 h-100">
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <h2 class="h5 mb-0"><?= $project->title ?></h2>
                                <?php if ($project->is_public) : ?>
                                    <span class="badge rounded-pill text-bg-success-subtle border border-success-subtle text-success-emphasis"><i
                                            class="bi bi-eye"></i> Verejný</span>
                                <?php else : ?>
                                    <span class="badge rounded-pill text-bg-light border text-secondary"><i
                                            class="bi bi-lock"></i> Súkromný</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-secondary small project-desc mb-2"><?= $project->short_description ?></p>
                            <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
<!--                                --><?php //foreach ($project['tags'] as $tag) : ?>
<!--                                    <span class="badge tag-pill">--><?php //= $tag ?><!--</span>-->
<!--                                --><?php //endforeach; ?>
<!--                                TODO: TAGS OF A PROJECT-->
                            </div>
                            <div class="small text-secondary">
                                <i class="bi bi-layout-text-sidebar-reverse me-1"></i>
<!--                                --><?php //= $project['blocks'] ?><!-- -->
                                TODO blokov
<!--                                TODO: pocet blokov-->
                                <span class="mx-1">·</span>
                                <i class="bi bi-clock-history me-1"></i>upravené
<!--                                --><?php //= $project['updated'] ?>
<!--                                TODO: formatovanie datumu-->
                                TODO
                            </div>
                        </div>
                        <div class="dash-actions d-flex flex-row flex-lg-column justify-content-lg-center gap-2">
                            <a href="<?= $link->url('home.projects')?>" class="btn btn-primary btn-sm flex-fill"><i
                                    class="bi bi-pencil-square me-1"></i>Upraviť obsah</a>
                            <div class="btn-group btn-group-sm flex-fill" role="group" aria-label="Ďalšie akcie">
                                <a href="<?= $link->url('home.projectForm', ["is_edit" => true, "project_id" => $project->id], appendParameters: true) ?>" class="btn btn-outline-secondary"
                                    title="Upraviť údaje projektu"><i class="bi bi-sliders"></i><span
                                        class="d-none d-xl-inline ms-1">Údaje</span></a>
                                <a href="#" class="btn btn-outline-secondary" title="Zobraziť verejnú stránku"><i
                                        class="bi bi-box-arrow-up-right"></i></a>
                                <button type="button" class="btn btn-outline-danger" title="Zmazať projekt"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-project="<?= $project->title ?>"
                                    data-id="<?= $project->id ?>"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>

    <!-- Rýchle pridanie ďalšieho projektu -->
    <a href="<?= $link->url('home.projectForm') ?>" class="new-project-tile">
        <i class="bi bi-plus-circle fs-3"></i>
        <span class="fw-semibold">Pridať ďalší projekt</span>
        <span class="small text-secondary">Aj koníček si zaslúži vlastnú stránku</span>
    </a>
</section>

<!-- Prázdny stav (zobraziť, keď používateľ nemá žiadny projekt) -->
<?php if (false /** TODO: používateľ nemá žiadny projekt */) { ?>
    <section class="empty-state" aria-label="Zatiaľ žiadne projekty">
        <i class="bi bi-folder-plus display-5 text-secondary"></i>
        <h2 class="h4 mt-3">Ešte nemáš žiadny projekt</h2>
        <p class="text-secondary mx-auto mb-3" style="max-width: 32rem">
            Vytvor prvý projekt, pridaj mu štítky a poskladaj jeho stránku z blokov obsahu.
        </p>
        <a href="<?= $link->url('home.projectForm') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Vytvoriť
            prvý projekt</a>
    </section>
<?php } ?>

<!-- Potvrdenie zmazania -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h5" id="deleteModalTitle"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Zmazať
                    projekt?</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Projekt <strong id="deleteModalProject">…</strong> sa natrvalo zmaže aj so všetkými
                    blokmi obsahu.</p>
                <p class="small text-secondary mb-0">Túto akciu nie je možné vrátiť späť.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                <form method="post" action="<?= $link->url('home.projectDelete') ?>">
                    <input type="hidden" name="project_id" id="deleteProjectId" value="">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i>Zmazať</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // TODO: skontrolovat
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        document.getElementById('deleteModalProject').textContent = btn.dataset.project;
        document.getElementById('deleteProjectId').value = btn.dataset.id;
    });
</script>

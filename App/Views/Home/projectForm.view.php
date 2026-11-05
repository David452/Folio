<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var bool $isEdit */
/** @var \App\Models\Project $project */

// Ukážkové štítky po kategóriách – neskôr z DB (Category / Tag)
$tagsByCategory = [
    'Programovanie a vývoj' => ['PHP'],
];
$selected = $isEdit ? ['PHP', 'PHP'] : [];
?>

<!-- Záhlavie -->
<section class="mb-4 pb-3 border-bottom">
    <a href="<?= $link->url('home.dashboard') ?>" class="small text-decoration-none"><i
            class="bi bi-arrow-left"></i> Moje projekty</a>
    <h1 class="page-title mt-1 mb-1"><?= $isEdit ? 'Upraviť údaje projektu' : 'Nový projekt' ?></h1>
    <p class="text-secondary mb-0">
        <?= $isEdit
            ? 'Zmeň základné informácie o projekte. Obsah stránky upravuješ v editore.'
            : 'Najprv vyplň základné údaje. Obsah stránky projektu poskladáš z blokov v ďalšom kroku.' ?>
    </p>
</section>

<form class="needs-validation" method="post" enctype="multipart/form-data" action="<?= $isEdit? $link->url('home.projectUpdate') : $link->url('home.projectSave') ?>" novalidate>
    <div class="row g-4">

        <!-- Ľavý stĺpec: základné údaje -->
        <div class="col-lg-8">
            <section class="card mb-4" aria-labelledby="basicTitle">
                <div class="card-body">
                    <h2 id="basicTitle" class="h5 pb-2 mb-3 border-bottom">Základné údaje</h2>

                    <div class="mb-3">
                        <label for="pTitle" class="form-label">Názov projektu <span class="text-danger"
                                aria-hidden="true">*</span></label>
                        <input id="pTitle" name="title" type="text" class="form-control form-control-lg"
                            maxlength="128" required placeholder="napr. Pletený sveter s copánkovým vzorom"
                            value="<?= $isEdit ? $project->title : '' ?>">
                        <div class="invalid-feedback">Zadaj názov projektu (max. 128 znakov).</div>
                    </div>

                    <div class="mb-0">
                        <label for="pDesc" class="form-label">Krátky popis <span class="text-danger"
                                aria-hidden="true">*</span></label>
                        <textarea id="pDesc" name="short_description" class="form-control" rows="4" maxlength="256"
                            required
                            placeholder="Jedna-dve vety, ktoré sa zobrazia na karte projektu."><?= $isEdit ? $project->short_description : '' ?></textarea>
                        <div class="invalid-feedback">Zadaj krátky popis (max. 256 znakov).</div>
                        <div class="form-text text-end"><span id="descCount">0</span> / 256</div>
                    </div>
                </div>
            </section>

            <section class="card" aria-labelledby="coverTitle">
                <div class="card-body">
                    <h2 id="coverTitle" class="h5 pb-2 mb-3 border-bottom">Titulný obrázok</h2>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <p class="small text-secondary mb-1">Náhľad na karte projektu</p>
                            <div class="img-placeholder project-cover w-100"><i class="bi bi-image fs-3"></i></div>
                        </div>
                        <div class="col-md-7">
                            <div class="dropzone">
                                <span><i class="bi bi-cloud-arrow-up fs-4"></i></span>
                                <span>Presuň obrázok sem alebo</span>
                                <label class="btn btn-sm btn-outline-primary mb-0">
                                    Vybrať súbor <input name="cover_image" type="file" accept="image/png, image/jpeg"
                                        hidden>
                                </label>
                                <span class="small text-secondary">JPG / PNG, max. 5 MB · odporúčaný pomer 16:9</span>
                            </div>
                            <?php if ($isEdit) : ?>
                                <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none px-0 mt-2"><i
                                        class="bi bi-x-circle me-1"></i>Odstrániť obrázok</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Pravý stĺpec: štítky, viditeľnosť, uloženie -->
        <aside class="col-lg-4">
            <div class="sticky-panel">
                <section class="card mb-4" aria-labelledby="tagsTitle">
                    <div class="card-body">
                        <h2 id="tagsTitle" class="h5 pb-2 mb-3 border-bottom">Štítky</h2>

                        <label for="pCategory" class="form-label small text-secondary">1. Vyber kategóriu</label>
                        <select id="pCategory" class="form-select mb-3">
                            <?php foreach (array_keys($tagsByCategory) as $n => $category) : ?>
                                <option<?= $n === 1 ? ' selected' : '' ?>><?= $category ?></option>
                            <?php endforeach; ?>
                        </select>

                        <p class="small text-secondary mb-1">2. Zaškrtni štítky</p>
                        <div class="tag-box row row-cols-2 g-1 mx-0 mb-3">
                            <?php foreach ($tagsByCategory['Programovanie a vývoj'] as $n => $tag) : ?>
                                <div class="col form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" id="tag<?= $n ?>"
                                        value="<?= $tag ?>"<?= in_array($tag, $selected) ? ' checked' : '' ?>>
                                    <label class="form-check-label" for="tag<?= $n ?>"><?= $tag ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <p class="small text-secondary mb-1">Vybrané štítky:</p>
                        <div class="d-flex flex-wrap gap-1 mb-2">
<!--                            TODO: stitky-->
                            <?php foreach ($selected as $tag) : ?>
                                <span class="badge rounded-pill tag-pill d-inline-flex align-items-center gap-1"><?= $tag ?>
                                    <button type="button" class="btn-close" aria-label="Odobrať štítok <?= $tag ?>"></button></span>
                            <?php endforeach; ?>
                            <?php if (!$selected) : ?>
                                <span class="small fst-italic text-secondary">zatiaľ žiadne</span>
                            <?php endif; ?>
                        </div>
                        <p class="small fst-italic text-secondary mb-0">Chýba štítok? Nové štítky pridáva administrátor.
                        </p>
                    </div>
                </section>

                <section class="card mb-4" aria-labelledby="visTitle">
                    <div class="card-body">
                        <h2 id="visTitle" class="h5 pb-2 mb-3 border-bottom">Viditeľnosť</h2>
                        <div class="visibility-option mb-2">
                            <input class="visually-hidden" type="radio" name="is_public" id="vPublic" value="1" checked>
                            <label for="vPublic">
                                <i class="bi bi-eye fs-5"></i>
                                <span><strong>Verejný</strong><small class="d-block text-secondary">Vidí ho ktokoľvek
                                        a nájde ho vo vyhľadávaní.</small></span>
                            </label>
                        </div>
                        <div class="visibility-option">
                            <input class="visually-hidden" type="radio" name="is_public" id="vPrivate" value="0">
                            <label for="vPrivate">
                                <i class="bi bi-lock fs-5"></i>
                                <span><strong>Súkromný</strong><small class="d-block text-secondary">Vidíš ho iba ty.
                                        Hodí sa na rozpracované veci.</small></span>
                            </label>
                        </div>
                    </div>
                </section>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <?= $isEdit ? '<i class="bi bi-check2 me-1"></i>Uložiť zmeny' : 'Vytvoriť a pokračovať <i class="bi bi-arrow-right ms-1"></i>' ?>
                    </button>
                    <a href="<?= $link->url('home.dashboard') ?>" class="btn btn-outline-secondary">Zrušiť</a>
                </div>
                <?php if ($isEdit) : ?>
                    <hr>
                    <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none px-0"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Zmazať projekt
                    </button>
                <?php endif; ?>
            </div>
        </aside>
    </div>
    <input type="hidden" name="project_id" value="<?= $isEdit ? $project->id : null ?>"/>
</form>

<?php if ($isEdit) : ?>
<!-- Potvrdenie zmazania -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h5" id="deleteModalTitle">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Zmazať projekt?
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Projekt <strong><?= $project->title ?></strong> sa natrvalo zmaže aj so všetkými blokmi obsahu.</p>
                <p class="small text-secondary mb-0">Túto akciu nie je možné vrátiť späť.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                <form method="post" action="<?= $link->url('home.projectDelete') ?>">
                    <input type="hidden" name="project_id" value="<?= $project->id ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Zmazať
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    // Počítadlo znakov popisu + zobrazenie chýb validácie (statická ukážka)
    (function () {
        const desc = document.getElementById('pDesc');
        const count = document.getElementById('descCount');
        const update = () => count.textContent = desc.value.length;
        desc.addEventListener('input', update);
        update();

        const form = document.querySelector('form.needs-validation');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
            }
            form.classList.add('was-validated');
        });
    })();
</script>

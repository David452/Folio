<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Category[] $categories */
/** @var \App\Models\Tag[] $tags */

$tagCounts = [];
$tagsByCategory = [];

foreach ($tags as $tag) {
    $tagCounts[$tag->category_id] = ($tagCounts[$tag->category_id] ?? 0) + 1;
    $tagsByCategory[$tag->category_id][] = $tag;
}

?>

<section class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
    <div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <h1 class="page-title mb-0">Správa kategórií a štítkov</h1>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 flex-shrink-0">
        <button type="button" class="btn btn-outline-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCreateTag">
            <i class="bi bi-tag me-1"></i>Nový štítok
        </button>
        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
            <i class="bi bi-plus-lg me-1"></i>Nová kategória
        </button>
    </div>
</section>

<nav class="admin-subnav mb-4" aria-label="Sekcie administrácie">
    <ul class="nav nav-pills gap-1 p-1 bg-white border rounded-3 shadow-sm">
        <li class="nav-item">
            <a class="nav-link active d-flex align-items-center gap-2" href="# <?= /** TODO: kategorie */ null ?>">
                <i class="bi bi-tags"></i>
                <span>Kategórie a štítky</span>
                <span class="badge bg-primary text-white rounded-pill px-2" id="navCategoryCount"><?= count($categories) . ' / ' . count($tags) ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 text-secondary" href="# <?= /** TODO: sprava pouzivatelov */ null ?>" title="Prehľad používateľov platformy">
                <i class="bi bi-people"></i>
                <span>Používatelia</span>
                <span class="badge bg-light text-secondary rounded-pill border">14</span> <!-- TODO: pocet pouzivatelov -->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 text-secondary" href="# <?= /** TODO: sprava tem portfolii */ null ?>" title="Správa tém portfólií">
                <i class="bi bi-palette"></i>
                <span>Témy portfólií</span>
                <span class="badge bg-light text-secondary rounded-pill border">4</span> <!-- TODO: pocet tem -->
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 text-secondary" href="# <?= /** TODO: moderovanie projektov */ null ?>" title="Moderácia projektov používateľov">
                <i class="bi bi-shield-check"></i>
                <span>Moderácia projektov</span>
                <span class="badge bg-light text-secondary rounded-pill border">128</span> <!-- TODO: pocet projektov -->
            </a>
        </li>
    </ul>
</nav>

<div class="card border mb-4 shadow-sm bg-white">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">

            <!-- Hľadanie -->
            <div class="col-12 col-md-7">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="filterSearchInput" class="form-control border-start-0 ps-0"
                           placeholder="Filtrovať kategórie alebo štítky..." aria-label="Filtrovať kategórie alebo štítky">
                    <button class="btn btn-outline-secondary border-start-0" type="button" id="btnClearSearch" title="Vymazať filter" style="display: none;">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>

            <!-- Filter podľa kategórie -->
            <div class="col-12 col-md-5">
                <select class="form-select form-select-sm" id="filterCategorySelect" aria-label="Filtrovať podľa kategórie">
                    <option value="all" selected>Všetky kategórie (<?= count($categories) ?>)</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id ?>">
                            <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>
                            (<?= $tagCounts[$category->id] ?? 0 ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- Stavový riadok filtrovania -->
        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top small text-secondary">
          <span id="filterResultsSummary">
            Zobrazuje sa <strong id="visibleCategoryCount"><?= count($categories) ?></strong> kategórií
            a <strong id="visibleTagCount"><?= count($tags) ?></strong> štítkov
          </span>
            <span class="d-none d-sm-inline">
            <i class="bi bi-info-circle me-1"></i>Pre rýchle pridanie štítku do konkrétnej kategórie použite inline formulár v spodnej časti karty.
          </span>
        </div>
    </div>
</div>

<section id="categoriesCardsView" class="mb-5" aria-label="Zoznam kategórií so štítkami">
    <div class="row g-4" id="categoriesContainer">
        <?php foreach ($categories as $category) : ?>
            <?php
            $categoryTags = $tagsByCategory[$category->id] ?? [];
            $searchText = $category->name . ' ' . implode(' ', array_map(
                fn($tag) => $tag->name,
                $categoryTags
            ));
            ?>
            <div class="col-12 col-md-6 category-card"
                 data-category-id="<?= $category->id ?>"
                 data-search="<?= htmlspecialchars($searchText, ENT_QUOTES, 'UTF-8') ?>">
                <div class="card h-100 shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <h3 class="category-title"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="small text-secondary">
                                <span class="badge category-count-badge me-1"><?= count($categoryTags) ?> štítkov</span>
                                <span class="text-muted ms-1">• ID: <?= $category->id ?></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-1 category-actions">
                            <button type="button" class="btn btn-outline-primary btn-sm btn-add-tag-modal" data-category-id="<?= $category->id ?>" title="Pridať štítok do tejto kategórie">
                                <i class="bi bi-plus-lg"></i><span class="d-none d-sm-inline ms-1">Štítok</span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-edit-category" data-category-id="<?= $category->id ?>" title="Upraviť názov kategórie" aria-label="Upraviť kategóriu <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete-category" data-category-id="<?= $category->id ?>" title="Zmazať kategóriu" aria-label="Zmazať kategóriu <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <div class="tags-container" id="tags-container-<?= $category->id ?>">
                            <?php foreach ($categoryTags as $tag) : ?>
                                <div class="admin-tag-chip" id="tag-chip-<?= $tag->id ?>">
                                    <span><?= htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8') ?></span>
                                    <button type="button" class="tag-action-btn btn-edit-tag" data-tag-id="<?= $tag->id ?>" title="Upraviť štítok" aria-label="Upraviť štítok <?= htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8') ?>">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="tag-action-btn btn-delete-tag" data-tag-id="<?= $tag->id ?>" title="Zmazať štítok" aria-label="Zmazať štítok <?= htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8') ?>">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Rýchle pridanie štítku priamo na karte -->
                    <div class="quick-add-container">
                        <form class="form-inline-quick-tag d-flex gap-2" data-category-id="<?= $category->id ?>">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control input-quick-tag-name" placeholder="Rýchle pridanie štítku..." maxlength="64" required aria-label="Názov nového štítku pre kategóriu <?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?>">
                                <button class="btn btn-outline-primary" type="submit" title="Pridať štítok">
                                    <i class="bi bi-plus-lg me-1"></i>Pridať
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('filterSearchInput');
            const categorySelect = document.getElementById('filterCategorySelect');
            const clearButton = document.getElementById('btnClearSearch');
            const resetButton = document.getElementById('btnResetFilters');
            const cards = [...document.querySelectorAll('.category-card')];
            const noResultsState = document.getElementById('noResultsState');
            const visibleCategoryCount = document.getElementById('visibleCategoryCount');
            const visibleTagCount = document.getElementById('visibleTagCount');

            function filterCategories() {
                const query = searchInput.value.trim().toLocaleLowerCase('sk');
                const selectedCategory = categorySelect.value;
                let categoryCount = 0;
                let tagCount = 0;

                for (const card of cards) {
                    const matchesCategory =
                        selectedCategory === 'all' || card.dataset.categoryId === selectedCategory;
                    const matchesSearch =
                        card.dataset.search.toLocaleLowerCase('sk').includes(query);
                    const isVisible = matchesCategory && matchesSearch;

                    card.hidden = !isVisible;
                    if (isVisible) {
                        categoryCount++;
                        tagCount += card.querySelectorAll('.admin-tag-chip').length;
                    }
                }

                visibleCategoryCount.textContent = categoryCount;
                visibleTagCount.textContent = tagCount;
                noResultsState.classList.toggle('d-none', categoryCount > 0);
                clearButton.style.display = searchInput.value ? '' : 'none';
            }

            searchInput.addEventListener('input', filterCategories);
            categorySelect.addEventListener('change', filterCategories);
            clearButton.addEventListener('click', () => {
                searchInput.value = '';
                filterCategories();
                searchInput.focus();
            });
            resetButton.addEventListener('click', () => {
                searchInput.value = '';
                categorySelect.value = 'all';
                filterCategories();
            });

            filterCategories();
        });
    </script>

</section>
<!-- Prázdny stav pri nenájdení výsledkov filtra -->
<div id="noResultsState" class="empty-state my-5 d-none">
    <i class="bi bi-search display-6 text-secondary mb-3"></i>
    <h3 class="h5 fw-bold">Žiadne položky nezodpovedajú filtru</h3>
    <p class="text-secondary mb-3" style="max-width: 420px;">
        Nenašli sa žiadne kategórie ani štítky vyhovujúce zadanému vyhľadávaniu. Skúste zmeniť výraz alebo zrušiť filter.
    </p>
    <button type="button" class="btn btn-outline-primary btn-sm" id="btnResetFilters">
        <i class="bi bi-arrow-counterclockwise me-1"></i>Obnoviť filtre
    </button>
</div>


<!-- MODAL 1: Vytvoriť kategóriu -->
<div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-labelledby="modalCreateCategoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= $link->url('admin.categoryCreate') ?>" novalidate>
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="modalCreateCategoryTitle">
                        <i class="bi bi-folder-plus text-primary me-2"></i>Nová kategória
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createCategoryName" class="form-label fw-medium">Názov kategórie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="createCategoryName" placeholder="napr. Herný vývoj a grafika" maxlength="64" required>
                        <div class="invalid-feedback" id="createCategoryNameFeedback">
                            Zadajte platný a jedinečný názov kategórie (max. 64 znakov).
                        </div>
                        <div class="form-text">Názov kategórie sa zobrazí vo filtroch na hlavnej stránke a pri vytváraní projektov.</div>
                    </div>

                    <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-0">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>Po vytvorení kategórie do nej budete môcť okamžite pridávať jednotlivé štítky.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2 me-1"></i>Vytvoriť kategóriu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL 2: Upraviť kategóriu -->
<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="modalEditCategoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= $link->url('admin.categoryUpdate') ?>" novalidate>
                <input type="hidden" id="editCategoryId">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="modalEditCategoryTitle">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Upraviť kategóriu
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label fw-medium">Názov kategórie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editCategoryName" maxlength="64" required>
                        <div class="invalid-feedback" id="editCategoryNameFeedback">
                            Zadajte platný a neprázdny názov kategórie (max. 64 znakov).
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-2 small text-secondary">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Počet priradených štítkov:</span>
                            <strong id="editCategoryTagsCount">0</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Celkový počet ovplyvnených projektov:</span>
                            <strong id="editCategoryProjectsCount">0</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Uložiť zmeny
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL 3: Zmazať kategóriu -->
<div class="modal fade" id="modalDeleteCategory" tabindex="-1" aria-labelledby="modalDeleteCategoryTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <input type="hidden" id="deleteCategoryId">
            <div class="modal-header border-bottom-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h2 class="modal-title fs-5" id="modalDeleteCategoryTitle">Zmazať kategóriu</h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="mb-2">
                    Naozaj chcete natrvalo odstrániť kategóriu <strong id="deleteCategoryNameText" class="text-dark"></strong>?
                </p>

                <div id="deleteCategoryWarning" class="alert alert-warning py-2 px-3 small my-3">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle me-1"></i>Upozornenie na podriadené štítky:</div>
                    <div>
                        Táto kategória obsahuje <strong id="deleteCategoryTagsCountText">0</strong> štítkov, ktoré sú použité v <strong id="deleteCategoryProjectsCountText">0</strong> projektoch.
                    </div>
                </div>

                <div class="form-check" id="deleteCategoryCascadeCheckWrapper">
                    <input class="form-check-input" type="checkbox" id="deleteCategoryCascadeCheck" checked>
                    <label class="form-check-label small text-secondary" for="deleteCategoryCascadeCheck">
                        Zmazať aj všetky priradené štítky v tejto kategórii
                    </label>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteCategory">
                    <i class="bi bi-trash me-1"></i>Áno, odstrániť kategóriu
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 4: Vytvoriť štítok -->
<div class="modal fade" id="modalCreateTag" tabindex="-1" aria-labelledby="modalCreateTagTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= $link->url('admin.tagCreate') ?>" novalidate>
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="modalCreateTagTitle">
                        <i class="bi bi-tag text-primary me-2"></i>Nový štítok
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="createTagCategory" class="form-label fw-medium">Materská kategória <span class="text-danger">*</span></label>
                        <select class="form-select" id="createTagCategory" required>
                            <!-- TODO: Naplnené dynamicky -->
                        </select>
                        <div class="invalid-feedback">Vyberte kategóriu, do ktorej bude štítok patriť.</div>
                    </div>

                    <div class="mb-3">
                        <label for="createTagName" class="form-label fw-medium">Názov štítku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="createTagName" placeholder="napr. TypeScript, Vue.js, Akryl..." maxlength="64" required>
                        <div class="invalid-feedback" id="createTagNameFeedback">
                            Zadajte názov štítku (max. 64 znakov). Názov musí byť v rámci kategórie unikátny.
                        </div>
                        <div class="form-text">Štítok bude okamžite dostupný používateľom pri tvorbe a úprave projektov.</div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="createTagStayOpen">
                        <label class="form-check-label small text-secondary" for="createTagStayOpen">
                            Po uložení nezatvárať okno a pridať ďalší štítok
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Vytvoriť štítok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 5: Upraviť štítok -->
<div class="modal fade" id="modalEditTag" tabindex="-1" aria-labelledby="modalEditTagTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= $link->url('admin.tagEdit') ?>" novalidate>
                <input type="hidden" id="editTagId">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="modalEditTagTitle">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Upraviť štítok
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="editTagCategory" class="form-label fw-medium">Kategória <span class="text-danger">*</span></label>
                        <select class="form-select" id="editTagCategory" required>
                            <!-- Naplnené dynamicky -->
                        </select>
                        <div class="form-text">Môžete štítok presunúť do inej kategórie.</div>
                    </div>

                    <div class="mb-3">
                        <label for="editTagName" class="form-label fw-medium">Názov štítku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editTagName" maxlength="64" required>
                        <div class="invalid-feedback" id="editTagNameFeedback">
                            Zadajte platný názov štítku (max. 64 znakov).
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-2 small text-secondary d-flex justify-content-between align-items-center">
                        <span>Aktuálne použitie v projektoch:</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" id="editTagProjectsCount">0 projektov</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Uložiť zmeny
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 6: Zmazať štítok -->
<div class="modal fade" id="modalDeleteTag" tabindex="-1" aria-labelledby="modalDeleteTagTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <input type="hidden" id="deleteTagId">
            <div class="modal-header border-bottom-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h2 class="modal-title fs-5" id="modalDeleteTagTitle">Odstrániť štítok</h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavrieť"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="mb-2">
                    Naozaj chcete natrvalo zmazať štítok <strong id="deleteTagNameText" class="text-dark"></strong>?
                </p>
                <div class="alert alert-warning py-2 px-3 small my-3">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    Tento štítok je aktuálne priradený v <strong id="deleteTagProjectsCountText">0</strong> používateľských projektoch. Po vymazaní bude zo všetkých projektov automaticky odstránený.
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Zrušiť</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteTag">
                    <i class="bi bi-trash me-1"></i>Áno, zmazať štítok
                </button>
            </div>
        </div>
    </div>
</div>
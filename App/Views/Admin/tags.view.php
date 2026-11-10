<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Category[] $categories */
/** @var \App\Models\Tag[] $tags */

$escape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$tagsByCategory = [];

foreach ($tags as $tag) {
    $tagsByCategory[$tag->category_id][] = $tag;
}
?>

<section class="mb-4 pb-3 border-bottom">
    <h1 class="page-title mb-1">Správa kategórií a štítkov</h1>
    <p class="text-secondary mb-0">Štítky patria do kategórie. Pri úprave štítku môžete zmeniť aj jeho kategóriu.</p>
</section>

<nav class="mb-4" aria-label="Navigácia administrácie">
    <a class="btn btn-sm btn-outline-primary" href="#categoryManagement">Kategórie</a>
    <a class="btn btn-sm btn-primary" href="#tagManagement" aria-current="page">Štítky</a>
</nav>

<section class="card mb-4" id="categoryManagement" aria-labelledby="createCategoryTitle">
    <div class="card-body">
        <h2 class="h5" id="createCategoryTitle">Vytvoriť kategóriu</h2>
        <form method="post" action="<?= $link->url('admin.categoryCreate') ?>" class="row g-3 align-items-end">
            <div class="col-md-9">
                <label class="form-label" for="newCategoryName">Názov kategórie</label>
                <input class="form-control" id="newCategoryName" name="name" maxlength="64" required>
            </div>
            <div class="col-md-3 d-grid">
                <button class="btn btn-outline-primary" type="submit">Vytvoriť kategóriu</button>
            </div>
        </form>
    </div>
</section>

<section class="card mb-4" id="tagManagement" aria-labelledby="createTagTitle">
    <div class="card-body">
        <h2 class="h5" id="createTagTitle">Vytvoriť štítok</h2>
        <?php if ($categories === []) : ?>
            <p class="mb-0">Najprv vytvorte kategóriu, do ktorej bude štítok patriť.</p>
        <?php else : ?>
            <form method="post" action="<?= $link->url('admin.tagCreate') ?>" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label" for="newTagName">Názov štítku</label>
                    <input class="form-control" id="newTagName" name="name" maxlength="64" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="newTagCategory">Kategória</label>
                    <select class="form-select" id="newTagCategory" name="category_id" required>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category->id ?>"><?= $escape($category->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">Vytvoriť</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<section aria-labelledby="categoriesTitle">
    <h2 class="h4 mb-3" id="categoriesTitle">Kategórie a ich štítky</h2>
    <?php if ($categories === []) : ?>
        <p>Zatiaľ nie sú vytvorené žiadne kategórie.</p>
    <?php else : ?>
        <div class="row g-3">
            <?php foreach ($categories as $category) : ?>
                <?php $categoryTags = $tagsByCategory[$category->id] ?? []; ?>
                <div class="col-12 col-lg-6">
                    <section class="card h-100" aria-labelledby="category-<?= $category->id ?>">
                        <div class="card-header d-flex justify-content-between align-items-center gap-2">
                            <h3 class="h5 mb-0" id="category-<?= $category->id ?>">
                                <?= $escape($category->name) ?>
                            </h3>
                            <span class="badge text-bg-secondary"><?= count($categoryTags) ?> štítkov</span>
                        </div>
                        <div class="card-body">
                            <details class="mb-3">
                                <summary class="btn btn-sm btn-outline-secondary">Upraviť kategóriu</summary>
                                <form method="post" action="<?= $link->url('admin.categoryUpdate') ?>" class="border rounded p-3 mt-2">
                                    <input type="hidden" name="id" value="<?= $category->id ?>">
                                    <label class="form-label" for="category-name-<?= $category->id ?>">Názov kategórie</label>
                                    <input class="form-control mb-2" id="category-name-<?= $category->id ?>"
                                           name="name" value="<?= $escape($category->name) ?>"
                                           maxlength="64" required>
                                    <button class="btn btn-sm btn-primary" type="submit">Uložiť zmeny</button>
                                </form>
                            </details>
                            <?php if ($categoryTags === []) : ?>
                                <form method="post" action="<?= $link->url('admin.categoryDelete') ?>" class="mb-3">
                                    <input type="hidden" name="id" value="<?= $category->id ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Zmazať kategóriu</button>
                                </form>
                            <?php else : ?>
                                <p class="small text-secondary mb-3">Kategóriu možno zmazať až po odstránení jej štítkov.</p>
                            <?php endif; ?>
                            <?php if ($categoryTags === []) : ?>
                                <p class="text-secondary mb-0">Kategória zatiaľ nemá štítky.</p>
                            <?php else : ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($categoryTags as $tag) : ?>
                                        <li class="list-group-item px-0">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                <span><?= $escape($tag->name) ?></span>
                                                <details>
                                                    <summary class="btn btn-sm btn-outline-secondary">Upraviť / zmazať</summary>
                                                    <div class="border rounded p-3 mt-2">
                                                        <form method="post" action="<?= $link->url('admin.tagUpdate') ?>" class="mb-3">
                                                            <input type="hidden" name="id" value="<?= $tag->id ?>">
                                                            <div class="mb-2">
                                                                <label class="form-label" for="tag-name-<?= $tag->id ?>">Názov</label>
                                                                <input class="form-control" id="tag-name-<?= $tag->id ?>"
                                                                       name="name" value="<?= $escape($tag->name) ?>"
                                                                       maxlength="64" required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label" for="tag-category-<?= $tag->id ?>">Kategória</label>
                                                                <select class="form-select" id="tag-category-<?= $tag->id ?>"
                                                                        name="category_id" required>
                                                                    <?php foreach ($categories as $optionCategory) : ?>
                                                                        <option value="<?= $optionCategory->id ?>"
                                                                            <?= $optionCategory->id === $tag->category_id ? 'selected' : '' ?>>
                                                                            <?= $escape($optionCategory->name) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <button class="btn btn-sm btn-primary" type="submit">Uložiť zmeny</button>
                                                        </form>
                                                        <form method="post" action="<?= $link->url('admin.tagDelete') ?>">
                                                            <input type="hidden" name="id" value="<?= $tag->id ?>">
                                                            <p class="small text-secondary">Zmazaním štítku sa odstránia aj jeho priradenia k projektom.</p>
                                                            <button class="btn btn-sm btn-outline-danger" type="submit">Zmazať štítok</button>
                                                        </form>
                                                    </div>
                                                </details>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

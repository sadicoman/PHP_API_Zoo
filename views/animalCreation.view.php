<?php ob_start(); ?>
<form method="POST" action="<?= URL ?>back/animals/creationValidation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="animal_nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="animal_nom" name="animal_nom">
    </div>
    <div class="mb-3">
        <label for="animal_description" class="form-label">Description</label>
        <textarea class="form-control" id="animal_description" name="animal_description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image :</label>
        <div class="input-group">
            <input type="file" class="form-control" id="image" name="image">
        </div>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Familles :</label>
        <select class="form-select" name="famille">
            <?php foreach ($familles as $famille) : ?>
                <option value="<?= $famille['famille_id'] ?>"><?= $famille['famille_id'] ?> - <?= $famille['famille_libelle'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <?php foreach ($continents as $continent) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="continent-<?= $continent['continent_id'] ?>">
                <label class="form-check-label" for="inlineCheckbox1"><?= $continent['continent_libelle'] ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>
<?php
$content = ob_get_clean();
$titre = "Page de creation d'un animal";
require "views/commons/template.php";

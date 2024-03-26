<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php require_once "views/commons/menu.php"; ?>
    <main class="container">
        <h1 class="rounded border border-dark m-2 p-2 text-center text-white bg-info"><?= $titre ?></h1>
        <?php if (!empty($_SESSION['alert'])) : ?>
            <div class="alert <?= $_SESSION['alert']['type'] ?>" role="alert">
                <?= $_SESSION['alert']['message'] ?>
            </div>
        <?php
            unset($_SESSION['alert']);
        endif;
        ?>
        <?= $content ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
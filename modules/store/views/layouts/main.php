<?php

use app\assets\AppAsset;
use app\assets\TelegramWebAppAsset;
use yii\bootstrap5\Html;
use yii\web\View;

/** @var yii\web\View $this */
/** @var string       $content */

AppAsset::register($this);
$this->registerAssetBundle(TelegramWebAppAsset::class, View::POS_HEAD);
$this->registerJsFile('@web/js/store/main.js', ['depends' => [TelegramWebAppAsset::class], 'position' => View::POS_HEAD]);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
    <style>
        body {
            background-color: var(--tg-theme-bg-color);
            color: var(--tg-theme-text-color);
        }
        button {
            background-color: var(--tg-theme-button-color);
            color: var(--tg-theme-button-text-color);
            border: 0;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>

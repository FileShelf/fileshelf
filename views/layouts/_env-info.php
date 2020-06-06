<?php

use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap4\Html;

if (YII_DEBUG) {

    if (YII_ENV_STAGE) {
        $envColor = 'warning';
    } else if (YII_ENV_PROD) {
        $envColor = 'danger';
    } else {
        $envColor = 'success';
    }

    $envIcon = FAS::i('server')->fixedWidth()->addCssClass('mr-1');
    $screenIcon = FAS::i('desktop')->fixedWidth()->addCssClass('mr-1');

    echo Html::beginTag('div', ['class' => 'position-fixed bg-dark p-2', 'style' => 'bottom:0;left:0;opacity:0.5;z-index:9999;', 'aria-hidden' => 'true']);

    echo Html::tag('div', $envIcon . YII_ENV, ['class' => 'btn btn-sm btn-' . $envColor . ' d-inline-block text-uppercase mr-1']);

    echo Html::tag('div', $screenIcon . 'XS', ['class' => 'btn btn-sm btn-info d-inline-block d-sm-none']);
    echo Html::tag('div', $screenIcon . 'SM', ['class' => 'btn btn-sm btn-info d-none d-sm-inline-block d-md-none']);
    echo Html::tag('div', $screenIcon . 'MD', ['class' => 'btn btn-sm btn-info d-none d-md-inline-block d-lg-none']);
    echo Html::tag('div', $screenIcon . 'LG', ['class' => 'btn btn-sm btn-info d-none d-lg-inline-block d-xl-none']);
    echo Html::tag('div', $screenIcon . 'XL', ['class' => 'btn btn-sm btn-info d-none d-xl-inline-block']);

    echo Html::endTag('div');
}

<?php

/* @var $this app\components\View */

use rmrevin\yii\fontawesome\FAS;

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-3">

            <div class="card mb-3">
                <img src="https://picsum.photos/200/300" class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="card-title">
                        Some important document<br>
                        <small class="text-muted"><?= FAS::i(FAS::_FILE_PDF)->fixedWidth() ?>&nbsp;some-important-document.pdf</small>
                    </h6>
                    <p class="card-text">123kB</p>
                    <p class="card-text"><small class="text-muted">Last updated: 3 mins ago</small></p>
                </div>
            </div>

        </div>
    </div>

</div>

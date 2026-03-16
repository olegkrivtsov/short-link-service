<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;
use Da\QrCode\QrCode;

$this->title = 'Сервис коротких ссылок';

$qrCode = (new QrCode($shortLink->absoluteShortLink))
    ->setSize(250)
    ->setMargin(5)
    ->setBackgroundColor(51, 153, 255);

?>
<div class="site-index d-flex flex-column justify-content-center">

    <?php Pjax::begin(['id' => 'pjax', 'timeout' => 0, 'enablePushState' => false]); ?>
    
    <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

            <?php if (empty($shortLink->short_link)): ?>

                <p class="text-center text-body-secondary mb-4">
                    Для генерации короткой ссылки введите URL страницы
                </p>

                <div class="card border-0 bg-body p-4">

                    <?php $form = ActiveForm::begin(['id' => 'short-link-form']); ?>

                    <div class="d-flex align-items-center gap-3 flex-wrap">

                    <?= $form->field($shortLink, 'url', [
                        'inputOptions' => [
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'URL',
                            'autofocus' => true,
                        ],
                        'options' => ['class' => 'input-group has-validation mb-3'],
                    ])->label(false) ?>

                    <?= Html::submitButton(
                        'OK',
                        [
                            'class' => 'btn btn-primary px-4 ms-auto',
                            'name' => 'contact-button',
                        ],
                    ) ?>

                    </div>
                    
                    <?php ActiveForm::end(); ?>
                <?php else: ?>

                    <p class="text-center text-body-secondary mb-4">
                        Отсканируйте QR-код для перехода по короткой ссылке
                    </p>

                    <img class="d-block mx-auto" src="<?= $qrCode->writeDataUri() ?>">
                    
                <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <?php Pjax::end(); ?>
</div>

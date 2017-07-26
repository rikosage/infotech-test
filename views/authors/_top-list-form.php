<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin([
    'action' => '/authors/top-list',
    'options' => [
        'class' => "form-inline",
    ],
]); ?>

<div class="row">
    <div class="form-group col-lg-3">
    <?= $form->field($model, 'year')->textInput([
        'class' => "form-control",
        'placeholder' => $model->getAttributeLabel("year"),
    ])->label(false) ?>
    </div>

    <?= Html::submitButton("Отправить", ['class' => 'btn btn-primary']); ?>
</div>


<?php ActiveForm::end(); ?>

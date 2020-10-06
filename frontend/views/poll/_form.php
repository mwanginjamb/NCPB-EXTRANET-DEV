<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Poll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form->field($model, 'resolution_id')->textInput() ?>

    <?= $form->field($model, 'poll_body')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'startdate')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'enddate')->textInput(['type' => 'date']) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

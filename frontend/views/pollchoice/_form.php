<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pollchoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pollchoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'choice_body')->textarea(['maxlength' => true,'rows' => 3,'required'=> true]) ?>

    <?= $form->field($model, 'poll_id')->hiddenInput()->label(false) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <?php $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
        $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
JS;

$this->registerJs($script);

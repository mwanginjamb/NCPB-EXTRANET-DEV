<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->session->hasFlash('error')){
    print '<div class="alert alert-danger">'.Yii::$app->session->getFlash('error').'</div>';
}
?>





            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>



                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>



                <?= $form->field($model, 'password')->passwordInput() ?>



                <?= $form->field($model, 'rememberMe')->checkbox() ?>


                <div style="color:#999;margin:1em 0; display: none">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <?php Html::a('signup', ['/site/signup'],['class' => 'btn btn-warning']) ?>
                </div>

    <?php ActiveForm::end(); ?>



<?php

$style = <<<CSS
            .login-page { 
          background: url("../../images/ncpb-header.jpg") no-repeat center top; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: 100%;
          
    }

CSS;

$this->registerCss($style);






    







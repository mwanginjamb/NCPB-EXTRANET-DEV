<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



                    <?php




                    $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">



                          




                                   

                                    <?= $form->field($model, 'Appraisal_Code')->hiddenInput(['readonly' => true])->label(false) ?>

                                    <?= $form->field($model, 'Employee_No')->hiddenInput()->label(false) ?>
                                   
                                    <?= (Yii::$app->session->get('Goal_Setting_Status') == 'Appraisee_Level')?$form->field($model, 'KRA_Code')->dropDownList($kra,['prompt' => 'Select ...']):'' ?>


                                     <?= $form->field($model, 'Objective')->textInput(['readonly' => true]) ?>

                                     <?= $form->field($model, 'Objective_Description')->textarea(['rows' => '3']) ?>
                                   

                                    <?= $form->field($model, 'Key')->hiddenInput()->label(false) ?>











                              



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
        $('form').on('submit', function(e){
            e.preventDefault();
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });


         /*Set KRA Code */

         $('#objective-kra_code').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#objective-key').val();
            const KRA_Code = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'objective/setfield?field=KRA_Code';
            $.post(url,{'KRA_Code': KRA_Code,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#objective-kra-key').val(msg.Key);
                    $('#objective-objective').val(msg.Objective);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-objective-kra_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-objective-kra_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        }); 
         
JS;

$this->registerJs($script);
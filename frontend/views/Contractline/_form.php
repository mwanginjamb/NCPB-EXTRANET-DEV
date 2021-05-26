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





                       
                        <div class="col-md-6">
                                
                                
                                <?= $form->field($model, 'Key')->textInput(['readonly'=> true]) ?>
                                <?= $form->field($model, 'Deliverable_Code')->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'Description')->textarea(['rows' => 2, 'maxlength' => 250]) ?>
                                <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date']) ?>
                                <?= $form->field($model, 'Period')->textInput(['maxlength' => 4]) ?>
                                <?= $form->field($model, 'End_Date')->textInput(['type' => 'date','readonly' => true,'disabled' => true]) ?>
                                <?= $form->field($model, 'Contractor')->checkbox() ?>
                                
                               

                        </div>

                        <div class="col-md-6">
                                <?= $form->field($model, 'Vendor_No')->dropDownList(['readonly' => true]); ?>
                                <?= $form->field($model, 'Vendor_Name')->textInput(['readonly'=> true,'disabled' => true]) ?>
                                
                                <?= $form->field($model, 'Amount')->textInput(['type' => 'number']) ?>
                                <?= $form->field($model, 'Invoiced')->checkbox(['name' => 'Contractor','checked' => $model->Contractor],[]) ?>
                                <?= $form->field($model, 'Invoice_No')->textInput(['maxlength' => 30]) ?>
                                <?= $form->field($model, 'Closed')->checkbox() ?>
                                     
                        </div>

                </div>

                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id'=>'submit']) ?>
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
            disableSubmit();
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });

        
        
         /*Set Start Date*/
         
         $('#contractline-start_date').on('change', function(e){
            e.preventDefault();


                  
            const Key = $('#contractline-key').val();
            const Start_Date = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Start_Date';
            $.post(url,{'Start_Date': Start_Date,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contractline-key').val(msg.Key);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contractline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contractline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        }); 


        /*Set Period */
         
         $('#contractline-period').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contractline-key').val();
            const Period = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Period';
            $.post(url,{'Period': Period,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contractline-key').val(msg.Key);
                    $('#contractline-end_date').val(msg.End_Date);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contractline-period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contractline-period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        }); 
         
        
         
         function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
JS;

$this->registerJs($script);

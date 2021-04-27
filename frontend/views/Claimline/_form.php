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







                        <div class=" row col-md-6">
                                <?= $form->field($model, 'Claim_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                               
                                <?= $form->field($model, 'Travel_From')->dropDownList($towns,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Claim_Type')->dropDownList($claimtype,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Date')->textInput(['type' => 'date']) ?>
                                <?= $form->field($model, 'Distance')->textInput(['maxlength'=> 4,'type' => 'number']) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->dropDownList( $functions,['prompt'=> 'select ...']) ?>
                                <?= $form->field($model, 'Reason_For_Claim')->textarea(['maxlength'=> 250,'type' => 'number']) ?>

                        </div>



                            <div class="col-md-6">
                               
                               
                                <?= $form->field($model, 'Travel_To')->dropDownList($towns,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Description')->textInput(['readonly'=> true,'disabled' => true]) ?>
                                <?= $form->field($model, 'Rate')->textInput(['readonly'=> true,'disabled' => true]) ?>
                                <?= $form->field($model, 'Total_Amount')->textInput(['readonly'=> true,'disabled' => true]) ?>
                                <?= $form->field($model, 'Days')->textInput(['type' => 'number']) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->dropDownList($budgetCenters, ['prompt'=> 'Select ...']) ?>
                                <?= $form->field($model, 'Nights_Spent')->textInput(['type' => 'number']) ?>
                                
                                
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
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });

         $('#leaveline-leave_code').on('change', function(e){
            e.preventDefault();
                  
            let Leave_Code = e.target.value;
            let Application_No  = $('#leaveline-application_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'leaveline/setleavetype';
            $.post(url,{'Leave_Code': Leave_Code,'Application_No': Application_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                    $('#leaveline-line_no').val(msg.Line_No);
                    $('#leaveline-key').val(msg.Key);
                    $('#leaveline-leave_balance').val(msg.Leave_balance);
                  
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leaveline-leave_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestline-transaction_type');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                   
                    
                },'json');
        });
         
         $('#leaveline-start_date').on('blur', function(e){
            e.preventDefault();
                  
            const Line_No = $('#leaveline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'leaveline/setstartdate';
            $.post(url,{'Line_No': Line_No,'Start_Date': $(this).val()}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-leaveline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaveline-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    
                    $('#leaveline-line_no').val(msg.Line_No);
                    $('#leaveline-key').val(msg.Key);
                    $('#leaveline-leave_balance').val(msg.Leave_balance);
                    
                },'json');
        });
         
         
         /* Set Days */
         
         
         $('#leaveline-days').on('blur', function(e){
            e.preventDefault();
                  
            const Line_No = $('#leaveline-line_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'leaveline/setdays';
            $.post(url,{'Line_No': Line_No,'Days': $(this).val()}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-leaveline-days');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leaveline-days');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                    
                    $('#leaveline-line_no').val(msg.Line_No);
                    $('#leaveline-key').val(msg.Key);
                    $('#leaveline-leave_balance').val(msg.Leave_balance);
                    $('#leaveline-end_date').val(msg.End_Date);
                    $('#leaveline-holidays').val(msg.Holidays);
                    $('#leaveline-weekend_days').val(msg.Weekend_Days);
                    
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

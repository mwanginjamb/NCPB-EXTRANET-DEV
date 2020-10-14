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







                        <div class=" row col-md-12">



                            <div class="col-md-6">
                                <?= $form->field($model, 'Line_No')->textInput(['readonly' => true])->label() ?>
                                <?= $form->field($model, 'Imprest_No')->textInput(['readonly' => true,'disabled'=>true])->label() ?>
                                <?= $form->field($model, 'Key')->textInput(['readonly'=> true])->label() ?>

                                <?= $form->field($model, 'G_L_Account')->
                                dropDownList($glAccounts,['prompt' => 'Select Transaction Type ..',
                                    'required'=> true, 'required' => true]) ?>



                                <?= $form->field($model, 'Shortcut_Dimension_1_Code')->
                                dropDownList($functions,['prompt' => 'Select ..',
                                    'required'=> true, 'required' => true]) ?>

                                <?= $form->field($model, 'Shortcut_Dimension_2_Code')->
                                dropDownList($budgetCenters,['prompt' => 'Select ..',
                                    'required'=> true, 'required' => true]) ?>


                                <?= $form->field($model, 'Amount')->textInput(['type' => 'number','required' => true]) ?>

                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'Actual_to_Date')->textInput(['readonly' => true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Description')->textInput(['readonly'=> true, 'disabled'=>true])->label() ?>
                                <?= $form->field($model, 'Annual_Budget_Amount')->textInput(['readonly'=> true,'disabled'=>true])->label() ?>
                                <?= $form->field($model, 'Budget_To_Date')->textInput(['readonly'=> true,'disabled'=>true])->label() ?>
                                <?= $form->field($model, 'Commitments')->textInput(['readonly'=> true,'disabled'=>true])->label() ?>
                                <?= $form->field($model, 'Available_Budget')->textInput(['readonly'=> true,'disabled'=>true])->label() ?>

                            </div>



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

         $('#imprestline-g_l_account').on('change', function(e){
            e.preventDefault();
                  
            const G_L_Account = e.target.value;
            const Imprest_No = $('#imprestline-imprest_no').val();
            
            
            const url = $('input[name="absolute"]').val()+'imprestline/setgl';
            $.post(url,{'G_L_Account': G_L_Account,'Imprest_No': Imprest_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                    $('#imprestline-line_no').val(msg.Line_No);
                    $('#imprestline-key').val(msg.Key);
                    $('#imprestline-description').val(msg.Description);
                    $('#imprestline-annual_budget_amount').val(msg.Annual_Budget_Amount);
                    $('#imprestline-budget_to_date').val(msg.Budget_To_Date);
                    $('#imprestline-commitments').val(msg.Commitments);
                    $('#imprestline-available_budget').val(msg.Available_Budget);
                  
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestline-g_l_account');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestline-g_l_account');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }
                   
                    
                },'json');
        });
         
         // Set Budget Center
         
         $('#imprestline-shortcut_dimension_2_code').on('change', function(e){
            e.preventDefault();
                  
            const BudgetCenter = e.target.value;
            const Imprest_No = $('#imprestline-imprest_no').val();
            const Line_No = $('#imprestline-line_no').val();
            
            const url = $('input[name="absolute"]').val()+'imprestline/setbudgetcenter';
            $.post(url,{'Shortcut_Dimension_2_Code': BudgetCenter,'Imprest_No': Imprest_No, 'Line_No': Line_No }).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    
                    $('#imprestline-line_no').val(msg.Line_No);
                    $('#imprestline-key').val(msg.Key);
                    $('#imprestline-description').val(msg.Description);
                    $('#imprestline-annual_budget_amount').val(msg.Annual_Budget_Amount);
                    $('#imprestline-budget_to_date').val(msg.Budget_To_Date);
                    $('#imprestline-commitments').val(msg.Commitments);
                    $('#imprestline-available_budget').val(msg.Available_Budget);
                    $('#imprestline-actual_to_date').val(msg.Actual_To_Date);
                    
                    
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-imprestline-shortcut_dimension_2_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestline-shortcut_dimension_2_code');
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
        
        // $('#imprestline-g_l_account').select2();
JS;

$this->registerJs($script);

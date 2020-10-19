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
                                <?= $form->field($model, 'Line_No')->hiddenInput(['readonly' => true])->label(false) ?>
                                <?= $form->field($model, 'Requisition_No')->hiddenInput(['readonly' => true,'disabled'=>true])->label(false) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                                <?= $form->field($model, 'Expense_Date')->textInput(['type' => 'date']) ?>
                                <?= $form->field($model, 'Expense_Location')->
                                dropDownList($locations,['prompt' => 'Select location ..',
                                    'required'=> true, 'required' => true]) ?>

                                <?= $form->field($model, 'Description')->textarea(['rows' => '2','maxlength' => 200,'required' => true]) ?>

                                <?= $form->field($model, 'Account_Type')->
                                dropDownList(['G_L_Account' => 'G_L_Account','Bank_Account' => 'Bank_Account'],['prompt' => 'Select Account Type ..',
                                    'required'=> true, 'required' => true]) ?>



                            </div>

                            <div class="col-md-6">

                                <?= $form->field($model, 'Account_No')->
                                dropDownList($glAccounts,['prompt' => 'Select Account  ..',
                                    'required'=> true, 'required' => true]) ?>



                                <?= $form->field($model, 'Global_Dimension_1_Code')->
                                dropDownList($functions,['prompt' => 'Select ..',
                                    'required'=> true, 'required' => true]) ?>

                                <?= $form->field($model, 'Global_Dimension_2_Code')->
                                dropDownList($budgetCenters,['prompt' => 'Select ..',
                                    'required'=> true, 'required' => true]) ?>


                                <?= $form->field($model, 'Amount')->textInput(['type' => 'number','required' => true]) ?>

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

         $('#surrenderline-expense_date').on('change', function(e){
            e.preventDefault();
                  
            const Expense_Date = e.target.value;
            const Requisition_No = $('#surrenderline-requisition_no').val();          
            
            const url = $('input[name="absolute"]').val()+'surrenderline/set-expensedate';
            $.post(url,{'Expense_Date': Expense_Date, 'Requisition_No': Requisition_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                    $('#surrenderline-line_no').val(msg.Line_No);
                    $('#surrenderline-key').val(msg.Key);
                   
                  
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-surrenderline-expense_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-surrenderline-expense_date');
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

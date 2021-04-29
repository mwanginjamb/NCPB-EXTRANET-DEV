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





                        <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>
                        <div class="col-md-6">
                                
                                
                               
                                <?= $form->field($model, 'Expense_Date')->textInput(['type' => 'date']) ?>
                                 <?= $form->field($model, 'Return_Date')->textInput(['type' => 'date']) ?>
                                <?= $form->field($model, 'Travel_From')->dropDownList($towns,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Nights_Spent')->textInput(['type' => 'number','readonly' =>  true]) ?>
                                
                               

                        </div>

                        <div class="col-md-6">
                                <?= $form->field($model, 'Document_No')->textInput(['readonly' => true]); ?>
                                <?= $form->field($model, 'Total_Distance')->textInput(['maxlength'=> 4,'type' => 'number']) ?>
                                
                                <?= $form->field($model, 'Travel_To')->dropDownList($towns,['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Days_Spent')->textInput(['type' => 'number','readonly' => true]) ?>
                               
                                     
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

        // Set Expense date
         
         
         $('#safariline-expense_date').on('change', function(e){
            e.preventDefault();
                  
            const Expense_Date = e.target.value;
            const Key = $('#safariline-key').val();
           
            
            
            const url = $('input[name="absolute"]').val()+'safariline/setfield?field=Expense_Date';
            $.post(url,{'Expense_Date': Expense_Date,'Key': Key}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-safariline-expense_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-safariline-expense_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }

                    $('#safariline-expense_date').val(msg.Expense_Date);
                    $('#safariline-key').val(msg.Key);
                    
                   
                    
                },'json');
        });
         
         
         /* Set Return date */
         
         
         $('#safariline-return_date').on('change', function(e){
            e.preventDefault();
                  
            const Expense_Date = $('#safariline-expense_date').val();
            const Document_No = $('#safariline-document_no').val();
            const Key = $('#safariline-key').val();
            const Return_Date = e.target.value;
            
            
            const url = $('input[name="absolute"]').val()+'safariline/setfield?field=Return_Date';
            $.post(url,{'Return_Date': Return_Date,'Expense_Date': Expense_Date,'Document_No': Document_No,'Key': Key}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                   

                    $('#safariline-nights_spent').val(msg.Nights_Spent);
                    $('#safariline-days_spent').val(msg.Days_Spent);
                    $('#safariline-key').val(msg.Key);

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-safariline-return_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-safariline-return_date');
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

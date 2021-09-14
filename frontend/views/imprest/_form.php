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


if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
    print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-times"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}

?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to send imprest request for approval?',
                'params'=>[
                    'No'=> $model->Imprest_No,
                    'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                ],
                'method' => 'get',
        ],
            'title' => 'Submit Imprest Approval'

        ]):'' ?>


        <?= ($model->Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to cancel imprest approval request?',
            'params'=>[
                'No'=> $model->Imprest_No,
            ],
            'method' => 'get',
        ],
            'title' => 'Cancel Imprest Approval Request'

        ]):'' ?>
    </div>
</div>

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
                    <div class="row col-md-12">



                        <div class="col-md-6">
                            <?= $form->field($model, 'Key')->hiddenInput(['readonly' => true])->label(false) ?>
                            <?= $form->field($model, 'Imprest_No')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Source_Document')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= '<p><span>Payroll No</span> '.Html::a($model->Payroll_No,'#'); '</p>' ?>
                            <?= $form->field($model, 'Staff_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= '<p><span>Imprest Account</span> '.Html::a($model->Imprest_Account,'#'); '</p>'?>
                            <?= $form->field($model, 'Paying_Bank_Account')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Paying_Cashier')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= '<p><span>Paying Cashier</span> '.Html::a($model->Paying_Cashier,'#'); '</p>'?>
                            <?= $form->field($model, 'Paying_Budget_Center')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Requested_On')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'Travel_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= '<p><span>Imprest Amount</span> '.Html::a($model->Total_Imprest_Amount,'#'); '</p>'?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= '<p><span>Action ID</span> '.Html::a($model->Action_ID,'#'); '</p>'?>
                            <?= '<p><span>Approval_Levels</span> '.Html::a($model->Approval_Levels,'#'); '</p>'?>

                            <?= $form->field($model, 'Due_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Purpose')->textarea(['maxlength'=> 200, 'required' => true, 'rows' => 2]) ?>
                            <?= $form->field($model, 'Payment_Method')->dropDownList($paymentMethods, ['prompt' => 'Select Payment Method','required' => true]) ?>
                            <?= $form->field($model, 'Payment_Refrence')->textInput() ?>

                        </div>

                    </div>

                </div>

                <!--<div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>-->
                <?php ActiveForm::end(); ?>
            </div>
        </div><!--End Header Card-->


        <!---Lines Card -->

        <div class="card">
                <div class="card-header">
                    <div class="card-title">   <?= ($model->Status == 'New')?
                     Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['imprestline/create','Request_No'=>$model->Imprest_No],['class' => 'add-objective btn btn-outline-warning'])
                     : '' ?></div>
                </div>

                <div class="card-body">
                    <?php
                    if(is_array($model->getLines($model->Imprest_No))){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>G/L Account</b></td>
                                <td><b>Description</b></td>
                                <td><b>Function Code</b></td>
                                <td><b>Budget Center</b></td>
                                <td><b>Amount</b></td>
                                <td><b>Annual Budget Amount</b></td>
                                <td><b>Actual to Date</b></td>
                                <td><b>Budget To Date</b></td>
                                <td><b>Commitments</b></td>
                                <td><b>Available Budget</b></td>
                                <td><b>Actions</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            
                            foreach($model->getLines($model->Imprest_No) as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['imprestline/update','Line_No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['imprestline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->G_L_Account)?$obj->G_L_Account:'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Shortcut_Dimension_1_Code)?$obj->Shortcut_Dimension_1_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Shortcut_Dimension_2_Code)?$obj->Shortcut_Dimension_2_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Annual_Budget_Amount)?$obj->Annual_Budget_Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Actual_to_Date)?$obj->Actual_to_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Budget_To_Date)?$obj->Budget_To_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Commitments)?$obj->Commitments:'Not Set' ?></td>
                                    <td><?= !empty($obj->Available_Budget)?$obj->Available_Budget:'Not Set' ?></td>

                                    <td><?= $updateLink.'|'.$deleteLink ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

        <!--End Card Lines -->









    </div>
</div>



    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Imprest Management</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>
<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
       /* $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });*/


         //Add a Line
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });

      /*Deleting Records*/
     
      $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $(this).closest('tr').remove(); // REMOVE PARENT ELEM
         $.get(url).done(function(msg){
             if(msg.status !== TRUE){
                 $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
             }             
         },'json');
          
     });   
     
     
    // Update Purpose
     
    $('#imprestcard-purpose').change((e) => {
        updateField('Imprestcard','Purpose', e);
    });

    // Update Payment Method

    $('#imprestcard-payment_method').change((e) => {
        updateField('Imprestcard','Payment_Method', e);
    });


    // Update Payment Reference
     
    $('#imprestcard-payment_refrence').change((e) => {
        updateField('Imprestcard','Payment_Refrence', e);
    });
     
    function updateField(entity,fieldName, ev) {
                const model = entity.toLowerCase();
                const field = fieldName.toLowerCase();
                const formField = '.field-'+model+'-'+fieldName.toLowerCase();
                const keyField ='#'+model+'-key'; 
                const targetField = '#'+model+'-'.field;
                const tget = '#'+model+'-'+field;


                const fieldValue = ev.target.value;
                const Key = $(keyField).val();
                //alert(Key);
                if(Key.length){
                    const url = $('input[name=url]').val()+'imprest'+'/setfield?field='+fieldName;
                    $.post(url,{ fieldValue:fieldValue,'Key': Key}).done(function(msg){
                        
                            // Populate relevant Fields
                            
                            
                            // console.log(msg[fieldName]);
                            // console.log(fieldName);
                           
                            $(keyField).val(msg.Key);
                            $(targetField).val(msg[fieldName]);

                           
                            if((typeof msg) === 'string') { // A string is an error
                                console.log(formField);
                                const parent = document.querySelector(formField);
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                                
                            }else{ // An object represents correct details

                                const parent = document.querySelector(formField);
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = '';
                                
                            }   
                        },'json');
                }
            
     }
     
     
     /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
     
     
JS;

$this->registerJs($script);

<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Imprest - '.$model->Imprest_No;
$this->params['breadcrumbs'][] = ['label' => 'imprests', 'url' => ['surrender']];
$this->params['breadcrumbs'][] = ['label' => 'Imprest surrender Card', 'url' => ['view','No'=> $model->Imprest_No]];
/** Status Sessions */

?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Surrender_Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
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


        <?= ($model->Surrender_Status == 'Pending_Approval')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to cancel imprest surrender approval request?',
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
            <div class="card-success">
                <div class="card-header">
                    <h3>Imprest Surrender Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Imprest No : <?= $model->Imprest_No?></h3>



                    <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
                    ?>
                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Source_Document')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Surrender_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= '<p><span>Payroll No</span> '.Html::a($model->Payroll_No,'#'); '</p>' ?>
                                <?= $form->field($model, 'Staff_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Imprest_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= '<p><span>Imprest Account</span> '.Html::a($model->Imprest_Account,'#'); '</p>'?>
                                <?= $form->field($model, 'Paying_Bank_Account')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= '<p><span>Paying Cashier</span> '.Html::a($model->Paying_Cashier,'#'); '</p>'?>






                                <p class="parent"><span>+</span>




                                </p>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'Paying_Budget_Center')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Requested_On')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Travel_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= '<p><span>Imprest Amount</span> '.Html::a($model->Total_Imprest_Amount,'#'); '</p>'?>
                                <?= '<p><span>Surrender Amount</span> '.Html::a($model->Surrender_Amount,'#'); '</p>'?>
                                <?= $form->field($model, 'Surrender_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <?= '<p><span>Action ID</span> '.Html::a($model->Surrender_Ation_ID,'#'); '</p>'?>
                                <?= '<p><span>Approval_Levels</span> '.Html::a($model->Surrender_Approval_Levels,'#'); '</p>'?>




                                <p class="parent"><span>+</span>



                                </p>



                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->



            <!--MR. SHIT-->

            <div class="card card-success collapsed-card">
                <div class="card-header">
                    <div class="card-title">MR. Surrender</div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Surrender_Posting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'MR_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        </div>
                    </div>
                </div>
            </div>


            <!--Lines card -->


            <div class="card card-success collapsed-card">
                <div class="card-header">
                    <div class="card-title">Surrender Lines  <?= Html::a('<i class="fa fa-plus-square"></i> New Imprest Line',['surrenderline/create','Request_No'=>$model->Imprest_No],['class' => 'add-objective btn btn-outline-info']) ?></div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <?php
                    if(is_array($model->getLines($model->Imprest_No))){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Expense Date</b></td>
                                <td><b>Expense Location</b></td>
                                <td><b>Description</b></td>
                                <td><b>Currency</b></td>
                                <td><b>Amount</b></td>
                                <td><b>Account Name</b></td>
                                <td><b>Available Budget</b></td>
                                <td><b>Function Code </b></td>
                                <td><b>Budget Center Code</b></td>
                                <td><b>Actions</b></td>



                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->getLines($model->Imprest_No) as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['surrenderline/update','Line_No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['surrenderline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Expense_Date)?$obj->Expense_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Expense_Location)?$model->getLocation($obj->Expense_Location):'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Currency)?$obj->Currency:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Account_Name)?$obj->Account_Name:'Not Set' ?></td>
                                    <td><?= !empty($obj->Available_Budget)?$obj->Available_Budget:'Not Set' ?></td>
                                    <td><?= !empty($obj->Global_Dimension_1_Code)?$model->getFunction($obj->Global_Dimension_1_Code):'Not Set' ?></td>
                                    <td><?= !empty($obj->Global_Dimension_2_Code)?$model->getBudgetCenter($obj->Global_Dimension_2_Code):'Not Set' ?></td>

                                    <td><?= $updateLink.'|'.$deleteLink ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <!--objectives card -->








        </>
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


<?php

$script = <<<JS

    $(function(){
      
        
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
      
    
   
        
        
      //Add a training plan
    
     $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
    $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/

         //Change Action taken

         $('select#probation-action_taken').on('change',(e) => {

            const key = $('input[id=Key]').val();
            const Employee_No = $('input[id=Employee_No]').val();
            const Appraisal_No = $('input[id=Appraisal_No]').val();
            const Action_Taken = $('#probation-action_taken option:selected').val();
           
              

            /* var data = {
                "Action_Taken": Action_Taken,
                "Appraisal_No": Appraisal_No,
                "Employee_No": Employee_No,
                "Key": key

             } 
            */
            $.get('./takeaction', {"Key":key,"Appraisal_No":Appraisal_No, "Action_Taken": Action_Taken,"Employee_No": Employee_No}).done(function(msg){
                 $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
                });


            });
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    }
    
    /* Table Media Queries */
    
     @media (max-width: 500px) {
          table td:nth-child(2),td:nth-child(3),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(2),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
CSS;

$this->registerCss($style);

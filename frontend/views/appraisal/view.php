<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Performance Appraisal - '.$model->Appraisal_Code;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view','No'=> $model->Appraisal_Code]];
/** Status Sessions */


?>

<div class="row">
    <div class="col-md-12">
        <div class="card-warning">
            <div class="card-header">
                <h3>Performance Appraisal Card </h3>
            </div>
            
            <div class="card-body info-box">

                <div class="row">


                    <div class="col-md-4">

                        <?= Html::a('<i class="fas fa-forward"></i> submit',['submit'],['class' => 'btn btn-app submitforapproval','data' => [
                                'confirm' => 'Are you sure you want to submit this appraisal?',
                                'method' => 'post',
                            ],
                            'title' => 'Submit Goals for Approval'

                        ]) ?>
                    </div>





                </div>

            </div>
           
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">

                <h3 class="card-title">Appraisal : <?= $model->Appraisal_Code ?></h3>

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

                           <?= $form->field($model, 'Appraisal_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>
                               <?= $form->field($model, 'Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Calender_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Appraisal_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           </p>


                       </div>
                       <div class="col-md-6">

                           <?= $form->field($model, 'Appraisal_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Total_KPI_x0027_s')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           <?= $form->field($model, 'Deparrtment_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           <p class="parent"><span>+</span>

                               <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                           </p>



                       </div>
                   </div>
               </div>



               <?php ActiveForm::end(); ?>



            </div>
        </div><!--end details card-->

        <!--KRA CARD -->
        <div class="card-success">
            <div class="card-header">
                <h4 class="card-title">Employee Appraisal KRA</h4>
            </div>
            <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><?= Html::a('<i class="fa fa-plus"></i>',['appraisalkra/create','Appraisal_Code' => $model->Appraisal_Code,'Calender_Code' => $model->Calender_Code ],['class' => 'add-kra btn btn-sm btn-success', 'title' => 'Add Key Result Area'])?></td>
                                <th>KRA CODE.</th>
                                <th>Objective</th>
                                <th>Objective_Description</th>
                                <th>Total KPIs</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach($model->Employee_Appraisal_KRAs as $k){ ?>

                                <tr class="parent">

                                    <td><span>+</span></td>
                                    <td><?= !empty($k->KRA_Code)?$k->KRA_Code:'' ?></td>
                                    <td><?= !empty($k->Objective)?$k->Objective: 'Not Set' ?></td>
                                    <td><?= !empty($k->Objective_Description)?$k->Objective_Description: 'Not Set' ?></td>
                                    <td><?= !empty($k->Total_KPI_x0027_s)?$k->Total_KPI_x0027_s: 'Not Set' ?></td>
                                    <td><?= Html::a('Remove',['appraisalkra/delete','Key'=> $k->Key],['class' => 'delete btn btn-outline-danger btn-xs'])?></td>
                                </tr>
                                <tr class="child">
                                    <td colspan="11" >
                                    <table class="table table-hover table-borderless table-info">
                                        <thead>
                                            <tr>
                                                <td><?= Html::a('<i class="fa fa-plus"></i>',['kpi/create','Appraisal_Code' => $model->Appraisal_Code,'KRA_Code' => $k->KRA_Code ],['class' => 'add-kra btn btn-sm btn-warning', 'title' => 'Add Key Performance Indicator'])?></td>
                                                <td colspan="10" align="center"><b>Employee KPIs</b></td>
                                            </tr>
                                            <tr >
                                                <th>Key Performance Indicator</th>
                                                <th>Activity</th>
                                                <th>Target</th>
                                                <th>Maximum Weight</th>
                                                <th>Target Achieved</th>
                                                <th>Self Assesment</th>
                                                <th>Self Comments</th>
                                                <th>Supervisor Comments</th>
                                                <th>Joint Assesment</th>
                                                <th>Weighted Rating</th>
                                                <th>Hr Comments</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!empty($k->KRA_Code)) {
                                            foreach ($model->getKPI($k->KRA_Code) as $kpi):
                                                if(!empty($kpi->KPI_Code)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= !empty($kpi->KPI_Code) ? $kpi->KPI_Code : 'Notr Set' ?></td>
                                                        <td><?= !empty($kpi->Activity) ? $kpi->Activity : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Target) ? $kpi->Target : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Maximum_Weight) ? $kpi->Maximum_Weight : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Target_Achieved) ? $kpi->Target_Achieved : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Self_Assesment) ? $kpi->Self_Assesment : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Self_Comments) ? $kpi->Self_Comments : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Supervisor_Comments) ? $kpi->Supervisor_Comments : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Joint_Assesment) ? $kpi->Joint_Assesment : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Weighted_Rating) ? $kpi->Weighted_Rating : 'Not Set' ?></td>
                                                        <td><?= !empty($kpi->Hr_Comments) ? $kpi->Hr_Comments : 'Not Set' ?></td>
                                                        <td><?= Html::a('<i class="fa fa-trash"></i>',['kpi/delete','Key'=> $k->Key],['class' => 'delete btn btn-outline-danger btn-xs'])?> </td>
                                                    </tr>
                                                    <?php
                                                }

                                            endforeach;
                                        }

                                    ?>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>



            </div>
        </div>

        <!--ENF KRA CARD -->







    </div>
</div>

<!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Performance Appraisal</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-outline-warning">Save changes</button>-->
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
         $.post(url).done(function(msg){
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });  
      
    
    /* KRAs*/
        $('.evalkra,.add-kra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
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
                  
         
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);


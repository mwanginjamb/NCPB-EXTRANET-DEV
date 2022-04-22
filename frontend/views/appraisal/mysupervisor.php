<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'] . ' Performance Appraisal';
$this->params['breadcrumbs'][] = ['label' => 'Appraisal List', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';
$url = \yii\helpers\Url::home(true);
?>


<?php
if (Yii::$app->session->hasFlash('success')) {
    print ' <div class="alert alert-success alert-dismissable">
                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
} else if (Yii::$app->session->hasFlash('error')) {
    print ' <div class="alert alert-danger alert-dismissable">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= \yii\helpers\Html::a('New', ['create'], ['class' => 'btn btn-info mx-1 py-2', 'data' => [
                    'confirm' => 'Are you sure you want to create a new Appraisal?',
                    'method' => 'get',
                ],]) ?>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Performance Appraisal List</h3>






            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive table-hover" id="table">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){
         /*Data Tables*/
         
       // $.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'appraisal/list-my-supervisor',
            paging: true,
            columns: [
                { title: 'No' ,data: 'Appraisal_No'},
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Employee Name' ,data: 'Employee_Name'},
                { title: 'Level_Grade' ,data: 'Level_Grade'},
                { title: 'Job Title' ,data: 'Job_Title'},
                { title: 'Appraisal Period' ,data: 'Appraisal_Period'},
                { title: 'Appraisal Start Date' ,data: 'Appraisal_Start_Date'},             
                { title: 'Appraisal End Date' ,data: 'Appraisal_End_Date'},
                { title: 'Action', data: 'Action' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Records to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
      // table.columns([8,9]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','tr', function(){
            
        });
    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

$this->registerCss($style);

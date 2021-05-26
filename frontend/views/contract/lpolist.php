<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'LPO List', 'url' => ['index']];

$url = \yii\helpers\Url::home(true);
?>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
        <?= \yii\helpers\Html::a('Add Vendor',['create'],['class' => 'btn btn-info push-right', 'data' => [
            'confirm' => 'Are you sure you want to create a new Contract Document ?',
            'method' => 'get',
        ],]) ?>
            </div>
        </div>
    </div>
</div> -->


<?php
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
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">LPO List</h3>






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

 <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Contract Management</h4>
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

    <input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){


       




         /*Data Tables*/
         
         //$.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'contract/lpo-list',
            paging: true,
            columns: [
                { title: 'No' ,data: 'No'},
                { title: 'Buy from Vendor Name' ,data: 'Buy_from_Vendor_Name'},
                { title: 'Vendor Authorization No' ,data: 'Vendor_Authorization_No'},
                { title: 'Pay to Name' ,data: 'Pay_to_Name'},
                { title: 'Posting Date' ,data: 'Posting_Date'},   
                { title: 'Location Code' ,data: 'Location_Code'},   
                { title: 'Purchaser Code' ,data: 'Purchaser_Code'},   
                { title: 'Document Date' ,data: 'Document_Date'},   
                { title: 'Payment Terms Code' ,data: 'Payment_Terms_Code'},   
                { title: 'Payment Discount Percent' ,data: 'Payment_Discount_Percent'},   
                { title: 'Payment Method Code' ,data: 'Payment_Method_Code'},   
                { title: 'View', data: 'view' },
               
            ] ,                              
           language: {
                "zeroRecords": "No LPOs to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
       table.columns([10,5,8]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','.delete', function(e){

            e.preventDefault();
            var secondThought = confirm("Are you sure you want to delete this record ?");
               if(!secondThought){//if user says no, kill code execution
                    return;
               }
           
             var url = $(this).attr('href');
             $.get(url).done(function(msg){
                 $('.modal').modal('show')
                        .find('.modal-body')
                        .html(msg.note);
             },'json');


        }); // End dt event delegation



          
    /*Handle modal dismissal event  */
    
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
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








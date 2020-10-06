<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - NCPB';
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';
?>



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
        <div class="card-success">
            <div class="card-header">
                <h3 class="card-title">Staff Contact List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered dt-responsive table-hover" id="staff">
                </table>
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
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Staff Contact</h4>
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
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#staff').DataTable({
           
            //serverSide: true,  
            ajax: './getstaff',
            paging: true,
            columns: [
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Full Name' ,data: 'Full_Name'},
                { title: 'User ID' ,data: 'User_ID'},
                { title: 'Company E-Mail' ,data: 'Company_E_Mail'},
                { title: 'Contract Type' ,data: 'Contract_Type'},    
                { title: 'View Contacts' ,data: 'view'},             
               
            ] ,                              
           language: {
                "zeroRecords": "No Employees to display"
            },
            
            order : [[ 2, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#staff').DataTable();
       //table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#staff').on('click','a.contact', function(e){
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
    
    });
        
JS;

$this->registerJs($script);







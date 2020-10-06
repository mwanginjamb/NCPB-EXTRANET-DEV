<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS -  NCPB: View Contact';
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
                <h3 class="card-title">Staff Contact Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Home Phone Number</th><td><?= $model->Home_Phone_Number ?></td>
                        </tr>

                        <tr>
                            <th>Cellular Phone Number</th><td><?= $model->Cellular_Phone_Number ?></td>
                        </tr>

                        <tr>
                            <th>Work Phone Number</th><td><?= $model->Work_Phone_Number ?></td>
                        </tr>

                        <tr>
                            <th>Alternative E-Mail</th><td><?= $model->E_Mail ?></td>
                        </tr>

                        <tr>
                            <th>Company E-Mail</th><td><?= $model->Company_E_Mail ?></td>
                        </tr>
                        <tr>
                            <th colspan="2">Address</th>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <address>
                                    Postal Address: <?= $model->Postal_Address.'<br>' ?> 
                                    Postal Code: <?= $model->Post_Code.'<br>' ?> 
                                    <?= $model->City.'<br>' ?> 
                                </address>
                            </td>
                        </tr>



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>









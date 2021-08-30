<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::$app->params['generalTitle'].' - LPO Details'
?>
<h2 class="title">Vendor : <?= !empty($model->Buy_from_Vendor_Name)?$model->Buy_from_Vendor_Name:'' ?></h2>

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
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">General Details</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Buy_from_Vendor_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Buy_from_Vendor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Buy_from_Address')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Buy_from_Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Buy_from_City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Posting_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Order_Date')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Document_Date')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Vendor_Order_No')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Vendor_Shipment_No')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Vendor_Invoice_No')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Order_Address_Code')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Purchaser_Code')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Responsibility_Center')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                           
                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Lines</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                       
                        <table class="table table-borderless table-stripped table-md table-responsive" style="max-width: 100%">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold">Type</td>
                                    <td class="font-weight-bold">Description</td>
                                    <td class="font-weight-bold">Location_Code</td>
                                    <td class="font-weight-bold">Quantity</td>
                                    <td class="font-weight-bold">UOM</td>
                                    <td class="font-weight-bold">Direct Unit Cost</td>
                                    <td class="font-weight-bold">Unit Cost LCY</td>
                                    <td class="font-weight-bold">Line Amount</td>
                                    <td class="font-weight-bold">Line Discount Percent</td>
                                    <td class="font-weight-bold">Line Discount Amount</td>
                                    <td class="font-weight-bold">Allow Invoice Disc</td>
                                    <td class="font-weight-bold">Inv Discount Amount</td>
                                    <td class="font-weight-bold">Quantity Received</td>
                                    <td class="font-weight-bold">Qty to Invoice</td>
                                    <td class="font-weight-bold">Quantity Invoiced</td>
                                    <td class="font-weight-bold">Allow Item Charge Assignment</td>
                                    <td class="font-weight-bold">Requested Receipt Date</td>
                                    <td class="font-weight-bold">Promised Receipt Date</td>
                                    <td class="font-weight-bold">Planned_Receipt_Date</td>
                                    <td class="font-weight-bold">Expected Receipt Date</td>
                                    <td class="font-weight-bold">Order Date</td>
                                    <td class="font-weight-bold">Finished</td>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                <?php if(property_exists($result->PurchLinesArchive,'Purchase_Order_Archive_Line') && is_array($result->PurchLinesArchive->Purchase_Order_Archive_Line)): ?>

                                    <?php foreach($result->PurchLinesArchive->Purchase_Order_Archive_Line as $obj): ?>

                                        <tr>
                                            <td><?= !empty($obj->Type)?$obj->Type:'' ?></td>
                                            <td><?= !empty($obj->Description)?$obj->Description:'' ?></td>
                                            <td><?= !empty($obj->Location_Code)?$obj->Location_Code:'' ?></td>
                                            <td><?= !empty($obj->Quantity)?$obj->Quantity:'' ?></td>
                                            <td><?= !empty($obj->Unit_of_Measure)?$obj->Unit_of_Measure:'' ?></td>
                                            <td><?= !empty($obj->Direct_Unit_Cost)?$obj->Direct_Unit_Cost:'' ?></td>
                                            <td><?= !empty($obj->Unit_Cost_LCY)?$obj->Unit_Cost_LCY:'' ?></td>
                                            <td><?= !empty($obj->Line_Amount)?$obj->Line_Amount:'' ?></td>
                                            <td><?= !empty($obj->Line_Discount_Percent)?$obj->Line_Discount_Percent:'' ?></td>
                                            <td><?= !empty($obj->Line_Discount_Amount)?$obj->Line_Discount_Amount:'' ?></td>
                                            <td><?= !empty($obj->Allow_Invoice_Disc)?$obj->Allow_Invoice_Disc:'' ?></td>
                                            <td><?= !empty($obj->Inv_Discount_Amount)?$obj->Inv_Discount_Amount:'' ?></td>
                                            <td><?= !empty($obj->Quantity_Received)?$obj->Quantity_Received:'' ?></td>
                                            <td><?= !empty($obj->Qty_to_Invoice)?$obj->Qty_to_Invoice:'' ?></td>
                                            <td><?= !empty($obj->Quantity_Invoiced)?$obj->Quantity_Invoiced:'' ?></td>
                                            <td><?= !empty($obj->Allow_Item_Charge_Assignment)?$obj->Allow_Item_Charge_Assignment:'' ?></td>
                                            <td><?= !empty($obj->Requested_Receipt_Date)?$obj->Requested_Receipt_Date:'' ?></td>
                                            <td><?= !empty($obj->Promised_Receipt_Date)?$obj->Promised_Receipt_Date:'' ?></td>
                                            <td><?= !empty($obj->Planned_Receipt_Date)?$obj->Planned_Receipt_Date:''  ?></td>
                                            <td><?= !empty($obj->Expected_Receipt_Date)?$obj->Expected_Receipt_Date:'' ?></td>
                                            <td><?= !empty($obj->Order_Date)?$obj->Order_Date:'' ?></td>
                                            <td><?= (!empty($obj->Finished) && $obj->Finished)?'Yes':'No' ?></td>
                                            
                                        </tr>


                                    <?php endforeach; ?>

                                <?php endif;?>
                            </tbody>
                        </table>
                       
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Invoicing</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            
                        <?= $form->field($model, 'Pay_to_Vendor_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Contact_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Address')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Address_2')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Pay_to_Contact')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                         
                        <?= $form->field($model, 'Shortcut_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Shortcut_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Payment_Terms_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Due_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Payment_Discount_Percent')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'Payment_Method_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                        <?= $form->field($model, 'On_Hold')->checkbox([$model->On_Hold, 'On_Hold']) ?>
                        <?= $form->field($model, 'Prices_Including_VAT')->checkbox([$model->Prices_Including_VAT, 'Prices_Including_VAT']) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>

       



        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">shipping</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Ship_to_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_Address')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_Address_2')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_Contact')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Location_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Inbound_Whse_Handling_Time')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Shipment_Method_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Lead_Time_Calculation')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Requested_Receipt_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Promised_Receipt_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Expected_Receipt_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Sell_to_Customer_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Ship_to_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Foreign Trade</h3>


                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>


            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Currency_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Transaction_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Transaction_Specification')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Transport_Method')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Entry_Point')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Area')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Version</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Version_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Archived_By')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_Archived')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           

                        </div>
                        <div class="col-md-6">
                           
                            <?= $form->field($model, 'Time_Archived')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Interaction_Exist')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            


                        </div>
                    </div>
                </div>

            </div>
        </div>

        

        <?php ActiveForm::end(); ?>
    </div>
</div>

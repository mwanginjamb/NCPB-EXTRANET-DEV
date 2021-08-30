<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace frontend\models;


use yii\base\Model;

class Purchaseorderarchive extends Model
{
    public $Key;
    public $No;
    public $Buy_from_Vendor_No;
    public $Buy_from_Contact_No;
    public $Buy_from_Vendor_Name;
    public $Buy_from_Address;
    public $Buy_from_Address_2;
    public $Buy_from_Post_Code;
    public $Buy_from_City;
    public $Buy_from_Contact;
    public $Posting_Date;
    public $Order_Date;
    public $Document_Date;
    public $Vendor_Order_No;
    public $Vendor_Shipment_No;
    public $Vendor_Invoice_No;
    public $Order_Address_Code;
    public $Purchaser_Code;
    public $Responsibility_Center;
    public $Status;
    public $Pay_to_Vendor_No;
    public $Pay_to_Contact_No;
    public $Pay_to_Name;
    public $Pay_to_Address;
    public $Pay_to_Address_2;
    public $Pay_to_Post_Code;
    public $Pay_to_City;
    public $Pay_to_Contact;
    public $Shortcut_Dimension_1_Code;
    public $Shortcut_Dimension_2_Code;
    public $Payment_Terms_Code;
    public $Due_Date;
    public $Payment_Discount_Percent;
    public $Payment_Method_Code;
    public $On_Hold;
    public $Prices_Including_VAT;
    public $Ship_to_Name;
    public $Ship_to_Address;
    public $Ship_to_Address_2;
    public $Ship_to_Post_Code;
    public $Ship_to_City;
    public $Ship_to_Contact;
    public $Location_Code;
    public $Inbound_Whse_Handling_Time;
    public $Shipment_Method_Code;
    public $Lead_Time_Calculation;
    public $Requested_Receipt_Date;
    public $Promised_Receipt_Date;
    public $Expected_Receipt_Date;
    public $Sell_to_Customer_No;
    public $Ship_to_Code;
    public $Currency_Code;
    public $Transaction_Type;
    public $Transaction_Specification;
    public $Transport_Method;
    public $Entry_Point;
    public $Area;
    public $Version_No;
    public $Archived_By;
    public $Date_Archived;
    public $Time_Archived;
    public $Interaction_Exist;
    public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }


}
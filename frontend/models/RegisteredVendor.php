<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace frontend\models;


use yii\base\Model;

class RegisteredVendor extends Model
{
    public $Key;
    public $No;
    public $Name;
    public $Blocked;
    public $Qualified;
    public $Last_Date_Modified;
    public $Balance_LCY;
    public $Balance_Due_LCY;
    public $Document_Sending_Profile;
    public $Search_Name;
    public $Purchaser_Code;
    public $Responsibility_Center;
    public $Vendor_Type;
    public $KRA_Pin_No;
    public $Address;
    public $Address_2;
    public $Post_Code;
    public $City;
    public $Country_Region_Code;
    public $ShowMap;
    public $Contract_Expiry_Date;
    public $Primary_Contact_No;
    public $Contact;
    public $Phone_No;
    public $E_Mail;
    public $Fax_No;
    public $Home_Page;
    public $Our_Account_No;
    public $Language_Code;
    public $VAT_Registration_No;
    public $GLN;
    public $Pay_to_Vendor_No;
    public $Invoice_Disc_Code;
    public $Prices_Including_VAT;
    public $Gen_Bus_Posting_Group;
    public $VAT_Bus_Posting_Group;
    public $Vendor_Posting_Group;
    public $Currency_Code;
    public $Application_Method;
    public $Payment_Terms_Code;
    public $Payment_Method_Code;
    public $Priority;
    public $Block_Payment_Tolerance;
    public $Preferred_Bank_Account_Code;
    public $Partner_Type;
    public $Cash_Flow_Payment_Terms_Code;
    public $Creditor_No;
    public $Location_Code;
    public $Shipment_Method_Code;
    public $Lead_Time_Calculation;
    public $Base_Calendar_Code;
    public $Customized_Calendar;
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
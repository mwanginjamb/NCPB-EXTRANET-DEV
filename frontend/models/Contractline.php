<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Contractline extends Model
{

public $Key;
public $Deliverable_Code;
public $Description;
public $Start_Date;
public $Period;
public $End_Date;
public $Contractor;
public $Vendor_No;
public $Vendor_Name;
public $Amount;
public $Invoiced;
public $Created_By;
public $Created_On;
public $Invoice_No;
public $Closed;
public $Type;
public $No;
public $Account_Name;
public $Quantity_Received;
public $Job_Card_Nos;
public $Code;
public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            
        ];
    }
}
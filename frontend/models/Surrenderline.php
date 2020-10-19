<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Surrenderline extends Model
{

public $Key;
public $Line_No;
public $Expense_Date;
public $Requisition_No;
public $Expense_Location;
public $Description;
public $Description_2;
public $Currency;
public $Amount;
public $Amount_LCY;
public $Account_Type;
public $Account_No;
public $Account_Name;
public $Available_Budget;
public $Item_No;
public $Quantity;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $ShortcutDimCode_x005B_3_x005D_;
public $ShortcutDimCode_x005B_4_x005D_;
public $ShortcutDimCode_x005B_5_x005D_;
public $ShortcutDimCode_x005B_6_x005D_;
public $ShortcutDimCode_x005B_7_x005D_;
public $ShortcutDimCode_x005B_8_x005D_;
public $isNewRecord;

    public function rules()
    {
        return [
            [['Description','Expense_Date','Account_No','Amount'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Function Code',
            'Global_Dimension_2_Code' => 'Budget Center Code',
        ];
    }
}
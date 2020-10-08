<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Imprestline extends Model
{

public $Key;
public $G_L_Account;
public $Description;
public $Shortcut_Dimension_1_Code;
public $Shortcut_Dimension_2_Code;
public $Amount;
public $Annual_Budget_Amount;
public $Actual_to_Date;
public $Budget_To_Date;
public $Commitments;
public $Available_Budget;
public $ShortcutDimCode_x005B_3_x005D_;
public $ShortcutDimCode_x005B_4_x005D_;
public $ShortcutDimCode_x005B_5_x005D_;
public $ShortcutDimCode_x005B_6_x005D_;
public $ShortcutDimCode_x005B_7_x005D_;
public $ShortcutDimCode_x005B_8_x005D_;
public $Imprest_No;
public $Line_No;
public $isNewRecord;

    public function rules()
    {
        return [
            [['Transaction_Type', 'Description', 'Amount'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Shortcut_Dimension_1_Code' => 'Function Code',
            'Shortcut_Dimension_2_Code' => 'Budget Center Code',
            'Description' => 'G/L Account Description'
        ];
    }
}
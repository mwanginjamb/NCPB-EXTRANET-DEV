<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Claimline extends Model
{

public $Key;
public $Travel_From;
public $Travel_To;
public $Claim_Type;
public $Description;
public $Date;
public $Distance;
public $Days;
public $Nights_Spent;
public $Reason_For_Claim;
public $Rate;
public $Total_Amount;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $ShortcutDimCode_x005B_3_x005D_;
public $ShortcutDimCode_x005B_4_x005D_;
public $ShortcutDimCode_x005B_5_x005D_;
public $ShortcutDimCode_x005B_6_x005D_;
public $ShortcutDimCode_x005B_7_x005D_;
public $ShortcutDimCode_x005B_8_x005D_;
public $Budgeted_Amount;
public $Commitments;
public $Available_Amount;
public $GL_Budget;
public $Applys_On;
public $Claim_No;
public $isNewRecord;

    public function rules()
    {
        return [

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
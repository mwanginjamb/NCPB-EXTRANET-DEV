<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;


class Claim extends Model
{

public $Key;
public $Claim_No;
public $Payroll_No;
public $Safari_No;
public $Full_Name;
public $Imprest_Account;
public $Total_Claim;
public $Action_ID;
public $Approvals;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Source_Document_Type;
public $Created_By;
public $Created_On;
public $Payment_Voucher_No;
public $Document_Status;
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

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['MileageLines'];
        $filter = [
            'Claim_No' => $this->Claim_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;


    }



}
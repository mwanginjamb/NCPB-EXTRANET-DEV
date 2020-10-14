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


class Surrendercard extends Model
{

public $Key;
public $Source_Document;
public $Surrender_No;
public $Payroll_No;
public $Staff_Name;
public $Imprest_No;
public $Imprest_Account;
public $Paying_Bank_Account;
public $Paying_Cashier;
public $Paying_Budget_Center;
public $Requested_On;
public $Travel_Date;
public $Total_Imprest_Amount;
public $Surrender_Amount;
public $Surrender_Status;
public $Surrender_Ation_ID;
public $Surrender_Approval_Levels;
public $Surrender_Posting_Date;
public $MR_No;
public $Created_By;
public $Created_On;
public $Surrender_Created_On;
public $Surrender_Created_By;
public $Surrender_Poted_On;
public $Surrender_Posted_By;
public $isNewRecord;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

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

    public function getLines($imprestNo){
        $service = Yii::$app->params['ServiceName']['PostedImprest'];
        $filter = [
            'Requisition_No' => $imprestNo,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;


    }



}
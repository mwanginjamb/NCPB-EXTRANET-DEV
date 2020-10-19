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
        $service = Yii::$app->params['ServiceName']['SurrenderLines'];
        $filter = [
            'Requisition_No' => $imprestNo,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    public function getLocation($Code)
    {
        $service = Yii::$app->params['ServiceName']['PostCodes'];
        $filter = [
            'City' => '<> " "',
            'Code' => $Code
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result[0]->City;
    }

    public function getBudgetCenter($Code)
    {
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = [
            'Name' => '<> " "',
            'Global_Dimension_No' => 2,
            'Code' => $Code
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result[0]->Name;
    }

    public function getFunction($Code)
    {
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = [
            'Name' => '<> " "',
            'Global_Dimension_No' => 1,
            'Code' => $Code
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);
        return $result[0]->Name;
    }








}
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


class Imprestcard extends Model
{

public $Key;
public $Imprest_No;
public $Source_Document;
public $Payroll_No;
public $Staff_Name;
public $Imprest_Account;
public $Paying_Bank_Account;
public $Paying_Cashier;
public $Paying_Budget_Center;
public $Requested_On;
public $Travel_Date;
public $Total_Imprest_Amount;
public $Status;
public $Action_ID;
public $Approval_Levels;
public $Due_Date;
public $Purpose;
public $Payment_Method;
public $Payment_Refrence;
public $Created_By;
public $Created_On;
public $Created_At;
public $Posted;
public $isNewRecord;

    /*public function __construct(array $config = [])
    {
        return $this->getLines($this->No);
    }*/

    public function rules()
    {
        return [
                ['Purpose', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Program',
            'Global_Dimension_2_Code' => 'Department'
        ];
    }

    public function getLines($No){
        $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];
        $filter = [
            'Imprest_No' => $No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;


    }



}
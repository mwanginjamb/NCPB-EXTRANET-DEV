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


class Contract extends Model
{

public $Key;
public $Code;
public $Costing_Type;
public $Contract_Type;
public $Quarter;
public $Procurement_Method;
public $Method_Description;
public $Type_Description;
public $Reference_Code;
public $Description;
public $Total_Value;
public $Invoiced_Value;
public $Deliverables;
public $Contractor;
public $Contractor_Name;
public $Comments;
public $Status;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Start_Date;
public $End_Date;
public $Notify_Period;
public $Monitoring_Department;
public $Administration_Department;
public $Notification_Date;
public $Performance_Bond_Exp_Date;
public $Performance_Bond_Notify_Period;
public $Notify_Date;
public $Financial_Year;
public $Created_By;
public $Created_On;
public $Closed_On;
public $Closed_By;
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
            'Global_Dimension_1_Code' => 'Program',
            'Global_Dimension_2_Code' => 'Department'
        ];
    }

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['ContractLines'];
        $filter = [
            'Code' => $this->Code,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;


    }



}
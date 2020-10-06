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


class Leave extends Model
{

public $Key;
public $Employee_No;
public $Employee_Name;
public $Employee_Phone_No;
public $Department_Code;
public $Application_No;
public $Days_Applied;
public $Application_Date;
public $Leave_Status;
public $Comments;
public $Leave_balance;
public $Supervisor_Code;
public $Supervisor_Name;
public $Contact_Address;
public $Reliever;
public $Reliever_Name;
public $Approval_Status;
public $Approval_Level;
public $Action_Id;
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

    public function getLines($No){
        $service = Yii::$app->params['ServiceName']['LeaveApplicationLines'];
        $filter = [
            'Application_No' => $No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;


    }



}
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


class Appraisalcard extends Model
{

public $Key;
public $Appraisal_Code;
public $Employee_No;
public $Employee_Name;
public $Department;
public $Calender_Code;
public $Appraisal_Start_Date;
public $Appraisal_End_Date;
public $Total_KPI_x0027_s;
public $Deparrtment_Name;
public $Approval_Status;
public $Action_ID;
public $Employee_Appraisal_KRAs;
public $Hr_User_ID;

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


     public function getKRA(){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKRAs'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_Code,
            'Employee_No' => $this->Employee_No,
        ];

        $results = Yii::$app->navhelper->getData($service, $filter);
        return $results;
    }

    public function getKPI($KRA_Code){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPIs'];
        $filter = [
            'Appraisal_Code' => $this->Appraisal_Code,
            'Employee_No' => $this->Employee_No,
            'KRA_Code' => $KRA_Code
        ];

        $results = Yii::$app->navhelper->getData($service, $filter);
        return $results;
    }





}
<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Employeeappraisalkra extends Model
{
public $KRA_Code;
public $Objective;
public $Objective_Description;
public $Total_KPI_x0027_s;
public $Appraisal_Code;
public $Employee_No;
public $Key;
public $isNewRecord;
public $Calender_Code;


    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'KRA_Code' => 'Key Result Area',
            'Total_KPI_x0027_s' => 'Total KPIs'
        ];
    }
}
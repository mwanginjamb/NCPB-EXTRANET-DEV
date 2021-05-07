<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Objective extends Model
{

public $Key;
public $isNewRecord;
public $KRA_Code;
public $Objective;
public $Objective_Description;
public $Total_KPI_x0027_s;
public $Appraisal_Code;
public $Employee_No;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'Total_KPI_x0027_s' => 'Total KPIs',
        ];
    }


   
}
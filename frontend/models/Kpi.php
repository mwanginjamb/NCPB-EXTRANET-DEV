<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Kpi extends Model
{

public $KPI_Code;
public $Activity;
public $Target;
public $Maximum_Weight;
public $Target_Achieved;
public $Self_Assesment;
public $Self_Comments;
public $Joint_Assesment;
public $Supervisor_Comments;
public $Weighted_Rating;
public $Hr_Comments;
public $Appraisal_Code;
public $Employee_No;
public $KRA_Code;
public $Key;
public $isNewRecord;

public $Mid_Year_Self_Assesment;
public $Mid_Year_Joint_Assesment;
public $Mid_Year_Weighted_Rating;



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
}
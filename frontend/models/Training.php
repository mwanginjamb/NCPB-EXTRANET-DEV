<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use stdClass;
use Yii;
use yii\base\Model;


class Training extends Model
{

    
public $Key;
public $Request_No;
public $Training_Area;
public $Training_Program;
public $Description;
public $Start_Date;
public $End_Date;
public $Institute_Name;
public $Training_Objectives;
public $Training_Type;
public $Trainer_Type;
public $Trainer_Code;
public $Trainer_Name;
public $Total_Cost;
public $Shortcut_Dimension_1_Code;
public $Shortcut_Dimension_2_Code;
public $Annual_Budget;
public $Available_Budget;
public $Commitment;
public $Budget_to_Date;
public $Budget_G_L;
public $isNewRecord;

public $Status;


   
  
    public function rules()
    {
        return [
            [['Start_Date','End_Date'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Shortcut_Dimension_1_Code' => 'Function Code',
            'Shortcut_Dimension_2_Code' => 'Budget Center Code',
        ];
    }

    

    



}
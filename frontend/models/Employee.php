<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:23 AM
 */

namespace frontend\models;


use yii\base\Model;

class Employee extends Model
{
    public $Key;
public $No;
public $Title;
public $First_Name;
public $Last_Name;
public $Middle_Name;
public $Initials;
public $National_ID_No;
public $Gender;
public $Nationality;
public $Place_of_Birth;
public $Religion;
public $Marital_Status;
public $Status;
public $Ethnic_Group;
public $Supervisor_No;
public $Supervisor_Name;
public $Supervisor_User_ID;
public $HOD_No;
public $HOD_Name;
public $Employee_is_Supervisor;
public $Employee_is_HR;
public $Employee_is_HOD;
public $Is_Training_Manager;
public $Disciplinary_Cases;
public $Line_1;
public $Line_2;
public $Post_Code;
public $City;
public $Global_Dimension_1_Code;
public $Global_Dimension_2_Code;
public $Station_Region;
public $Current_Station;
public $Custom_County;
public $Sub_County;
public $Extension;
public $Mobile_No;
public $Phone_No;
public $E_Mail;
public $Office_E_Mail;
public $Employment_Date;
public $Current_Experience;
public $Date_of_Experience_Starts;
public $Total_Experience;
public $Date_of_Birth;
public $Age;
public $Medical_Aid_Join;
public $Time_on_Medical_Aid_Scheme;
public $Retirement_Date;
public $Service_Period;
public $Job_Position;
public $Position_Description;
public $Contract_Duration;
public $End_Date;
public $Contract_Permanent;
public $Employee_Department;
public $Employee_Dimension;
public $Imprest_Account;
public $Job_Group;
public $Cost_Center_Code;
public $New_Band_Effective_Start_Date;
public $Position;
public $Job_Position_Description;
public $Currency;
public $Effective_Date;
public $Termination_Code;
public $Reason_for_Seperation;
public $Notice_Period_Start_Date;
public $Notice_Period_End_Date;
public $Date_of_Leaving_the_Company;
public $Pension_Scheme_Join;
public $Time_on_Pension_Scheme;
public $ProfileID;

    public function rules()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Global_Dimension_1_Code' => 'Function Code',
            'Global_Dimension_2_Code' => 'Budget Center Code'
        ];
    }

}
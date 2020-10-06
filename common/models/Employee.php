<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


class Employee extends \yii\db\ActiveRecord
{


    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::$app->params['DbCompanyName'].'Employee ';
    }

    /**
     * {@inheritdoc}
     */
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
            
        ];
    }

     public static function getDb(){
        return Yii::$app->nav;
    }
}

<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "socialmedia".
 *
 * @property int $id
 * @property string|null $subject
 * @property string $post
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $created_by
 */
class Socialmedia extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ]
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'socialmedia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post'], 'required'],
            [['post'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['subject', 'created_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'post' => 'Post',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}

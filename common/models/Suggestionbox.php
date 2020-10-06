<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "suggestionbox".
 *
 * @property int $id
 * @property string $subject
 * @property string $suggestion_body
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Suggestionbox extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
                'createdByAttribute' => false,
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suggestionbox';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'suggestion_body'], 'required'],
            [['suggestion_body'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['subject'], 'string', 'max' => 50],
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
            'suggestion_body' => 'Suggestion Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

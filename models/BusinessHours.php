<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "business_hours".
 *
 * @property int $id
 * @property int $shop_id
 * @property int $weekday
 * @property time $start_hour
 * @property time $close_hour
 *
 * @property Shop $shop
 */
class BusinessHours extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business_hours';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weekday', 'start_hour', 'close_hour'], 'required'],
            [['shop_id'], 'integer'],
            [['start_hour', 'close_hour'], 'safe'],
            [['weekday'], 'integer'],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shop::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Shop ID',
            'weekday' => 'Weekday',
            'start_hour' => 'Start Hour',
            'close_hour' => 'Close Hour',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return string
     */
    public function getHoursRange()
    {
        $start_hour = date('H:i', strtotime($this->start_hour));
        $close_hour = date('H:i', strtotime($this->close_hour));
        return $start_hour."-".$close_hour;
    }
}

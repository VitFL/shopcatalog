<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $shop_name
 * @property string $shop_description
 * @property string $shop_address
 *
 * @property BusinessHours[] $businessHours
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_name'], 'required'],
            [['shop_name','shop_description','shop_address'], 'string', 'max' => 255],
            [['business_hours','date_picker'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_name' => 'Shop Name',
            'shop_description' => 'Description',
            'shop_address' => 'Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessHours()
    {
        return $this->hasMany(BusinessHours::className(), ['shop_id' => 'id'])->orderBy(['weekday' => SORT_ASC]);
    }

    public function getBusinessHoursCount()
    {
        return $this->businessHours->count();
    }


    public function getBusinessHoursForWeek()
    {
        return ArrayHelper::map($this->businessHours, 'weekday', 'hoursRange');

    }

    public function getTodayWeekDay()
    {
        return date('N');

    }
}

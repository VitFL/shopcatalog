<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $shop_name
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
            [['shop_name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessHours()
    {
        return $this->hasMany(BusinessHours::className(), ['shop_id' => 'id']);
    }
}

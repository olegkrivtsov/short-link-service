<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $created_at
 * @property string $ip_address
 * @property int $short_link_id
 */
class Visit extends ActiveRecord
{
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip_address', 'short_link_id'], 'required'],
            [['created_at'], 'safe'],
            [['ip_address'], 'string'],
            [['short_link_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Дата создания'),
			'ip_address' => Yii::t('app', 'IP адрес'),
            'short_link_id' => Yii::t('app', 'Кортокая ссылка'),
        ];
    }

}

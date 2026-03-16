<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $created_at
 * @property string $url
 * @property string $short_link
 * @property int $visit_count
 */
class ShortLink extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'short_link';
    }

    public function rules(): array
    {
        return [
            [['url'], 'required'],
            [['created_at'], 'safe'],
            [['url'], 'url'],
            ['url', 'validatePageAvailability'],
            [['short_link'], 'string', 'max' => 64],
            ['visit_count', 'integer', 'min' => 0],
        ];
    }

    public function validatePageAvailability($attribute, $params, $validator, $current): void
    {
        if (@file_get_contents($this->url) === false) {
            $this->addError(
                $attribute, 
                'Страница не открывается!'
            );
        }
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Дата создания'),
			'url' => Yii::t('app', 'URL'),
            'short_link' => Yii::t('app', 'Кортокая ссылка'),
            'visit_count' => Yii::t('app', 'Количество переходов'),
        ];
    }

    public function generateShortLink(): void
    {
        $this->short_link = substr(md5(uniqid(rand(), true)), 0, 6);
    }

    public function getAbsoluteShortLink(): string
    {
        return Yii::$app->request->hostInfo . '/sl/' . $this->short_link;
    }
}

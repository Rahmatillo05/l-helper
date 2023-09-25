<?php

namespace common\models\tag;

use common\models\category\DataCategory;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property int|null $data_category_id
 * @property string|null $name
 *
 * @property DataCategory $dataCategory
 */
class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['data_category_id'], 'default', 'value' => null],
            [['data_category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['data_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DataCategory::class, 'targetAttribute' => ['data_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'data_category_id' => 'Data Category ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[DataCategory]].
     *
     * @return ActiveQuery
     */
    public function getDataCategory(): ActiveQuery
    {
        return $this->hasOne(DataCategory::class, ['id' => 'data_category_id']);
    }
}

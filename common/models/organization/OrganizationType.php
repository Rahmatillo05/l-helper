<?php

namespace common\models\organization;

use common\components\Detect;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "organization_type".
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class OrganizationType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'organization_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status'], 'default', 'value' => Detect::ACTIVE],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "papeles".
 *
 * @property int $id
 * @property string $papel
 *
 * @property Participaciones[] $participaciones
 */
class Papeles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'papeles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['papel'], 'required'],
            [['papel'], 'string', 'max' => 255],
            [['papel'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'papel' => 'Papel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipaciones()
    {
        return $this->hasMany(Participaciones::className(), ['papel_id' => 'id'])->inverseOf('papel');
    }
}

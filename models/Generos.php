<?php

namespace app\models;

/**
 * This is the model class for table "generos".
 *
 * @property int $id
 * @property string $genero
 *
 * @property Peliculas[] $peliculas
 */
class Generos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['genero'], 'required'],
            [['genero'], 'trim'],
            [['genero'], 'string', 'max' => 255],
            [['genero'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genero' => 'Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Peliculas::className(), ['genero_id' => 'id'])->inverseOf('genero');
    }
}

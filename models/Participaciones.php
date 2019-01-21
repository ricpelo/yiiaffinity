<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participaciones".
 *
 * @property int $pelicula_id
 * @property int $persona_id
 * @property int $papel_id
 *
 * @property Papeles $papel
 * @property Peliculas $pelicula
 * @property Personas $persona
 */
class Participaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelicula_id', 'persona_id', 'papel_id'], 'required'],
            [['pelicula_id', 'persona_id', 'papel_id'], 'default', 'value' => null],
            [['pelicula_id', 'persona_id', 'papel_id'], 'integer'],
            [['pelicula_id', 'persona_id', 'papel_id'], 'unique', 'targetAttribute' => ['pelicula_id', 'persona_id', 'papel_id']],
            [['papel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Papeles::className(), 'targetAttribute' => ['papel_id' => 'id']],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
            [['persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['persona_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pelicula_id' => 'Pelicula ID',
            'persona_id' => 'Persona ID',
            'papel_id' => 'Papel ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPapel()
    {
        return $this->hasOne(Papeles::className(), ['id' => 'papel_id'])->inverseOf('participaciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelicula()
    {
        return $this->hasOne(Peliculas::className(), ['id' => 'pelicula_id'])->inverseOf('participaciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Personas::className(), ['id' => 'persona_id'])->inverseOf('participaciones');
    }
}

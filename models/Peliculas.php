<?php

namespace app\models;

/**
 * This is the model class for table "peliculas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $anyo
 * @property string $sinopsis
 * @property int $duracion
 * @property int $genero_id
 *
 * @property Participaciones[] $participaciones
 * @property Generos $genero
 */
class Peliculas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peliculas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['anyo'], 'number'],
            [['sinopsis'], 'string'],
            [['duracion', 'genero_id'], 'default', 'value' => null],
            [['duracion', 'genero_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'anyo' => 'Anyo',
            'sinopsis' => 'Sinopsis',
            'duracion' => 'Duracion',
            'genero_id' => 'Genero ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipaciones()
    {
        return $this->hasMany(Participaciones::className(), ['pelicula_id' => 'id'])->inverseOf('pelicula');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id'])->inverseOf('peliculas');
    }

    public function getPersonas()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->via('participaciones');
    }
}

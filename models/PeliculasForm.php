<?php

namespace app\models;

use yii\base\Model;

class PeliculasForm extends Model
{
    public $titulo;
    public $anyo;
    public $duracion;
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['anyo', 'duracion', 'genero_id'], 'number'],
            [['titulo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'titulo' => 'Título',
            'anyo' => 'Año',
            'duracion' => 'Duración',
            'genero_id' => 'Género',
        ];
    }
}

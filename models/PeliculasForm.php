<?php

namespace app\models;

use yii\base\Model;

class PeliculasForm extends Model
{
    public $titulo;
    public $anyo;
    public $duracion;
    public $sinopsis;
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['genero_id'], 'number'],
            [['titulo', 'sinopsis'], 'trim'],
            [['titulo'], 'string', 'max' => 255],
            [['anyo'], 'integer', 'min' => 0, 'max' => 9999],
            [['duracion'], 'integer', 'min' => 0, 'max' => 32767],
        ];
    }

    public function attributeLabels()
    {
        return [
        'titulo' => 'Título',
        'anyo' => 'Año',
        'duracion' => 'Duración',
        'sinopsis' => 'Sinopsis',
        'genero_id' => 'Género',
        ];
    }
}

<?php

namespace app\models;

use yii\base\Model;

class PeliculasForm extends Model
{
    public $titulo;
    public $anyo;
    public $sinopsis;
    public $duracion;
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['genero_id'], 'integer', 'min' => 0],
            [['anyo'], 'integer', 'min' => 0, 'max' => 9999],
            [['duracion'], 'integer', 'min' => 0, 'max' => 32767],
            [['titulo'], 'string', 'max' => 255],
            [['sinopsis'], 'trim'],
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

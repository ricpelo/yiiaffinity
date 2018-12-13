<?php

namespace app\models;

use yii\base\Model;

class BuscarForm extends Model
{
    public $titulo;
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo'], 'safe'],
            [['genero_id'], 'integer'],
        ];
    }
}

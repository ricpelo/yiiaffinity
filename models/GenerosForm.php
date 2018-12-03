<?php

namespace app\models;

use yii\base\Model;

class GenerosForm extends Model
{
    public $genero;

    public function rules()
    {
        return [
            [['genero'], 'required'],
            [['genero'], 'string', 'max' => 255],
        ];
    }
}

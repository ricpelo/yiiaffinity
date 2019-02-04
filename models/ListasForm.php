<?php

namespace app\models;

use yii\base\Model;

class ListasForm extends Model
{
    public $provincia;
    public $municipio;

    public function rules()
    {
        return [
            [['provincia', 'municipio'], 'safe'],
        ];
    }
}

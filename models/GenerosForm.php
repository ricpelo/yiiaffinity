<?php

namespace app\models;

use Yii;
use yii\base\Model;

class GenerosForm extends Model
{
    public $genero;

    public function rules()
    {
        return [
            [['genero'], 'required'],
            [['genero'], 'trim'],
            [['genero'], 'string', 'max' => 255],
            [['genero'], function ($attribute, $params, $validator) {
                $fila = (new \yii\db\Query())
                    ->select('id')
                    ->from('generos')
                    ->where(['genero' => $this->$attribute])
                    ->one();
                if (!empty($fila) && $fila['id'] != Yii::$app->request->get('id')) {
                    $this->addError($attribute, 'Ese género ya existe.');
                }
            }],
        ];
    }
}

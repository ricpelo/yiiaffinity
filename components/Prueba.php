<?php

namespace app\components;

use yii\base\BaseObject;

class Prueba extends BaseObject
{
    public $uno;
    private $_dos;

    public function __construct(ISaludo $saludo, $config = [])
    {
        $this->uno = $saludo;
        parent::__construct($config);
    }

    public function getDos()
    {
        return $this->_dos;
    }

    public function setDos($valor)
    {
        $this->_dos = $valor;
    }
}

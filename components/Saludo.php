<?php

namespace app\components;

use yii\base\Component;

/**
 * La clase que saluda.
 */
class Saludo extends Component implements ISaludo
{
    public const HOLA = 'hola';
    public $mensaje = self::HOLA;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function saludar()
    {
        echo $this->mensaje;
    }
}

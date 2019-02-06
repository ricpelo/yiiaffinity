<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Usuarios;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * Este comando saluda al usuario.
     * @param string $message the message to be echoed.
     * @param mixed $persona
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world', $persona = 'Ricardo')
    {
        echo "$message $persona\n";

        return ExitCode::OK;
    }

    /**
     * Elimina usuarios que no se conectan desde hace más de 90 días.
     * @return int Código de salida
     */
    public function actionLimpiar()
    {
        $pasado = new \DateTime();
        $pasado = $pasado
            ->sub(new \DateInterval('P1D'))
            ->format('Y-m-d H:i:s');
        $numero = Usuarios::deleteAll(['<', 'created_at', $pasado]);
        echo "Se han borrado $numero filas.\n";
        $this->stdout("Hello?\n", Console::BOLD);
        echo \yii\console\widgets\Table::widget([
            'headers' => ['Project', 'Status', 'Participant'],
            'rows' => [
                ['Yii', 'OK', '@samdark'],
                ['Yii', 'OK', '@cebe'],
            ],
        ]);
        return ExitCode::OK;
    }
}

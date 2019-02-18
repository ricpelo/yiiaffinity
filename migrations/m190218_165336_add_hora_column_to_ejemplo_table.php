<?php

use yii\db\Migration;

/**
 * Handles adding hora to table `ejemplo`.
 */
class m190218_165336_add_hora_column_to_ejemplo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ejemplo', 'hora', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ejemplo', 'hora');
    }
}

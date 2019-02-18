<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ejemplo`.
 */
class m190218_163527_create_ejemplo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ejemplo', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull()->unique(),
            'fecha' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ejemplo');
    }
}

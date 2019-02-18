<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ejemplo_personas`.
 * Has foreign keys to the tables:.
 *
 * - `ejemplo`
 * - `personas`
 */
class m190218_165734_create_junction_ejemplo_and_personas_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ejemplo_personas', [
            'ejemplo_id' => $this->integer(),
            'personas_id' => $this->integer(),
            'PRIMARY KEY(ejemplo_id, personas_id)',
        ]);

        // add foreign key for table `ejemplo`
        $this->addForeignKey(
            'fk-ejemplo_personas-ejemplo_id',
            'ejemplo_personas',
            'ejemplo_id',
            'ejemplo',
            'id'
        );

        // creates index for column `personas_id`
        $this->createIndex(
            'idx-ejemplo_personas-personas_id',
            'ejemplo_personas',
            'personas_id'
        );

        // add foreign key for table `personas`
        $this->addForeignKey(
            'fk-ejemplo_personas-personas_id',
            'ejemplo_personas',
            'personas_id',
            'personas',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `ejemplo`
        $this->dropForeignKey(
            'fk-ejemplo_personas-ejemplo_id',
            'ejemplo_personas'
        );

        // drops foreign key for table `personas`
        $this->dropForeignKey(
            'fk-ejemplo_personas-personas_id',
            'ejemplo_personas'
        );

        // drops index for column `personas_id`
        $this->dropIndex(
            'idx-ejemplo_personas-personas_id',
            'ejemplo_personas'
        );

        $this->dropTable('ejemplo_personas');
    }
}

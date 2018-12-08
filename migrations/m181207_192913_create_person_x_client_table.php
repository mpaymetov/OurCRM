<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_x_client`.
 */
class m181207_192913_create_person_x_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person_x_client', [
            'id_person_x_client' => $this->primaryKey(),
            'id_person' => $this->integer()->notNull(),
            'id_client' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-person_x_client-id_person',
            'person_x_client',
            'id_person'
        );


        $this->addForeignKey(
            'fk-person_x_client-id_person',
            'person_x_client',
            'id_person',
            'person',
            'id_person',
            'CASCADE'
        );

        $this->createIndex(
            'idx-person_x_client-id_client',
            'person_x_client',
            'id_client'
        );


        $this->addForeignKey(
            'fk-person_x_client-id_client',
            'person_x_client',
            'id_client',
            'client',
            'id_client',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-person_x_client-id_person',
            'person_x_client'
        );


        $this->dropIndex(
            'idx-person_x_client-id_person',
            'person_x_client'
        );

        $this->dropForeignKey(
            'fk-person_x_client-id_client',
            'person_x_client'
        );


        $this->dropIndex(
            'idx-person_x_client-id_client',
            'person_x_client'
        );


        $this->dropTable('person_x_client');
    }
}

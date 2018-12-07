<?php

use yii\db\Migration;

/**
 * Handles adding id_person to table `client`.
 */
class m181207_164525_add_id_person_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('client', 'id_person', $this->integer());
        $this->createIndex(
            'idx-client-id_person',
            'client',
            'id_person'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-client-id_person',
            'client',
            'id_person',
            'person',
            'id_person',
            'RESTRICT'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-client-id_person',
            'client'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-client-id_person',
            'client'
        );
        $this->dropColumn('client', 'id_person');

    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding id_client to table `person`.
 */
class m181208_155829_add_id_client_column_to_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('person', 'id_client', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('person', 'id_client');
    }
}

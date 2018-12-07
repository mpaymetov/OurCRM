<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person`.
 */
class m181207_163538_create_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('person', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(50),
            'last_name' => $this->string(50),
            'position' => $this->string(100),
            'contact' => $this->string(20),
            'email' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('person');
    }
}

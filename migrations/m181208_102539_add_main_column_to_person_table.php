<?php

use yii\db\Migration;

/**
 * Handles adding main to table `person`.
 */
class m181208_102539_add_main_column_to_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('person', 'main', $this->boolean());
        $this->addColumn('person', 'version', $this->integer(11));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('person', 'main');
        $this->dropColumn('person', 'version');
    }
}

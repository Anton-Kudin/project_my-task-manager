<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m181108_233833_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
        	'id' => $this->primaryKey(),
					"title" => $this->string()->notNull(),
					"descr" => $this->text(),
					"day_id" => $this->integer(),
					'count_time' => $this->dateTime()->defaultValue(null),
					"total_time" => $this->integer(100)->defaultValue(0),
					'status' => $this->boolean()->defaultValue(false),
					'complete' => $this->boolean()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
    }
}

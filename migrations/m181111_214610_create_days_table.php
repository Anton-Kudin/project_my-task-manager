<?php

use yii\db\Migration;

/**
 * Handles the creation of table `days`.
 */
class m181111_214610_create_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->createTable('days', [
				'id' => $this->primaryKey(),
				"date" => $this->date(),
				'count_time' => $this->dateTime()->defaultValue(null),
				"total_time" => $this->integer(100)->defaultValue(0),
				"status_time" => $this->boolean()->defaultValue(false),
				"user_id" => $this->integer(),
			]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('days');
    }
}

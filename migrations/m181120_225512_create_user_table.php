<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m181120_225512_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
        	'id' => $this->primaryKey(),
					"name" => $this->string(),
					"email" => $this->string()->unique(),
					"password" => $this->string(),
					"status_reg" => $this->boolean()->defaultValue(false),
					"auth_key" => $this->string()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}

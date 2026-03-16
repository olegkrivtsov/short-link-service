<?php

use yii\db\Migration;

class m260313_125915_initial extends Migration
{
    public function safeUp()
    {
        $this->createTable('short_link', [
            'id' => $this->bigPrimaryKey(),
			'created_at' => $this->datetime()->notNull()->defaultExpression('NOW()'),
			'url' => $this->text(),
            'short_link' => $this->string(64),
            'visit_count' => $this->integer()->notNull()->defaultValue(0),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'i_short_link_short_link', 
            'short_link', 
            ['short_link'], 
            true
        );

        $this->createTable('visit', [
            'id' => $this->bigPrimaryKey(),
			'created_at' => $this->datetime()->notNull()->defaultExpression('NOW()'),
			'ip_address' => $this->string(15),
            'short_link_id' => $this->bigInteger(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_visit_short_link_id',
            'visit',
            ['short_link_id'],
            'short_link',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    public function safeDown()
    {
        $this->dropTable('visit');
        $this->dropTable('short_link');
    }
}

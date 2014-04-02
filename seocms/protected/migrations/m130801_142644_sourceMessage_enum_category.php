<?php

class m130801_142644_sourceMessage_enum_category extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('SourceMessage','category','enum(\'frontend\',\'backend\')');
	}

	public function down()
	{
        $this->alterColumn('SourceMessage','category','string');
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
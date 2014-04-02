<?php

class m130801_143044_sourceMessage_update_all_to_backend extends CDbMigration
{
	public function up()
	{
        $this->update('SourceMessage',array('category'=>'backend'),'category!="backend"');
	}

	public function down()
	{
		echo "m130801_143044_sourceMessage_update_all_to_backend does not support migration down.\n";
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
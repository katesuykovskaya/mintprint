<?php

class m130802_093950_SourceMessage_id_fk_to_source_id_Messages extends CDbMigration
{
	public function up()
	{
        $this->addForeignKey('sourceMsgFK','Message','id','SourceMessage','id','cascade','no action');
	}

	public function down()
	{
		echo "m130802_093950_SourceMessage_id_fk_to_source_id_Messages does not support migration down.\n";
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
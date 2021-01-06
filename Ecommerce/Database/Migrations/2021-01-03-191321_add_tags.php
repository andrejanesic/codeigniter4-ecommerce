<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTags extends Migration {
	public function up() {
		$this->forge->addField([
			'tag_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'client_id' => [
				'type'       => 'INT',
				'constraint' => 8,
			],
			'value' => [
				'type' => 'VARCHAR',
				'constraint' => 50
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('tag_id', TRUE);
		$this->forge->createTable('tags');
	}

	public function down() {
		$this->forge->dropTable('tags');
	}
}

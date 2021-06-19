<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContacts extends Migration {
	public function up() {
		$this->forge->addField([
			'contact_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'contact_uuid' => [
				'type'       => 'VARCHAR',
				'constraint' => 16,
				'unique'     => true,
			],
			'contact_token' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => true
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => true
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'first_name' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'last_name' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'phone' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'country' => [
				'type'       => 'VARCHAR',
				'constraint' => 2,
				'null'       => true
			],
			'state' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'city' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => true
			],
			'zip' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true
			],
			'address_1' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'address_2' => [
				'type'       => 'VARCHAR',
				'constraint' => 150,
				'null'       => true
			],
			'last_ip' => [
				'type'       => 'VARCHAR',
				'constraint' => 15,
				'null'       => true
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'deleted_at DATETIME DEFAULT NULL',
		]);
		$this->forge->addKey('contact_id', TRUE);
		$this->forge->createTable('contacts');
	}

	public function down() {
		$this->forge->dropTable('contacts');
	}
}

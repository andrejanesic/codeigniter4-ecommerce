<?php

namespace Ecommerce\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrders extends Migration {
	public function up() {
		$this->forge->addField([
			'order_id' => [
				'type'           => 'INT',
				'constraint'     => 8,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'session_id' => [
				'type'       => 'INT',
				'constraint' => 8,
				'unsigned'   => true
			],
			'contact_id' => [
				'type'       => 'INT',
				'constraint' => 8,
				'unsigned'   => true
			],
			'status' => [
				'type'       => 'VARCHAR',
				'constraint' => 30
			],
			'amount' => [
				'type' => 'FLOAT',
				'unsigned' => true
			],
			'items' => [
				'type' => 'TEXT',
				'null' => true
			],
			'reference' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => true,
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
		]);
		$this->forge->addKey('order_id', TRUE);
		$this->forge->createTable('orders');
	}

	public function down() {
		$this->forge->dropTable('orders');
	}
}

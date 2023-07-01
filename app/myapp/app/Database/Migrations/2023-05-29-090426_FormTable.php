<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormTable extends Migration
{
  public function up()
  {
    $this->forge->addField([
        'form_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
        'form_blob' => ['type' => 'BLOB'],
    ]);
    $this->forge->addKey('form_id', true);
    $this->forge->createTable('form');

    $user_fields = [
        'user_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => TRUE],
        'FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`)'
    ];
    $this->forge->addColumn('form', $user_fields);

  }

  public function down()
  {
    $this->forge->dropTable('form');
  }
}

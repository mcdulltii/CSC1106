<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FormStyleTable extends Migration
{
    public function up()
    {
      $this->forge->addField([
          'form_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
          'form_blob' => ['type' => 'TEXT'],
      ]);
      $this->forge->addKey('form_id', true);
      $this->forge->createTable('forms');

      $user_fields = [
          'user_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => TRUE],
          'FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`)'
      ];
      $this->forge->addColumn('forms', $user_fields);

      $form_fields = [
          'form_style_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => TRUE],
          'FOREIGN KEY(`form_style_id`) REFERENCES `form_styles`(`form_style_id`)'
      ];
      $this->forge->addColumn('forms', $form_fields);
    }

    public function down()
    {
      $this->forge->dropTable('forms');
    }
}

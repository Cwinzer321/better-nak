<?php
class Migration_Add_cart_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('product_id');
        $this->dbforge->create_table('cart');

        // Add foreign key constraints
        $this->db->query('ALTER TABLE cart ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE cart ADD CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products(id_produk) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->dbforge->drop_table('cart');
    }
}

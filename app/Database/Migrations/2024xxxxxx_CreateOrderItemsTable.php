
public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true
        ],
        'order_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true
        ],
        'produk_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true
        ],
        'quantity' => [
            'type' => 'INT',
            'constraint' => 11
        ],
        'price' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2'
        ]
    ]);
    
    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('order_id', 'order', 'id_order', 'CASCADE', 'CASCADE');
    $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
    $this->forge->createTable('order_items');
}

public function down()
{
    $this->forge->dropTable('order_items');
}
<?php

class Order extends CI_Model
{
	function get_all_products()
	{
		return $this->db->query("SELECT * FROM products")->result_array();
	}

	function get_product_by_id($id)
	{
		return $this->db->query("SELECT * FROM products WHERE id = ?", array($id))->row_array();
	}

	function place_order($order)
	{
		$query = "INSERT INTO orders (name, address, total_price, card_number, created_at, updated_at) VALUES (?,?,?,?, NOW(), NOW())";
		$values = array($order['name'], $order['address'], $order['total_price'], $order['card_number']);
		return $this->db->query($query, $values);
	}

	function get_last_order_entry()
    {
    	$query ="SELECT id FROM orders ORDER BY id DESC LIMIT 1";
    	return $this->db->query($query)->row_array();
    }

    function add_to_orders_has_products($product_info)
    {
    	$query = "INSERT INTO orders_has_products (order_id, product_id, price, quantity) VALUES (?,?,?,?)";
    	$values = array($product_info['order_id'], $product_info['product_id'], $product_info['price'], $product_info['quantity']);
    	return $this->db->query($query, $values);
    }
}
?>
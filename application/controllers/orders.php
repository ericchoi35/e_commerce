<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function index()
	{	
		$products = $this->Order->get_all_products();
		if(!$this->session->userdata('quantity'))
		{
			$this->session->set_userdata('quantity', 0);
		}
		if(!$this->session->userdata('cart'))
		{
			$this->session->set_userdata('cart', array());
		}
		$products = array('products' => $products);
		// var_dump($this->session->all_userdata()); 
		$this->load->view('index', $products);
		// $this->load->view('index', array('products' => $products));
		// $this->session->sess_destroy();
	}

	public function update()
	{
		$cart = $this->session->userdata('cart');
		$quantity = 0;
		$item_exist = null;

		for($i = 0; $i < count($cart); $i++)
		{
			if($cart[$i]['product_id'] == $this->input->post('product_id'))
			{
				$item_exist = true;
				$cart[$i]['quantity'] += $this->input->post('quantity');
			}
			$quantity += $cart[$i]['quantity'];
		}

		if(!$item_exist)
		{
			array_push($cart,
				array('product_id' => $this->input->post('product_id'),
						'quantity' => $this->input->post('quantity'))
			);
			$quantity += $this->input->post('quantity');
		}

		$this->session->set_userdata('quantity', $quantity);

		$this->session->set_userdata('cart', $cart);

		redirect('/');
	}

	public function cart()
	{
		$cart = $this->session->userdata('cart');
		$items = array();
		$total = 0;
		for($i = 0; $i < count($cart); $i++)
		{
			$product = $this->Order->get_product_by_id($cart[$i]['product_id']);
			array_push($items,
				array(	'id' => $product['id'],
						'name' => $product['name'],
						'price' => $product['price'],
						'quantity' => $cart[$i]['quantity']
				)
			);
			$total += ($cart[$i]['quantity'] * $product['price']);
		}	
		$this->session->set_userdata('total', $total);
		$this->load->view('cart', array('items' => $items));
	}

	public function delete()
	{
		$cart = $this->session->userdata('cart');
		$quantity = $this->session->userdata('quantity');
		for($i = 0; $i < count($cart); $i++)
		{
			if($cart[$i]['product_id'] == $this->input->post('id'))
			{	
				$quantity -= $cart[$i]['quantity'];
				array_splice($cart, $i, 1);
			}
		}

		$this->session->set_userdata('cart', $cart);
		$this->session->set_userdata('quantity', $quantity);
		redirect('/cart');
	}

	public function create()
	{	
		$cart = $this->session->userdata('cart');
		if(count($cart) == 0)
		{
			$this->session->set_flashdata('message', 'There are no items in your cart.');
			redirect('/cart');
		}
		else
		{
			$items = array();
			$total = 0;
			for($i = 0; $i < count($cart); $i++)
			{
				$product = $this->Order->get_product_by_id($cart[$i]['product_id']);
				array_push($items,
					array(	'id' => $product['id'],
							'name' => $product['name'],
							'price' => $product['price'],
							'quantity' => $cart[$i]['quantity']
					)
				);
				$total += ($cart[$i]['quantity'] * $product['price']);
			}	

			//insert order into database
			$order_info = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'card_number' => intval($this->input->post('card_number')),
				'total_price' => $total
				);
			$this->Order->place_order($order_info);

			//get order id
			$order_id = $this->Order->get_last_order_entry();

			//add each product in order into orders_has_products table
			for($i = 0; $i < count($items); $i++)
			{
				$product_info = array(
					'order_id' => $order_id['id'],
					'product_id' => $items[$i]['id'],
					'price' => $items[$i]['price'],
					'quantity' => $items[$i]['quantity'],
					);
				$this->Order->add_to_orders_has_products($product_info);
			}
			$unset_session = array('cart' => array(), 'total' => 0, 'quantity' => 0);
			$this->session->unset_userdata($unset_session);
			$this->session->set_flashdata('success', 'Your order has been successfully placed.');
			redirect('/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Watchlist extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
        parent::__construct();
    }

	public function index()
	{

		

        $this->load->view('watchlist/index');
	}

	public function chart_json(){

		$watchlist_id = 1;

		$rec = $this->db->query("SELECT p.p_name,w.w_name 
			FROM pairs_watchlist as pw
			LEFT JOIN pairs as p on p.p_id=pw.p_id_fk
			LEFT JOIN watchlist as w on w.w_id=pw.w_id_fk
			WHERE pw.w_id_fk='".$watchlist_id."'")->result_array();
        if(!empty($rec))
        {
        	$select = '';
        	$total = '';
        	$joins = '';
        	$i = 0;
        	$from = '';

        	foreach ($rec as $key => $value) {
        		if($i==0){
        			$i++;
        			$from = $value['p_name'].' as a';
        			$select =" a.trade_datetime, a.change as ".$value['p_name']." ";
        			$total = "a.change";
        		}else{
        			$joins .= " JOIN ".$value['p_name']." ON ".$value['p_name'].".trade_datetime=a.trade_datetime";
        			$select .=", ".$value['p_name'].".change as ".$value['p_name']." ";
        			$total .= "+".$value['p_name'].".change";
        		}


        	}
        	$where = " WHERE a.trade_datetime >= '2020-09-01 04:00:00' and a.trade_datetime < '2020-09-02 04:00:00'";

        	$query_maker = "SELECT $select,($total) as total_change FROM $from $joins $where";

        	$rec1 = $this->db->query($query_maker)->result_array();
        	$final = array();
        	foreach ($rec1 as $key => $value) {
        		$final[] = array(strtotime($value['trade_datetime']),(float)$value['total_change']);

        	}
        	echo json_encode($final);          
        }

	}
	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		exit;
		$file_path = './assets/csv/EURUSD.csv';
        $row = 1;
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {
            	//print "<pre>";
            	// if($row==1000)
            	// 	break;

                    $row++;
                    $data_formate = str_replace('.','-',$data[0]);
                    $trade_datetime = date('Y-m-d H:i:s',strtotime($data_formate.' '.$data[1]));
                    if($this->already_exist_trade($trade_datetime)){
                    	continue;
                    }
                    $dayOpen = $this->get_day_open_value($trade_datetime,$data[2]);
                    if($dayOpen != 'no'){

                    	$change_value = ($data[5] - $dayOpen)*10000;
	                    $record = array(
	                        'trade_datetime' =>$trade_datetime,

	                        'day_open' => $dayOpen,
	                        'open' => $data[2],
	                        'high' => $data[3],
	                        'low' => $data[4],
	                        'close' => $data[5],
	                        'change' => $change_value,
	                    );
	                    $this->db->insert('eurusd',$record);
	                    print_r($record);

					}

                    // $record = json_encode($record);
                    // $formdata = array(
                    //     'record' => $record,
                    //     'imei_no' => $data[5],
                    //     'location' => $data[4]
                    // );
                    //$this->db->insert('form_results', $formdata);
                //}
            }
            fclose($handle);
        }
        exit;
		
	}

	public function get_day_open_value($trade_datetime,$trade_open){

		$day_start_time = ' 04:00:00';

		$cur_date=date('Y-m-d',strtotime($trade_datetime));
		

		if($trade_datetime >= $cur_date.' 00:00:00' && $trade_datetime < $cur_date.$day_start_time){
			$minus_one_day=date('Y-m-d',strtotime($cur_date . "-1 days"));
			$start_datetime = $minus_one_day.$day_start_time;
			$add_one_day=$cur_date;
		}else{
			$add_one_day=date('Y-m-d',strtotime($cur_date . "+1 days"));
			$start_datetime = $cur_date.$day_start_time;
		}

		$end_datetime = $add_one_day.$day_start_time;

		//echo $start_datetime.' >';
		//echo $end_datetime;
		if($start_datetime == $trade_datetime){
		
			return $trade_open;
		
		}
		else if($trade_datetime >= $start_datetime && $trade_datetime < $end_datetime){
		
			$rec = $this->db->query("SELECT open FROM eurusd WHERE trade_datetime='".$start_datetime."'")->row_array();
			//print_r($rec);
	        if(!empty($rec))
	        {
	          return $rec['open'];  //$this->db->insert('kml_poligon', $record);
	        }
	        return 'no';
			//get open value from $start_datetime and return
			//echo 'old day entry';
		
		}
		else{
			return 'no';
		}
		

		//

	}	

	public function already_exist_trade($dateOpen){
		$rec = $this->db->query("SELECT open FROM eurusd WHERE trade_datetime='".$dateOpen."'")->row_array();
		//print_r($rec);
        if(!empty($rec))
        {
			return true;
        }
		return false;

	}
}

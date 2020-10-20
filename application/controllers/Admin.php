<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
        $this->load->view('login/index');
    }

    public function pairs(){

      if($this->input->post())
      {

        $pair_name = $this->input->post('pair_name');

        $query_maker = "SELECT * FROM pairs where p_name='$pair_name'";

        $all_rec = $this->db->query($query_maker)->result_array();
        if(count($all_rec)>0){
          //die('Pair Already Exist');
        }
        else{
          $record = array('p_name'=>$pair_name);
          $this->db->insert('pairs',$record);
        }

        $query_pairs = "SELECT * FROM pairs";

        $all_rec = $this->db->query($query_pairs)->result_array();

        foreach ($all_rec  as $key => $value) {

          $pair_name = $value['p_name'];
          $this->db->query("CREATE TABLE IF NOT EXISTS $pair_name (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `name` VARCHAR(10) NOT NULL,
                          `trade_datetime` timestamp NOT NULL,
                          `day_open` float NOT NULL,
                          `open` float NOT NULL,
                          `high` float NOT NULL,
                          `low` float NOT NULL,
                          `close` float NOT NULL,
                          `change` float NOT NULL,
                          PRIMARY KEY(id)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        }

        

        
      }


      $this->load->view('template/header');
      $this->load->view('admin/pairs');
      $this->load->view('template/footer');


    }

    public function importdata(){

       if ($this->input->post()) {
                $pair_name = $this->input->post('pair_name');
                if ($_FILES['file_name']['name'] != '') {
                    $abs_path = './assets/csv/';
                    $old = umask(0);
                    @mkdir($abs_path, 0777);
                    umask($old);

                    $fileName = time().'_'.$pair_name.'.csv';

                    $config['upload_path'] = $abs_path;
                    $config['file_name'] = $fileName;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'csv';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file_name')) {

                        //$this->session->set_flashdata('validate', array('message' => 'File uploading issue. '.$this->upload->display_errors(), 'type' => 'error'));
                        //redirect(base_url() . 'UploadProfile');
                        
                    } else {
                        $file_path = './assets/csv/'.$fileName;
                        //$data['upload_file_path'] = $file_path;

                        $row = 1;
                        if (($handle = fopen($file_path, "r")) !== FALSE) {
                          while (($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {
                              //print "<pre>";
                              // if($row==1000)
                              //  break;

                                  $row++;
                                  $data_formate = str_replace('.','-',$data[0]);
                                  $trade_datetime = date('Y-m-d H:i:s',strtotime($data_formate.' '.$data[1]));
                                  if($this->already_exist_trade($trade_datetime,$pair_name)){
                                      continue;
                                  }
                                  $dayOpen = $this->get_day_open_value($trade_datetime,$data[2],$pair_name);
                                  if($dayOpen != 'no'){

                                    //check if its jpy multiply 10000
                                    if(strpos($pair_name, 'JPY') !== false)
                                      $change_value = ($data[5] - $dayOpen)*100;
                                    else
                                      $change_value = ($data[5] - $dayOpen)*10000;
                                    
                                      $record = array(
                                          'name'=>$pair_name,
                                          'trade_datetime' =>$trade_datetime,
                                          'day_open' => $dayOpen,
                                          'open' => $data[2],
                                          'high' => $data[3],
                                          'low' => $data[4],
                                          'close' => $data[5],
                                          'change' => $change_value,
                                      );
                                      $this->db->insert($pair_name,$record);
                                  }

                          }
                          fclose($handle);
                      }

                    }
                }
                return true;
            }






        $pairs_string = "";
        $data = array();

        $query_maker = "SELECT * FROM pairs order by p_name ASC";

          $all_rec = $this->db->query($query_maker)->result_array();


        foreach($all_rec as $rec_info) {
            $selected = "";
            // if($district_id != '' and $district_id== $district_info['id']){
            //     $selected = "selected='selected'";
            // }
            // if($rec_info['name'] != 'other')
                $pairs_string .= "<option value='".$rec_info['p_name']."' ". $selected." >".$rec_info['p_name']."</option>";
        }       
      $data['pairs_string']=$pairs_string;
      $this->load->view('template/header');
      $this->load->view('admin/importdata',$data);
      $this->load->view('template/footer');

    }


    public function get_day_open_value($trade_datetime,$trade_open,$pair_name){

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

        if($start_datetime == $trade_datetime){
            return $trade_open;
        }
        else if($trade_datetime >= $start_datetime && $trade_datetime < $end_datetime){
        
            $rec = $this->db->query("SELECT open FROM $pair_name WHERE trade_datetime='".$start_datetime."'")->row_array();
            if(!empty($rec))
            {
              return $rec['open'];
            }
            return 'no';
        }
        else{
            return 'no';
        }
    }   

    public function already_exist_trade($dateOpen,$pair_name){
        $rec = $this->db->query("SELECT open FROM $pair_name WHERE trade_datetime='".$dateOpen."'")->row_array();
        if(!empty($rec))
        {
            return true;
        }
        return false;
    }
}
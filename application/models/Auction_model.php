<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auction_model extends CI_Model{

	public $table = 'auction';

	public function record_count($tableName,$condition){
            SetCondition($condition,false);
            if($tableName!='' || !empty( $tableName )){
                $this->table = $tableName;
            } 
            $totalrecords = $this->db->count_all_results($this->table);                     
            return $totalrecords;
        }
        public function get_records($tableName, $start, $limit, $condition = array())
        {

            SetCondition($condition);
            if($tableName!='' || !empty( $tableName )){
               $this->table = $tableName;
            }           
            $this->db->limit($limit, $start);
            $query = $this->db->get($this->table);          
            return ( $query->num_rows() > 0 ) ? $query->result_array() : false;
        }

        public function insert_auction_data($fileName){    
        	$asd = trim($this->input->post('auction_start'));   
            $ast = trim($this->input->post('auction_start_time'));
            $asdt = $asd.' '.$ast;

            $aed = trim($this->input->post('auction_end'));   
            $aet = trim($this->input->post('auction_finish_time'));            
            $aedt = $aed.' '.$aet;
            $avs = trim($this->input->post('auction_validity_from_date'));   
            $ave = trim($this->input->post('auction_validity_to_date')); 

        	$dataarray = array(
				'material_code' =>trim($this->input->post('material_code')),
				'plant_code' =>trim($this->input->post('plant_code')),
				'material_description' =>trim($this->input->post('material_description')),
				'material_image' =>$fileName,
				'base_url' => base_url('uploads/scraps/'),
				'material_type' =>trim($this->input->post('material_type')),
				'material_weight' =>trim($this->input->post('amount_measure')),
				'auction_start_date' => $asdt,
                'auction_close_date' => $aedt,               	
                'auction_validity_start_date' =>$avs,
				'auction_validity_end_date' =>$ave,				
			);

            //echo "<pre>";print_r($dataarray);die;
			return $this->db->insert('auction',$dataarray);	        
        }

       public function get_auction_details($id){       
       		$query = $this->db->select('*')->where('id',$id)->get('auction')->row_array();
       		//echo $this->db->last_query();die;
       		// echo "<pre>";print_r($query);die;
       		return $query;
        }
		
		public function get_auction_images($id){
           // echo $id;die;
            $query = $this->db->select()->where('auction_id',$id)->get('image_gallery')->result_array();
            return $query; 
         }

        public function get_auction_bids($id){
            //echo $id;die;
            $this->db->select('*,bids.id as bidid');
            $this->db->from('bids'); 
            $this->db->join('auction', 'auction.id=bids.auction_id');
            $this->db->join('users', 'users.id=bids.user_id');
            $this->db->where('auction.id',$id);
            $this->db->where('users.status',1);
            $this->db->order_by('bids.bid_amount','desc');         
            $query = $this->db->get();                                 
            //return $query->row_array() ;                
            return ($query->num_rows() > 0 ) ? $query->result_array() : null;
        }

        function update_auction_info($dataarray,$id){
			//echo "<pre>";print_r($dataarray);die;
        	return  $this->db->where('id',$id)->update('auction',$dataarray);

        }
		
		public function get_auctionList(){
            $curr_date = date('Y-m-d');
            $condition = array(
                'auction_start_date<='=>$curr_date,
               /* 'auction_close_date>='=>$curr_date,*/
                'publish_status'=>1
            );
            $query = $this->db->select('*')->where($condition)->get('auction');
            //echo "<pre>";print_r( $query->result_array());die;
            return $query->result_array();
        }
		
		public function get_device_token($user_id){		
				$query = $this->db->select('*')->from('users')				
				->where('id',$user_id)
				->get();		
				 $data = $query->row_array();				 
				return $data;
		}
		
		public function get_bid_details($auction_id){
			//echo $bid_id;die;
			$this->db->select('*,bids.id as bidid');
            $this->db->from('bids'); 
            $this->db->join('auction','auction.id=bids.auction_id');
            $this->db->join('users', 'users.id=bids.user_id');
            $this->db->where('bids.auction_id',$auction_id);                   
            $query = $this->db->get();
			//echo $this->db->last_query();die;			
			//print_r($query->result_array())	; die;		
			return $query->result_array();           
        }
        
          function getExcel($id){  
            //echo $id;die;       
            $this->db->select('*,bids.id as bidid');
            $this->db->from('bids'); 
            $this->db->join('auction','auction.id=bids.auction_id');
            $this->db->join('users', 'users.id=bids.user_id');
            $this->db->where('bids.auction_id',$id);                   
            $this->db->order_by('bids.bid_amount','desc');                   
            $query = $this->db->get();
            //echo $this->db->last_query();die;         
            //echo "<pre>";print_r($query->result_array())   ; die;      
            return $query->result_array();  

        }

    
    

}

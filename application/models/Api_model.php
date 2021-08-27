<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{
    public $table = 'customers';  // cutomer table for login credentials
    public $primary_key = 'id'; // you MUST mention the primary key
    /**
     * Update a user, password will be hashed
     *
     * @param int id
     * @param array user
     * @return int id
     */


    

    public function check_access_web_app_token($access_token){       
        $condition = array('access_token'=>$access_token);
        $check_access_token = $this->db->select('*')->where($condition)->get('users')->row_array();
        $user = false;
        if ($check_access_token) {
            $user = $check_access_token['id'];
        }
        //print_r($user);die;
        return $user;
    }







    

    
    public function update($id, $user)
    {
        // prevent overwriting with a blank password
        if (isset($user['password']) && $user['password']) {
            $user['password'] = $this->hash($user['password']);
        } else {
            unset($user['password']);
        }

        $this->db->where('id', $id)->update($this->table, $user);
        return $id;
    }

    /**
     * Retrieve a user
     *
     * @param string where
     * @param int value
     * @param string identification field
     */
    public function get($where, $value = FALSE)
    {
        if (!$value) {
            $value = $where;
            $where = 'id';
        }

        $user = $this->db->where($where, $value)->get("users")->row_array();
        return $user;
    }

    /**
     * Check if a user exists
     *
     * @param string where
     * @param int value
     * @param string identification field
     */

 /*   public function exists($where, $value = FALSE)
    {
        if (!$value) {
            $value = $where;
            $where = 'id';
        }

        return $this->db->where($where, $value)->count_all_results($this->table);
    }
*/


  public function exists($where, $value = FALSE)
    {
        if (!$value) {
            $value = $where;
            $where = 'id';
        }

        return $this->db->where($where, $value)->count_all_results("users");
    }


    public function phone_exists($where, $value = FALSE)
        {
            if (!$value) {
                $value = $where;
                $where = 'mobile';
            }

            return $this->db->where($where, $value)->count_all_results("users");
        }

        public function email_exists($where, $value = FALSE)
        {
            if (!$value) {
                $value = $where;
                $where = 'email';
            }

            return $this->db->where($where, $value)->count_all_results("users");
        }


    function _login($username, $password){        
        $this->db->select("*");
        $this->db->limit(1);
        $this->db->where(array("email"=>$username,"password"=>$password));
        $query = $this->db->get("users");
        return ( $query->num_rows() > 0 ) ? $query->row_array() : false;
    }



 public function login($user, $remember = FALSE) {
       
       print_r($user); die;
            // mark user as logged in
            $this->ci->session->set_userdata(array('id' => $user['id'], 'username' => $user['username'], 'email' => $user['email'], 'status' => $user['status'], 'role_type' => $user['role_type'], 'logged_in' => TRUE));

    }


public function logout() {
        // mark user as logged out
        $this->ci->session->set_userdata(array('id' => "", 'username' =>  "", 'email' =>  "", 'status' =>  "", 'role_type' =>  "", 'logged_in' => FALSE));
    }

  
    function _update($table, $data, $condition = array())
    {
        if (count($condition) > 0) {
            $this->db->where($condition);
        }
        if ($this->db->update($table, $data)) {
            return true;
        } else {
            return false;
        }
    }


    function _profile($id)
    {

        if(!empty($id))
            {
              $sql = "select admins.id, admins.name, admins.email, admins.phone, admins.address, admins.status, admins.role_type, admins.created_at, admins.profileicon, admins.username, admins.last_login, admins.ip_address, roles.roll_name from admins left join roles on admins.role_type = roles.role_id where admins.id = ".$id;
               $query = $this->db->query($sql);
               return $query->row_array();
            }  
       else
           {
              $sql = "select admins.id, admins.name, admins.email, admins.phone, admins.address, admins.status, admins.role_type, admins.created_at, admins.profileicon, admins.username, roles.roll_name from admins left join roles on admins.role_type = roles.role_id where admins.role_type  != 1";
               $query = $this->db->query($sql);
               return $query->result();
           }
       

    }

     public function record_count($tableName,$condition)
        {
            SetCondition($condition,false);
            if($tableName!='' || !empty( $tableName )){
                $this->table = $tableName;
            }
            return $this->db->count_all_results( $this->table );
        }
        public function get_records( $tableName, $start, $limit, $condition = array())
        {
            SetCondition($condition);
            if($tableName!='' || !empty( $tableName )){
               $this->table = $tableName;
            }
            $this->db->limit($limit, $start);
            $query = $this->db->get($this->table);
           // echo $this->db->last_query();exit;
            return ( $query->num_rows() > 0 ) ? $query->result_array() : false;
        }
    
    function add_user($user_data)
	{
	   $this->db->insert("users", $user_data);
	   $insert_id = $this->db->insert_id();
	   return  $insert_id;
	}
	
	function get_auction_list($userid,$bidstatus=''){ 
        $curr_date = date('Y-m-d H:i:s');
        /*--$condition = array(
            'auction_start_date<='=>$curr_date,
            'auction_close_date>='=>$curr_date,
            'publish_status'=>1
        );
		*/
        if(empty($bidstatus)){    
            $query_string = "SELECT * FROM auction 
            WHERE id NOT IN (SELECT DISTINCT auction_id FROM bids WHERE user_id='$userid' OR bid_status IN(2,3)) 
            AND DATE_FORMAT(auction_start_date, '%Y-%m-%d %H:%i:%s')<= now()
            AND DATE_FORMAT(auction_close_date, '%Y-%m-%d %H:%i:%s')>= now()
            AND publish_status=1 ORDER BY auction_close_date";                     
        }else{
          
            $query_string = "SELECT * FROM auction 
            WHERE id IN (SELECT auction_id FROM bids WHERE user_id='$userid' AND bid_status='$bidstatus') 
            AND publish_status=1 ORDER BY auction_close_date";           
                     
        }

        $query = $this->db->query($query_string);
        //echo $this->db->last_query();die;
        return $query->result_array();
             
     
    }  
	
	function get_auction_list_old($userid){ 
        $curr_date = date('Y-m-d');
        $condition = array(
            'auction_start_date<='=>$curr_date,
            'auction_close_date>='=>$curr_date,
            'publish_status'=>1
        );

        $query_string = "SELECT * FROM auction 
        WHERE id NOT IN (SELECT auction_id FROM bids WHERE user_id='$userid') 
        AND auction_start_date<= '$curr_date' 
        AND auction_close_date>='$curr_date'
        AND publish_status=1";

        $query = $this->db->query($query_string);
        return $query->result_array();        
     
    }    
	
	 public function auction_detail_get($id){       
       		$query = $this->db->select('*')->where('id',$id)->get('auction');
       		//echo $this->db->last_query();die;
       		///echo "<pre>";print_r($query->row_array());die;
       		return $query->row_array();

        }

    function get_auction_detail($auctionid){
        // echo $auctionid;die;        
        $query = $this->db->select()->where('id',$auctionid)->get('auction');
        return ( $query->num_rows() > 0 ) ? $query->row_array() : null;      
    }
    
    public function get_auction_images($id){
           // echo $id;die;
            $query = $this->db->select('image')->where('auction_id',$id)->get('image_gallery')->result_array();
            return $query; 
    }

    public function check_bid($userid,$auctionid){			
		$query = $this->db->select('*')
						->from('bids')
						->where('user_id',$userid)
						->where('auction_id',$auctionid)
						->get();						
		//echo $this->db->last_query();die;
		//echo $rows;die;
		//print_r($query->result_array());die;
        return $query->result_array();       
    }
	
	public function check_bid_detail_page($userid,$auctionid){	
        //echo 	$auctionid;die;	
		$query = $this->db->select('*')
						->from('bids')
                        ->join('auction','auction.id=bids.auction_id')
						->where('bids.user_id',$userid)
						->where('bids.auction_id',$auctionid)
						->get();
        //print_r($query->row_array());die;        		
        return $query->row_array();   
    }

    public function insert_bid($userid,$auctionid,$bid_amount){
        $data_arr = array('user_id'=>$userid,'auction_id'=>$auctionid,'bid_amount'=>$bid_amount);
        $this->db->insert('bids',$data_arr);
        $insert_id = $this->db->insert_id();
        return $this->db->select()->where('id',$insert_id)->get('bids')->row_array();
    }

    public function check_bid_status($userid,$auctionid){
        $data_arr = array('user_id'=>$userid,'auction_id'=>$auctionid);
        $query = $this->db->select()->where($data_arr)->get('bids')->row_array();
        $status = $query['bid_status'];
        if($status==NULL){
            return NULL;           
        }else{
           return $status;
        }
    }

   

}

/* End of file Project_model.php */
/* Location: ./application/models/Project_model.php */
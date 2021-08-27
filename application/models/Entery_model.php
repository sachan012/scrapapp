<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Entery_model extends CI_Model
{
    public $table = 'staff_entery';
    public $primary_key = 'id'; // you MUST mention the primary key
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update
    
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

        $user = $this->db->where($where, $value)->get($this->table)->row_array();
        return $user;
    }

   
    public function record_count($tableName,$condition)
        {
            //SetCondition($condition,false);
            if($tableName!='' || !empty( $tableName )){
                $this->table = $tableName;
            }
            if(isset($condition['auction_id']) && !empty($condition['auction_id'])){
                         $this->db->where($this->table.'.auction_id',$condition['auction_id']);
               
            }

            
             return $this->db->count_all_results( $this->table );
            //echo $this->db->last_query();exit;
        }

        public function get_records( $tableName, $start, $limit, $condition = array())
        {

           // print_r($condition);die;
           
            if($tableName!='' || !empty( $tableName )){
               $this->table = $tableName;
            }
            if(isset($condition['auction_id']) && !empty($condition['auction_id'])){
                         $this->db->where($this->table.'.auction_id',$condition['auction_id']);
               
            }

            $this->db->limit($limit, $start);
            $query = $this->db->get($this->table);
            //echo $this->db->last_query();exit;
            return ( $query->num_rows() > 0 ) ? $query->result_array() : false;
        }

        function getExcel()
        {
            
            $this->db->select("*")->from("staff_entery")->order_by("id", "DESC");
            $query = $this->db->get();
            return $query->result_array();

        }
        
        
         /**-------Edit new------ */
          // public function get_all_vehiche_entries(){
        //     $query = $this->db->query("select * from auction WHERE id IN(select DISTINCT auction_id FROM staff_entery)");
        //      return $query->result_array();            
        //  }


        public function get_all_vehiche_entries($id=''){
            if(empty($id)){               
                $query = $this->db->select('*')->from('staff_entery')
                        ->join('auction','auction.id=staff_entery.auction_id')                       
                        ->get();               
            }else{
                $query = $this->db->select('*')->from('staff_entery')
                        ->join('auction','auction.id=staff_entery.auction_id')
                        ->where('staff_entery.auction_id',$id)
                        ->get();
            }          

            return $query->result_array();
            
        }



}

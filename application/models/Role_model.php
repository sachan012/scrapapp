<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public $table = 'roles';

    /**
     * Update a user, password will be hashed
     *
     * @param int id
     * @param array user
     * @return int id
     */
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

        $user = $this->db->where($where, $value)->get($this->table)->row_array();
        return $user;
    }

    /**
     * Check if a user exists
     *
     * @param string where
     * @param int value
     * @param string identification field
     */

    public function exists($where, $value = FALSE)
    {
        if (!$value) {
            $value = $where;
            $where = 'id';
        }

        return $this->db->where($where, $value)->count_all_results($this->table);
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
    

}

/* End of file Project_model.php */
/* Location: ./application/models/Project_model.php */
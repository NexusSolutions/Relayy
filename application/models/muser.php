<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 1/7/15
 * Time: 9:35 PM
 */

define('USERTYPE_ADMIN', 1);
define('USERTYPE_ADVISOR',   2);
define('USERTYPE_EXPERT',  3);

define('USERSTATUS_INIT',    0);
define('USERSTATUS_LIVE',       1);
define('USERSTATUS_INVITE',    2);
define('USERSTATUS_INVITED',    3);

class Muser extends CI_Model {

    var $id;
    var $fname;
    var $password;
    var $type;
    var $status;
    var $email;
    var $photo;
    var $phone;
    var $facebook;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function insertUser(
        $id,
        $fname,
        $password,
        $type,
        $status,
        $email,
        $photo,
        $phone,
        $facebook)
    {
        $data = array(
            'uid'        => $id,
            'fname'      => $fname,
            'pwd'        => $password,
            'email'      => $email,
            'photo'      => $photo,
            'status'     => $status,
            'type'       => $type,
            'phone'       => $phone,
            'facebook'   => $facebook
        );

        $this->db->insert('tbl_user', $data);

        $id = $this->db->insert_id();

        return (isset($id)) ? $id : FALSE;
    }

    public function getUserlist($status = USERSTATUS_INIT)
    {
        if ($status == 100) {
            $query = $this->db->select('uid, fname, pwd, type, status, email, photo, phone, facebook')
                          ->get('tbl_user');
        } else {
            $query = $this->db->select('uid, fname, pwd, type, status, email, photo, phone, facebook')
                          ->where('status', $status)
                          ->get('tbl_user');
        }

        return $query->result_array();

    }

    public function getUser($user_id)
    {
        $query = $this->db->select('uid, fname, pwd, type, status, email, photo, phone, facebook')
                          ->where('uid', $user_id)
                          ->limit(1)
                          ->get('tbl_user');

        if ($query->num_rows() === 1)
        {
            $user = $query->row();

            $user_one = new Muser();
        
            $user_one->id = $user->uid;
            $user_one->fname = $user->fname;
            $user_one->password = $user->pwd;
            $user_one->type = $user->type;
            $user_one->status = $user->status;
            $user_one->email = $user->email;
            $user_one->photo = $user->photo;
            $user_one->phone = $user->phone;
            $user_one->facebook = $user->facebook;

            return $user_one;

        }

        return FALSE;
    }

    public function editUser($id, $fname, $email, $password, $type, $phone)
    {
        $data = array(
            'fname' => $fname,
            'email' => $email,
            'pwd' => $password,
            'type' => $type,
            'phone' => $phone
        );

        $this->db->update('tbl_user', $data, array('uid' => $id));

        return $this->getUser($id);
    }

    public function changeStatus($user_id)
    {
        $user = $this->getUser($user_id);

        if ($user->status == USERSTATUS_INIT) {
            $data = array(
                'status' => USERSTATUS_LIVE
            );

            $this->db->update('tbl_user', $data, array('uid' => $user_id));            
        } else {
            $data = array(
                'status' => USERSTATUS_INIT
            );

            $this->db->update('tbl_user', $data, array('uid' => $user_id));            
        }
    }

    public static function deleteUser($user_id)
    {

    }

    public static function resetPassword($emailAddress, $password)
    {

    }

    public function login($email, $password)
    {

        //$query = $this->db->select('uid, fname, pwd, type, status, email, photo')
        $query = $this->db->select('uid, fname, pwd, type, status, email, photo, facebook')
                          ->where('email', $email)
                          ->limit(1)
                          ->get('tbl_user');

        if ($query->num_rows() === 1)
        {
            $user = $query->row();

            $pwd = $user->pwd;


            if ($password == $pwd)
            {
                $user_one = new Muser();
            
                $user_one->id = $user->uid;
                $user_one->fname = $user->fname;
                $user_one->password = $user->pwd;
                $user_one->type = $user->type;
                $user_one->status = $user->status;
                $user_one->email = $user->email;
                $user_one->photo = $user->photo;
                $user_one->facebook = $user->facebook;

                return $user_one;
            }
        }

        return FALSE;
    }

    public function register($id, $fname, $email, $pwd, $type, $facebook) {

        $newUser = $this->getUser($id);

        if (!$newUser)
        {
            $newUser = $this->insertUser($id, $fname, $pwd, $type, USERSTATUS_INIT, $email, '', $facebook);    
        }
        

        if ($newUser) 
        {
            $user_one = new Muser();
            
            $user_one->id = $id;
            $user_one->fname = $fname;
            $user_one->password = $pwd;
            $user_one->type = $type;
            $user_one->status = USERSTATUS_INIT;
            $user_one->email = $email;
            $user_one->photo = '';
            $user_one->facebook = $facebook;

            return $user_one;
        }

        return FALSE;
    }
}
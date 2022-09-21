<?php  




class User extends Db_object {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'user_password', 'user_firstname', 'user_lastname', 'user_image');

public $id;
public $username;
public $user_password;
public $user_firstname;
public $user_lastname;
public $user_image;
public $upload_directory = "images";
public $image_placeholder = "http://placehold.it/400x400&text=image";

public $tmp_path;



public function image_path_and_placeholder() {
    return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS. $this->user_image;
}


public static function verify_user($username, $user_password) {
    global $database;

    $username = $database->escape_string($username);
    $user_password = $database->escape_string($user_password);

    $sql = "SELECT * FROM ". self::$db_table." WHERE ";  // позднее статическое связывание. произошло переопределение свойства $db_table
    $sql .= "username = '{$username}' ";
    $sql .= "AND user_password = '{$user_password}' ";
    $sql .= "LIMIT 1 ";

    $the_result_array = self::find_by_query($sql);

    return !empty($the_result_array) ? array_shift($the_result_array) : false;
}



public function save_user_and_image() {
 
    
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = "the file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
      

        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }

        if(move_uploaded_file($this->tmp_path, $target_path)) {
            if($this->update()) {
                unset($this->tmp_path);
                return true;
            }
        } else {
            $this->errors[] = "the file directory probably does not have permission";
            return false;
        }
    
    
}


        public function ajax_save_user_image($user_image, $user_id) {

            global $database;

            $user_image = $database->escape_string($user_image);
            $user_id = $database->escape_string($user_id);

            $this->user_image = $user_image;
            $this->id         = $user_id;
           
            $sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
            $sql .= " WHERE id = '{$this->id}' ";
            $update_image = $database->query($sql);

            echo $this->image_path_and_placeholder();
        }


        public function delete_photo() {

            if($this->delete()) {
                $target_path = SITE_ROOT.DS. 'admin' . DS . $this->upload_directory. DS. $this->user_image;
                return  unlink($target_path) ? true : false;
            
            } else {
                return false;
            }
        }


        public function photos() {
            return Photo::find_by_query("SELECT * FROM photos WHERE user_id =" . $this->id);
        }

}


?>
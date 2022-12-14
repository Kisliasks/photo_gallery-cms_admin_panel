<?php 




class Db_object {

    protected static $db_table = "";
    protected static $db_table_fields = array();

    public $errors = array();
    public $upload_errors_array = array(

        UPLOAD_ERR_OK => "Ошибок не возникло, файл был успешно загружен на сервер.",
        UPLOAD_ERR_INI_SIZE => "Размер принятого файла превысил максимально допустимый размер.",
        UPLOAD_ERR_FORM_SIZE => "Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.",
        UPLOAD_ERR_PARTIAL => "Загружаемый файл был получен только частично.",
        UPLOAD_ERR_NO_FILE => "Файл не был загружен.",
        UPLOAD_ERR_NO_TMP_DIR => "Отсутствует временная папка.",
        UPLOAD_ERR_CANT_WRITE => "Не удалось записать файл на диск.",
        UPLOAD_ERR_EXTENSION => "Модуль PHP остановил загрузку файла."
    
    );


    public function set_photo($file) {

        if(empty($file) || !$file || !is_array($file)) {     // если файл пустой или его нет
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif($file['error'] !=0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }  
    }
    
   



    public static function find_all() {

        return static::find_by_query("SELECT * FROM " . static::$db_table." ");
               
        }
        
        public static function find_by_id($id) {
        global $database;
        
        $the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table." WHERE id = $id  LIMIT 1");
        
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
            
        }

        
        public static function find_by_query($sql) { // результат запроса в базу данных

            global $database;
            
            $result_set = $database->query($sql);
            $the_object_array = array();
            
            while($row = mysqli_fetch_array($result_set)) {
            
            $the_object_array[] = static::instantation($row);      // эта функция перебрала все значения массива и внедрила в $the_object_array
            }
            
            return $the_object_array; // итог данной фанукции - возврат всех элементов запроса 
            
            }





            public static function instantation($the_record) {      // получение нужной строки из таблицы users с параметром подключения к этой таблице

                $calling_this_class = get_called_class();

                $the_object = new $calling_this_class;
                
               
            foreach ($the_record as $the_attribute => $value) {
                
                if($the_object->has_the_attribute($the_attribute)) {
            
                    $the_object->$the_attribute = $value;
                }
            }
            
                return $the_object;
            }
    
            private function has_the_attribute($the_attribute) {

                $object_properties = get_object_vars($this);
            
                return array_key_exists($the_attribute, $object_properties);
            
            }


            protected function properties() {

                // return get_object_vars($this);
                $properties = array();
                 foreach (static::$db_table_fields as $db_field) {
                     if(property_exists($this, $db_field)) {
                         $properties[$db_field] = $this->$db_field;
                     }
                 }
                 return $properties;
                }
                



            protected function clean_properties() {
                global $database;
            
                $clean_properties = array();
                foreach ($this->properties() as $key => $value) {
                    $clean_properties[$key] = $database->escape_string($value);
                }
                return $clean_properties;
            }


    public function save() {

        return isset($this->id) ? $this->update() : $this->create();
        }
        
        
        public function create() {
            global $database;
        
            $properties = $this->clean_properties();
        
            $sql = "INSERT INTO ". static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
            $sql .= "VALUES ('". implode("','", array_values($properties)) ."') LIMIT 1 ";
            
            if($database->query($sql)) {
                $this->id = $database->the_insert_id();
                return true;
            } else {
                return false;
            }
        }
        
        
        
        public function update() {
            global $database;
        
            $properties = $this->clean_properties();
            $properties_pairs = array();
            foreach ($properties as $key => $value) {
                $properties_pairs[] = "{$key}='{$value}'";
            }
        
            $sql = "UPDATE ". static::$db_table . " SET ";
            $sql .= implode(",", $properties_pairs);
            $sql .= " WHERE id= " . $database->escape_string($this->id); 
        
            $database->query($sql);
        
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        }
        
        
        
        public function delete(){
            global $database;
        
            $sql = "DELETE FROM ". static::$db_table." WHERE id = " . $database->escape_string($this->id). " LIMIT 1"; 
            $database->query($sql);
        
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        }
        
        
        public static function count_all() {
            global $database;
            $sql = "SELECT COUNT(*) FROM " . static::$db_table;
            $result_set = $database->query($sql);
            $row = mysqli_fetch_array($result_set);
            return array_shift($row);
        }
                
}


?>
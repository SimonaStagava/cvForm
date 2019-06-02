<?php

class Connection extends Db
{
    public $last_id;

    public function createDataTable()
    {
        $create = $this->dataTable();
        return $create;
    }

    public function createSchoolTable()
    {
        $create = $this->schoolTable();
        return $create;
    }

    public function createLangTable()
    {
        $create = $this->langTable();
        return $create;
    }

    public function createImageTable()
    {
        $create = $this->imageTable();
        return $create;
    }

    public function createPdfTable()
    {
        $create = $this->pdfTable();
        return $create;
    }

    protected function insertData()
    {
        $name = $_POST['name'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $email = $_POST['email'];

        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $query = "INSERT INTO user_data (name, birth_day, birth_month, birth_year, email) VALUES 
            (:name, :birth_day, :birth_month, :birth_year, :email)";

            $stmt = $conn->prepare($query);
            $stmt->execute(array(':name'=>$name, ':birth_day'=>$day, ':birth_month'=>$month, ':birth_year'=>$year, ':email'=>$email));
            
            $this->last_id = $conn->lastInsertId();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function insertSchool()
    {
        $school = $_POST['school'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $profession = $_POST['profession'];

        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach ($school as $key => $value) {
                $query = "INSERT INTO school (id, school, year_from, year_to, profession) VALUES (:id, :school, :year_from, :year_to, :profession)";
    
                $stmt = $conn->prepare($query);
    
                $stmt->execute(array(':id'=>$this->last_id, ':school'=>$school[$key], ':year_from'=>$from[$key], ':year_to'=>$to[$key], ':profession'=>$profession[$key]));
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function insertLang()
    {
        $language = $_POST['lang'];
        $speak = $_POST['speak'];
        $read = $_POST['read'];
        $write = $_POST['write'];

        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach ($language as $key => $value) {
                $query = "INSERT INTO lang (id, language, speaking, reading, writing) VALUES (:id, :language, :speak, :read, :write)";
    
                $stmt = $conn->prepare($query);
    
                $stmt->execute(array(":id"=>$this->last_id, ":language"=>$language[$key], ":speak"=>$speak[$key], ":read"=>$read[$key], ":write"=>$write[$key]));
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function insertImage()
    {
        $image_name = $_FILES["photo"]["name"] ? $_FILES["photo"]["name"] : "";
        $image_data = "";

        if (empty($_FILES["photo"]["name"])) {
            $image_data = "";
        } else {
            $image_data = file_get_contents($_FILES["photo"]["tmp_name"]);
        }

        try {
            $conn = new PDO($this->dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO images (id, img_name, image) VALUES (:id, :name, :image)";
    
            $stmt = $conn->prepare($query);
    
            $stmt->execute(array(':id'=>$this->last_id, ':name'=>$image_name, ':image'=>$image_data));
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function data() {

        $insert = $this->insertData();
        return $insert;
    }

    public function school() {

        $insert = $this->insertSchool();
        return $insert;
    }

    public function lang() {

        $insert = $this->insertLang();
        return $insert;
    }

    public function img() {

        $insert = $this->insertImage();
        return $insert;
    }
}

?>

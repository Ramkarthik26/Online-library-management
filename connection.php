<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'library';
    private $username = 'root';
    private $password = '';
    public $db;

    public function __construct()
    {
        $this->connect();
    }
    private function connect()
    {
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        if($this->db->connect_error)
        {
            die("Error Failed:" . $this->db->connect_error);
        }
    }
}
$conn = new Database;
$db = $conn->db;
?>

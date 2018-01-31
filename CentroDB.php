<?php
class CentroDB {

    protected $mysqli;
    const LOCALHOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = 'root';
    const DATABASE = 'fpmislata';

    public function __construct() {
        try{
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        }catch (mysqli_sql_exception $e){
            http_response_code(500);
            exit;
        }
    }

    public function getCentro($id=0){
        $stmt = $this->mysqli->prepare("SELECT * FROM centros WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $centro = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $centro;
    }


    public function getCentros(){
        $result = $this->mysqli->query('SELECT * FROM centros');
        $centros = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $centros;
    }


    public function insert($name='', $direction='', $telephone=0){
        $stmt = $this->mysqli->prepare("INSERT INTO centros(name, direction, telephone) VALUES (?, ?, ?, ?); ");
        $stmt->bind_param('sss', $name, $direction, $telephone);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


    public function delete($id=0) {
        $stmt = $this->mysqli->prepare("DELETE FROM centros WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


	public function update($id=0, $newName='', $newDirection='', $newTelephone=0) {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE people SET name=?, direction=?, telephone=? WHERE id = ? ; ");
            $stmt->bind_param('ssss', $id, $newName, $newDirection, $newTelephone);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }


	public function checkID($id){
        $stmt = $this->mysqli->prepare("SELECT * FROM centros WHERE ID = ?");
        $stmt->bind_param("s", $id);
        if($stmt->execute()){
            $stmt->store_result();
            if ($stmt->num_rows == 1){
                return true;
            }
        }
        return false;
    }

}

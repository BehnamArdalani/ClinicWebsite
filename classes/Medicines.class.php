<?php
class Medicines {

    protected $id;
    protected $medicine_name;

    public static function create($medicine_name)
    {
        $instance = new self();
        $instance->id = null;
        $instance->medicine_name = $medicine_name;
        
        return $instance;
    }

    public function save(){
        $saveArray = array(
            "medicine_name"=>$this->medicine_name,
            "id"=>$this->id);

        return DBContext::SaveMedicine($saveArray);
    }
/*
    public function delete($id){
        return DBContext::DeleteMedicinesById($id);
    }
*/

    public function getId(){
        return $this->id;
    }
    
    public function getMedicineName(){
        return $this->medicine_name;
    }
    
    public function setMedicineName($medicine_name){
        $this->medicine_name = $medicine_name;
    }

    

}

?>
<?php
class Patient {

    protected $id;
    protected $patient_name;
    protected $address;
    protected $cnic;
    protected $date_of_birth;
    protected $phone_number;
    protected $gender;

    public static function create($patient_name,$address,$cnic,$date_of_birth,$phone_number,$gender)
    {
        $instance = new self();
        $instance->id = null;
        $instance->patient_name = $patient_name;
        $instance->address = $address;
        $instance->cnic = $cnic;
        $instance->date_of_birth = $date_of_birth;
        $instance->phone_number = $phone_number;
        $instance->gender = $gender;

        return $instance;
    }

    public function save(){
        $saveArray = array(
            "patient_name"=>$this->patient_name,
            "address"=>$this->address,
            "cnic"=>$this->cnic,
            "date_of_birth"=>$this->date_of_birth,
            "phone_number"=>$this->phone_number,
            "gender"=>$this->gender,
            "id"=>$this->id);

        return DBContext::SavePatient($saveArray);
    }

    public function getId(){
        return $this->id;
    }
    
    public function getPatientName(){
        return $this->patient_name;
    }
    
    public function setPatientName($patient_name){
        $this->patient_name = $patient_name;
    }

    

}

?>
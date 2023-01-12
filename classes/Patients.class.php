<?php
class Patients {

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

    public function getAddress(){
        return $this->address;
    }
    
    public function setAddress($address){
        $this->address = $address;
    }

    public function getCnic(){
        return $this->cnic;
    }
    
    public function setCnic($cnic){
        $this->cnic = $cnic;
    }

    public function getDateOfBirth(){
        return $this->date_of_birth; 
        //return $this->date_of_birth->format("Y-m-d");
    }
    
    public function setDateOfBirth($date_of_birth){
        $this->date_of_birth = $date_of_birth;
    }

    public function getPhoneNumber(){
        return $this->phone_number;
    }
    
    public function setPhoneNumber($phone_number){
        $this->phone_number = $phone_number;
    }

    public function getGender(){
        return $this->gender;
    }
    
    public function setGender($gender){
        $this->gender = $gender;
    }
}

?>
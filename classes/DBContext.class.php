<?php

class DBContext extends DBHandler{

    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        self::$initialized = true;
    }

    public static function getDB(){
        self::initialize();
        return self::DB();
    }

    public static function Search($tableName, $whereClause = null){
        self::initialize();
        $query = "SELECT * FROM {$tableName} ";
        if(!is_null($whereClause)){
            $query .= " Where ";
            foreach($whereClause as $key=>$value){
                if (gettype($value) == "integer" || gettype($value) == "double"){
                    $query .= " {$key} = {$value} ";
                } elseif(gettype($value) == "boolean"){
                    $intBool = intval($value);
                    $query .= " {$key} = {$intBool} ";
                }
                elseif(gettype($value) == "string" && str_contains($value,"between")){
                    $query .= " {$key} {$value} ";
                } elseif(gettype($value) == "string"){
                    $query .= " {$key} like '%{$value}%' ";
                }
                $query .= " and ";
            }
            $query = substr($query,0,-5);

        }

        $statement = self::DB()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS,"{$tableName}");
        return $result;
    }

    public static function SavePatient($saveArray){
        self::initialize();
        if(!isset($saveArray["id"])){
            $statement = self::DB()->prepare("INSERT INTO Patients (patient_name,address,cnic,date_of_birth,phone_number,gender,id) VALUES (?,?,?,str_to_date(?,'%m/%d/%Y'),?,?,?) ");
            $result = $statement->execute(array_values($saveArray));
        } else {
            $statement = self::DB()->prepare("UPDATE Patients SET patient_name = ? , address = ? , cnic = ? , date_of_birth = str_to_date(?,'%m/%d/%Y') , phone_number = ? , gender = ? WHERE id = ? ");
            $result = $statement->execute(array_values($saveArray));
        }
        
        return $result;
    }

    public static function SaveMedicine($saveArray){
        self::initialize();
        if(!isset($saveArray["id"])){
            $statement = self::DB()->prepare("INSERT INTO Medicines (medicine_name, id) VALUES (?,?) ");
            $result = $statement->execute(array_values($saveArray));
        } else {
            $statement = self::DB()->prepare("UPDATE Medicines SET medicine_name = ?  WHERE id = ? ");
            $result = $statement->execute(array_values($saveArray));
        }
        
        return $result;
    }

    public static function SaveUser($saveArray){
        self::initialize();
        if(!isset($saveArray["id"])){
            $statement = self::DB()->prepare("INSERT INTO Users (display_name, user_name, password, profile_picture, id) VALUES (?,?,?,?,?) ");
            $result = $statement->execute(array_values($saveArray));
        } else {
            $statement = self::DB()->prepare("UPDATE Users SET display_name = ? , user_name = ? , password = ? , profile_picture = ? WHERE id = ? ");
            $result = $statement->execute(array_values($saveArray));
        }
        
        return $result;
    }

    


}

?>
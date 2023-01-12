<?php
class Users {

    protected $id;
    protected $display_name;
    protected $user_name;
    protected $password;
    protected $profile_picture;

    public static function create($display_name,$user_name,$password,$profile_picture)
    {
        $instance = new self();
        $instance->id = null;
        $instance->display_name = $display_name;
        $instance->user_name = $user_name;
        $instance->password = $password;
        $instance->profile_picture = $profile_picture;

        return $instance;
    }
    
    public function save(){
        $saveArray = array(
            "display_name"=>$this->display_name,
            "user_name"=>$this->user_name,
            "password"=>$this->password,
            "profile_picture"=>$this->profile_picture,
            "id"=>$this->id);

        return DBContext::SaveUser($saveArray);
    }


    public function getId(){
        return $this->id;
    }
    
    public function getUsername(){
        return $this->user_name;
    }

    public function setUsername($user_name){
        $this->user_name = $user_name;
    }

    public function gePassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getDisplayName(){
        return $this->display_name;
    }

    public function setDisplayName($display_name){
        $this->display_name = $display_name;
    }

    public function getProfilePicture(){
        return $this->profile_picture;
    }

    public function setProfilePicture($profile_picture){
        $this->profile_picture = $profile_picture;
    }

}

?>
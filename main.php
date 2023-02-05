<?php

include_once 'components/tools.php';

class Main{

    private $dev;
    private $users;

    // CONSTRUCTOR - EXECUTES ON PROGRAM STARTUP

    public function __construct($argc,$argv)
    {
        if($argc>1 && $argv[1]=='dev'){
            //$this->testInfo();
            $this->dev=true;
            $this->testInfo();
        }else{
            $this->dev=false;
        }
        $this->greetingMessage();
        $this->mainMenu();
    }

    // GREETING MESSAGE

    private function greetingMessage(){
        echo '-------------------------------------' . PHP_EOL;
        echo ' Welcome to BlueFreedom Terminal APP ' . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
    }

    // MAIN MENU

    private function mainMenu(){
        echo '---------------' . PHP_EOL;
        echo '   MAIN MENU   ' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        echo '1. USERS' . PHP_EOL;
        echo '2. POSTS' . PHP_EOL;
        echo '3. FRIENDSHIPS' . PHP_EOL;
        echo '4. POST LIKES' . PHP_EOL;
        echo '5. EXIT PROGRAM' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        $this->mainMenuChooser();
    }

    // OPTION CHOOSER FOR MAIN MENU

    private function mainMenuChooser(){
        switch(Tools::numberRange('Option: ',1,5)){
            case 5:
                echo '-----------' . PHP_EOL;
                echo ' Goodbye ! ' . PHP_EOL;
                echo '-----------' . PHP_EOL;
                break;
            case 1:
                $this->usersMenu();
                break;
            default:
            echo 'NOT IMPLEMENTED YET !' . PHP_EOL;
            $this->mainMenu();
            break;
        }
    }

    // USER MANIPULATION MENU

    private function usersMenu(){
        echo '---------------' . PHP_EOL;
        echo '  USERS MENU   ' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        echo '1. READ' . PHP_EOL;
        echo '2. CREATE' . PHP_EOL;
        echo '3. UPDATE' . PHP_EOL;
        echo '4. DELETE' . PHP_EOL;
        echo '5. GO BACK' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        $this->usersChooser();
    }

    // OPTION CHOOSER FOR USER MANIPULATION MENU
    private function usersChooser(){
        switch(Tools::numberRange('Option: ',1,5)){
            case 5:
                $this->mainMenu();
                break;
            case 2:
                $this->createNewUser();
                break;
            case 1:
                if(count($this->users)===0){
                    echo 'No users in APP' . PHP_EOL;
                    $this->usersMenu();
                } else{
                $this->readUsers();
                }
                break;
            case 3:
                if(count($this->users)===0){
                    echo 'No users in APP' . PHP_EOL;
                    $this->usersMenu();
                }else{
                    $this->editUser();
                }
                break;
            case 4:
                if(count($this->users)===0){
                    echo 'No users in APP' . PHP_EOL;
                    $this->usersMenu();
                } else{
                $this->deleteUser();
                }
                break;
        }
    }

    // FUNCTION FOR MANUAL USER CREATION

    private function createNewUser(){
        $u = new stdClass();
        $u->fname = Tools::textInput('First name: ');
        $u->lname = Tools::textInput('Last name: ');
        $u->email = Tools::textInput('E-mail: ');
        $u->password = Tools::textInput('Password: ');
        $this->users[]=$u;
        echo '-----------' . PHP_EOL;
        echo ' SUCCESS ! ' . PHP_EOL;
        $this->usersMenu();
    }

    // FUNCTION FOR DISPLAYING USERS IN APP

    private function readUsers($showMenu=true){
        echo '------------------' . PHP_EOL;
        echo '      USERS :     ' . PHP_EOL;
        echo '------------------' . PHP_EOL;
        $usc=1;
        foreach($this->users as $users){
            echo $usc++ . '. ' . $users->fname . ' ' . $users->lname . PHP_EOL;
            if($this->dev===true) { echo $users->email . ':' . $users->password . PHP_EOL; }
        }
        echo '------------------' . PHP_EOL;
        if($showMenu){
            $this->usersMenu();
        }
    }

    // FUNCTION FOR EDITING USER INFORMATION

    private function editUser(){
        $this->readUsers(false);
        $rd = Tools::numberRange('Choose user: ',1,count($this->users));
        $rd--;
        $this->users[$rd]->fname = Tools::textInput('First name (' . $this->users[$rd]->fname .'): ', $this->users[$rd]->fname);
        $this->users[$rd]->lname = Tools::textInput('Last name (' . $this->users[$rd]->lname .'): ', $this->users[$rd]->lname);
        $this->users[$rd]->email = Tools::textInput('E-mail (' . $this->users[$rd]->email .'): ', $this->users[$rd]->email);
        $this->users[$rd]->password = Tools::textInput('Password (' . $this->users[$rd]->password .'): ', $this->users[$rd]->password);
        echo '--------------' . PHP_EOL;
        echo '   SUCCESS !  ' . PHP_EOL;
        $this->usersMenu();
    }

    // FUNCTION FOR DELETING USER

    private function deleteUser(){
        $this->readUsers(false);
        $ra = Tools::numberRange('Choose user: ',1,count($this->users));
        $ra--;
        array_splice($this->users,$ra,1);
        echo '--------------' . PHP_EOL;
        echo '   SUCCESS !  ' . PHP_EOL;
        $this->usersMenu();
    }

    // DEV FUNCTION FOR EXAMPLE USER INFO (SO THAT DEVELOPERS DO NOT NEED TO MANUALLY ADD USERS EVERY TIME APP IS CALLED)
    private function testInfo(){
        $this->users[] = $this->createUser('Ivan','Ivanovič','ivan@example.com','samplepw');
        $this->users[] = $this->createUser('Mirta','Martac','mirta@example.com','mrita123');
        $this->users[] = $this->createUser('Janko','Jaković','janko@example.com','jasamjanko');
    }

    // AUTOMATIC FUNCTION TO CREATE USERS - TYPICALLY FOR TESTINFO FUNCTION
    private function createUser($fname,$lname,$email,$password){
        $u = new stdClass();
        $u->fname = $fname;
        $u->lname = $lname;
        $u->email = $email;
        $u->password = $password;
        return $u;
    }

}

new Main($argc,$argv);

?>
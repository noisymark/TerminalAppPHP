<?php

include_once 'components/tools.php';

class Main{

    private $dev;
    private $users=[];

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
            case 2:
                $this->postsMenu();
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

    // POSTS MANIPULATION MENU
    private function postsMenu(){
        echo '---------------' . PHP_EOL;
        echo '  POSTS MENU   ' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        echo '1. READ' . PHP_EOL;
        echo '2. CREATE' . PHP_EOL;
        echo '3. UPDATE' . PHP_EOL;
        echo '4. DELETE' . PHP_EOL;
        echo '5. GO BACK' . PHP_EOL;
        echo '---------------' . PHP_EOL;
        $this->postsChooser();
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
                if((count($this->users))===0){
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

    // OPTION CHOOSER FOR POSTS MANIPULATION MENU

    private function postsChooser(){
        switch(Tools::numberRange('Option: ',1,5)){
            case 5:
                $this->mainMenu();
                break;
            case 1:
                $this->readPosts();
                break;
            case 2:
                $this->createNewPost();
                break;
            case 3:
                $this->editPost();
                break;
            case 4:
                $this->deletePost();
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

    // FUNCTION FOR MANUAL POST CREATION

    private function createNewPost(){
        if((count($this->users))===0){echo 'CREATE AN USER FIRST !' . PHP_EOL; $this->postsMenu();} else{
        $this->readUsers(false);
        $ww = Tools::numberRange('Choose user: ',1,count($this->users));
        $ww--;
        $o = new stdClass();
        $o->postname = Tools::textInput('Name of the post: ');
        $o->postdesc = Tools::textInput('Enter the description: ');
        $this->users[$ww]->post[] = $o;
        echo '-----------' . PHP_EOL;
        echo ' SUCCESS ! ' . PHP_EOL;
        $this->postsMenu();
    }
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

    // FUNCTION FOR DISPLAYING POSTS IN APP

    private function readPosts($showMenu=true){
        if(count($this->users)!==0){
        echo '--------------------------' . PHP_EOL;
        echo 'SELECT USER TO VIEW POSTS:' . PHP_EOL;
        $this->readUsers(false);
        $rr = Tools::numberRange('Choose user: ',1,count($this->users));
        $rr--;
        if(isset($this->users[$rr]->post)){$rw=$this->users[$rr]->post;}else{$rw=null;}
        if($rw===null || count($rw)===0){
            echo 'THIS USER HAS NO POSTS !' . PHP_EOL;
            echo '--------------------------' . PHP_EOL;
            $this->postsMenu();
        } else{
        $csu=1;
        foreach($this->users[$rr]->post as $posts){
            echo $csu++ . '. ' . 'PostName: ' .$posts->postname . "\n" . '   Description: ' . $posts->postdesc . PHP_EOL;
        }
        echo '------------';
        if($showMenu){
            $this->postsMenu();
        }
        }

        } else{
        echo 'CREATE AN USER FIRST !' . PHP_EOL; $this->postsMenu();
        }
        return $rr;
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

    // FUNCTION FOR EDITING POST INFORMATION

    private function editPost($edit=true){
        $rr = $this->readPosts(false);
        echo '' . PHP_EOL;
        $ww = Tools::numberRange('Choose post: ',1,count($this->users[$rr]->post));
        $ww--;
        if($edit){
        $this->users[$rr]->post[$ww]->postname = Tools::textInput('Post name ('.$this->users[$rr]->post[$ww]->postname.'): ',$this->users[$rr]->post[$ww]->postname); 
        $this->users[$rr]->post[$ww]->postdesc = Tools::textInput('Post description ('.$this->users[$rr]->post[$ww]->postdesc.'): ',$this->users[$rr]->post[$ww]->postdesc); 
        echo '--------------' . PHP_EOL;
        echo '   SUCCESS !  ' . PHP_EOL;
        $this->postsMenu();
        }
        return $ww;
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

    private function deletePost(){
        $rr = $this->readPosts(false); // USER ID
        echo '' . PHP_EOL;
        $ww = Tools::numberRange('Choose post: ',1,count($this->users[$rr]->post));
        $ww--; // POST ID
        array_splice($this->users[$rr]->post,$ww,1);
        echo '--------------' . PHP_EOL;
        echo '   SUCCESS !  ' . PHP_EOL;
        $this->postsMenu();
    }

    // DEV FUNCTION FOR EXAMPLE USER INFO (SO THAT DEVELOPERS DO NOT NEED TO MANUALLY ADD INFO EVERY TIME APP IS CALLED)
    private function testInfo(){
        $this->users[] = $this->createUser('Ivan','Ivanovič','ivan@example.com','samplepw');
        $this->users[] = $this->createUser('Mirta','Martac','mirta@example.com','mrita123');
        $this->users[] = $this->createUser('Janko','Jaković','janko@example.com','jasamjanko');

        $this->users[0]->post[] = $this->createPost('Test1','Desc1');
        $this->users[1]->post[] = $this->createPost('Test2','Desc2');
        $this->users[2]->post[] = $this->createPost('Test3','Desc3');
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

    // AUTOMATIC FUNCTION TO CREATE POSTS - TYPICALLY FOR TESTINFO FUNCTION
    private function createPost($postname,$postdesc){
        $o = new stdClass();
        $o->postname=$postname;
        $o->postdesc=$postdesc;
        return $o;
    }

}

new Main($argc,$argv);

?>
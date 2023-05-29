<?php 

namespace App\Tests\Entity;



use App\Entity\User;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
   private $username = "username";
   private $email = "email@gmail.com";
   private $password = "123456";
   private $roles = ['ROLE_USER'];
  

    public function testGetterUser() : Void
    {

       
        
        $user = new User();
        $user->setUsername($this->username);
        $user->setEmail($this->email);
        $user->setpassword($this->password);
        $user->setRoles($this->roles);
        
        $this->assertNull($user->getId());
        $this->assertEquals($this->username, $user->getUsername());
        $this->assertEquals($this->email, $user->getEmail());
        $this->assertEquals($this->password, $user->getPassword());
        $this->assertEquals($this->roles, $user->getRoles());
    }
   

}
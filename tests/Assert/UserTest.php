<?php 

namespace App\Tests\Assert;



use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{
    private const NOT_VALID_EMAIL_MESSAGE = 'Email non valide';
    private const INVALID_EMAIL_VALUE =" code@gmail";
    private const PASSWORD_CONSTRAINT_MESSAGE = "Votre mot de passe doit avoir au minimum 6 caractères";
    private const VALID_EMAIL = "code1@gmail.com";
    private const PASSWORD_VALID = "123456";
    private const PASSWORD_INVALID = "12345";

  

    public function getValidate( User $user,int $number )
    {
        self::bootKernel();
        $container = static::getContainer();

        $error = $container->get('validator')->validate($user);
        $this->assertCount($number,$error);
        return $error;
    }

    public function testUserValid()
    {
        $user = new User();

        $user 
            ->setEmail(self::VALID_EMAIL)
            ->setPassword(self::PASSWORD_VALID);

        $this->getValidate( $user , 0);
            
    }

    public function testUserInvalidEmail()
    {
        $user = new User();

        $user 
            ->setEmail(self::INVALID_EMAIL_VALUE)
            ->setPassword(self::PASSWORD_VALID);

      $errors = $this->getValidate($user , 1);
       $this->assertEquals(self::NOT_VALID_EMAIL_MESSAGE, $errors[0]->getMessage());
            
    }

    public function testUserInvalidPassword()
    {
        $user = new User();

        $user 
            ->setEmail(self::VALID_EMAIL)
            ->setPassword(self::PASSWORD_INVALID);

      $errors = $this->getValidate($user , 1);
       $this->assertEquals(self::PASSWORD_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
            
    }

}
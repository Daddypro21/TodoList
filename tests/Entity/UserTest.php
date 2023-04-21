<?php 

namespace App\Tests\Entity;



use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{
    private const EMAIL_CONSTRAINT_MESSAGE =" cet email n'est pas valide";
    private const NOT_BLANK_MESSAGE = "Veuiller saisir une valeur";
    private const NOT_VALID_EMAIL_MESSAGE = ' Email non valide';
    private const INVALID_EMAIL_VALUE =" code@gmail";
    private const PASSWORD_CONSTRAINT_MESSAGE = "le mot de passe doit contenir plus de 6 caracteres";
    private const VALID_EMAIL = "code1@gmail.com";
    private const PASSWORD_VALID = "123456";

  

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

    public function testUserInvalid()
    {
        $user = new User();

        $user 
            ->setEmail(self::INVALID_EMAIL_VALUE)
            ->setPassword(self::PASSWORD_VALID);

      $errors = $this->getValidate($user , 1);
       $this->assertEquals(self::NOT_VALID_EMAIL_MESSAGE, $errors[0]->getMessage());
            
    }

}
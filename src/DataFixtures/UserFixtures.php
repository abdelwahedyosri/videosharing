<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $password_encoder){
        $this->passwordencoder=$password_encoder;


    }
    public function load(ObjectManager $manager)
    {
        foreach($this->getuserdata() as[$name,$lastname,$email,$password,$api_key,$Role]){
            $user=new User();
            $user->setName($name)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($this->passwordencoder->encodePassword($user,$password))
            ->setRoles($Role)
            ->setVimeoApikey($api_key);
            $manager->persist($user);
            


        }

        $manager->flush();
    }
    private function getuserdata(){

        return [
            
            ['yosri','abdelwahed','abdelwahed_yosri@yahoo.com','password','12345',['ROLE_ADMIN']],
            ['rihen','abdelwahed','abdelwahed_rihen@yahoo.com','password','null',['ROLE_USER']],
            ['raed','abdelwahed','abdelwahed_raed@yahoo.com','password','null',['ROLE_USER']]
    

    ];
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class Categoryfixtures extends Fixture
{
   
   
	
 private function getElectronicsData(){

        return [
            'Cameras',
           'Computers', 
         'Cell Phones'
        ];
    } 

     private function getComputersData(){

        return [
            'Laptop',
           'Desktop'
        ];
    }
     private function getlaptopData(){

        return [
            'apple',
           'toshiba',
           'hp',
           'sony'
        ];
    }  

    private function getMainCategoriesData(){

    	return 
            ['Electronics',
            'Toys',
            'Books',
          'Movies'
        ];
    } 

    private function getBooksData(){

        return 
            ['Novel',
            'Poeme',
            'Magazine',
          
        ];
    } 

     private function getMoviesData(){

        return 
            ['Romance',
            'Horror',
            'Crime',
          'Drama'
        ];
    } 
     

     public function load(ObjectManager $manager )
    {
        foreach ($this->getMainCategoriesData() as $categoryname) {
        $maincategory=new Category();
        $maincategory->setName($categoryname);
        $manager->persist( $maincategory);
        }
        $manager->flush();
        $x=$manager->getRepository(Category::class)->findBy(array('name' => 'Electronics'));
        $parent_id= $x[0]->getID();
         $parent = $manager->getRepository(Category::class)->find($parent_id);
        foreach ($this->getElectronicsData() as $subcategoryname) {
            
             $subcategory=new Category();

        $subcategory->setName($subcategoryname);
        $subcategory->setParent($parent);
        $manager->persist($subcategory);
        }

        $manager->flush();

         $x=$manager->getRepository(Category::class)->findBy(array('name' => 'Computers'));
        $parent_id= $x[0]->getID();
         $parent = $manager->getRepository(Category::class)->find($parent_id);
        foreach ($this->getComputersData() as $subcategoryname) {
            
             $subcategory=new Category();

        $subcategory->setName($subcategoryname);
        $subcategory->setParent($parent);
        $manager->persist($subcategory);
        }
        $manager->flush();

         $x=$manager->getRepository(Category::class)->findBy(array('name' => 'Laptop'));
        $parent_id= $x[0]->getID();
         $parent = $manager->getRepository(Category::class)->find($parent_id);
        foreach ($this->getlaptopData() as $subcategoryname) {
            
             $subcategory=new Category();

        $subcategory->setName($subcategoryname);
        $subcategory->setParent($parent);
        $manager->persist($subcategory);
        }
        $manager->flush();

         $x=$manager->getRepository(Category::class)->findBy(array('name' => 'Books'));
        $parent_id= $x[0]->getID();
         $parent = $manager->getRepository(Category::class)->find($parent_id);
        foreach ($this->getBooksData() as $subcategoryname) {
            
             $subcategory=new Category();

        $subcategory->setName($subcategoryname);
        $subcategory->setParent($parent);
        $manager->persist($subcategory);
        }
        $manager->flush();

         $x=$manager->getRepository(Category::class)->findBy(array('name' => 'Movies'));
        $parent_id= $x[0]->getID();
         $parent = $manager->getRepository(Category::class)->find($parent_id);
        foreach ($this->getMoviesData() as $subcategoryname) {
            
             $subcategory=new Category();

        $subcategory->setName($subcategoryname);
        $subcategory->setParent($parent);
        $manager->persist($subcategory);
        }
        $manager->flush();





    }


   /*  public function loadsubcategories(ObjectManager $manager)
    {

       $parent=$manager->getRepository(Category::class)->findBy($parent_id);
        foreach ($this->getsubcategoriesData() as $name) {
        	
        	 $category=new Category();

        $category->setName($name);
        $category->setParent($parent_id);
        $manager->persist($category);
        }
       


        $manager->flush();
    }*/

  



}

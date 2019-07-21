<?php


namespace App\Utils\AbstractClasses;
use  Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


abstract class CategoryTreeAbstract
{
	public $categoriesArrayFormDb;
	public $categorylist;
	
	public $mainParentName;
	
	
	protected static $dbconnection;

	public function __construct(EntityManagerInterface $entitymanager,UrlGeneratorInterface $urlgenerator){
		$this->entitymanager=$entitymanager;
		$this->urlgenerator=$urlgenerator;
		$this->categoriesArrayFormDb=$this->getCategories();
		


	}
	
	public function buildTree(int $parent_id=NUll):array
	{
		$subcategories=[];
	
		foreach ($this->categoriesArrayFormDb as $category) {
			if($category['parent_id']==$parent_id){

				$children=$this-> buildTree($category['id']);
				if($children){
					$category['children']=$children;

				}
				$subcategories[]=$category;
				
		
		
		
			}
			
			
		}


	
		return $subcategories;
	}
	abstract public  function getCategoryList(array $categories_array);
	private function getCategories():array
	{

		if(self::$dbconnection){
			return self::$dbconnection;

		}else{
			$conn=$this->entitymanager->getConnection();
		$sql="SELECT * FROM Categories ";
		$stmt=$conn->prepare($sql);
		$stmt->execute();
		return $stmt->FetchALL();
		}
		



	}


	
}
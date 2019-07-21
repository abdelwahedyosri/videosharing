<?php  

namespace App\Utils\AbstractClasses;

use App\Utils\AbstractClasses\CategoryTreeAbstract;


Class CategoryTreeAdminList extends CategoryTreeAbstract{

	

	 public  function getCategoryList(array $categories_array){

	 	$this->categorylist.='<ul class="fa-ul text-left">';
	 	foreach ($categories_array as $value ) {
	 		$url1=$this->urlgenerator->generate('edit_category',['id'=>$value['id']],['name'=>$value['name']]);
	 		$url2=$this->urlgenerator->generate('delete_category',['id'=>$value['id']]);	
	 		$catName=$value['name'];
	 		 $this->categorylist.= '<li><i class="fa-li fa fa-arrow-right"></i>'.$catName.'     <a href="'.$url1.'">edit</a>        <a onclick="return confirm(Are you sure?);"  href="'.$url2.'">delete</a></li>';
	 		 if(!empty($value['children'])){

	 		 	$this->getCategoryList($value['children']);
	 		 }
	 	}
	 	$this->categorylist.='</ul>';

	 	return $this->categorylist;

	 }
	
	
 
}




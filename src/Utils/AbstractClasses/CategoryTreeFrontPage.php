<?php  

namespace App\Utils\AbstractClasses;

use App\Utils\AbstractClasses\CategoryTreeAbstract;


Class CategoryTreeFrontPage extends CategoryTreeAbstract{
	public function getChildIds(int $parent): array
    {
        static $ids = [];
        foreach($this->categoriesArrayFormDb as $val)
        {
            if($val['parent_id'] == $parent)
            {
               $ids[] = $val['id'].',';
               $this->getChildIds($val['id']);
            }
        }
        
        return $ids;
    }

	public function getCategoryListAndParent(int $id):string
	{
		$parentData=$this->getMainParent($id);
		$this->mainParentName=$parentData['name'];
		$this->mainParentid=$parentData['id'];
		$key=array_search($id,array_column($this->categoriesArrayFormDb, 'id'));
		$this->currentcategoryname=$this->categoriesArrayFormDb[$key]['name'];
		$categories_array=$this->buildTree($parentData['id']);
		array_unshift($categories_array,$parentData);
		return $this->getCategoryList($categories_array) ;


	}

	 public  function getCategoryList(array $categories_array){
	 	$this->categorylist.='<ul>';
	 	foreach ($categories_array as $value ) {
	 		$url=$this->urlgenerator->generate('video_list',['id'=>$value['id'],'categoryname'=>$value['name']]);
	 		$catName=$value['name'];
	 		 $this->categorylist.= '<li>'.'<a href="'.$url.'">'.$catName.'</a>';
	 		 if(!empty($value['children'])){

	 		 	$this->getCategoryList($value['children']);
	 		 }
	 	}
	 	$this->categorylist.='</ul>';
	 	return $this->categorylist;

	 }
	 public function getMainParent(int $id):array
	 {

	 	$key=array_search($id,array_column($this->categoriesArrayFormDb, 'id'));
	 	if($this->categoriesArrayFormDb[$key]['parent_id']==null){

	 		return["id"=>$this->categoriesArrayFormDb[$key]['id'],
	 			"name"=>$this->categoriesArrayFormDb[$key]['name']



	 	];
	 	}else{

	 		return $this->getMainParent($this->categoriesArrayFormDb[$key]['parent_id']);

	 	}
	 }
	 
 /*public  function getmainparentCategoryList(array $categories_array){

 	foreach ($categories_array as $value ) {
 	
 		 if($value['parent_id']==null){
 		 		array_push($this->mainparentcategorylist,$value);
 		 		$url=$this->urlgenerator->generate('video_list',['id'=>$value['id'],'categoryname'=>$value['name']]);
 		 }

 	}
 
 	return $this->mainparentcategorylist;
 }*/
	
}
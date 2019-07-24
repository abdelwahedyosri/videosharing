<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\AbstractClasses\CategoryTreeAdminList;

use  App\Utils\AbstractClasses\CategoryTreeAdminOptionList;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Entity\Category;

/**
     * @Route("/admin")
     */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index()
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/su/categories", name="categories",methods={"GET","POST"})
     */
    public function categories(CategoryTreeAdminList $categories,Request $request)
    
    {

        $categories->getCategoryList($categories->buildTree());
        $category=new Category();
        $form=$this->createForm(CategoryType::class,$category);
        $form->handlerequest($request);
        $is_invalid=null;
        if ($form->issubmitted() && $form->isValid() ){

            $category->setName( $request->request->get('category')['name']);
            
           
             $repository=$this->getDoctrine()->getRepository(Category::class);
             $parent=$repository->find($request->request->get('category')['parent']);
             $category->setParent($parent); 
             $entitymanager=$this->getDoctrine()->getManager();
             $entitymanager->persist($category);
             $entitymanager->flush();
             return $this->redirectToRoute('categories');  
        }elseif($request->isMethod('post')){

            $is_invalid=' is-invalid';
        }

        return $this->render('admin/categories.html.twig',[
                'categories'=>$categories->categorylist,
                'form'=>$form->createView(),
                'is_invalid'=>$is_invalid
        ]);
    }

     /**
     * @Route("/videos", name="videos")
     */
    public function videos()
    {
        return $this->render('admin/videos.html.twig');
    }
     /**
     * @Route("/upload_video", name="upload_video")
     */
    public function upload_video()
    {
        return $this->render('admin/upload_video.html.twig');
    }

     /**
     * @Route("/users", name="users")
     */
    public function users()
    {
        return $this->render('admin/users.html.twig');
    }

     /**
     * @Route("/su/edit_category/{id}", name="edit_category")
     */
    public function edit_category(Category $editedcategory)
    {
        return $this->render('admin/edit_category.html.twig',[

            'editedcategory'=>$editedcategory]);
    }
      /**
     * @Route("/su/delete_category/{id}", name="delete_category")
     */   
    public function deleteCategory(Category $category)
    {
        $entitymanager=$this->getDoctrine()->getManager();
        $entitymanager->remove($category);
         $entitymanager->flush();
        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/getAllCategories", name="getAllCategories")
     */ 

    public function getAllCategories(CategoryTreeAdminOptionList $categories, $editedcategory=null){
        $categories->getCategoryList($categories->buildTree());
        return $this->render('admin/allcategories.html.twig',[

'categories'=>$categories,
'editedcategory'=>$editedcategory
    ]);


    }
}

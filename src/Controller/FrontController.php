<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Utils\AbstractClasses\CategoryTreeFrontPage;



class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/video_list/{id}/{categoryname}", name="video_list")
     */
    public function video_list($id,CategoryTreeFrontPage $categories)
    {
        

         $x= $categories->getCategoryListAndParent($id);
       /*$subcategories=$categories->buildTree($id);*/
      
     $t=$categories->mainParentName;
       /*dump($subcategories)*/
    
        return $this->render('front/video_list.html.twig', [
            'subcategories'=>$x,
            'category'=>$t
        ]);
    }

    /**
     * @Route("/video_details", name="video_details")
     */
    public function video_details()
    {

        return $this->render('front/video_details.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/search_results",methods={"POST"}, name="search_results")
     */
    public function search_results()
    {
        return $this->render('front/search_results.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
     /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing()
    {
        return $this->render('front/pricing.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

     /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('front/register.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('front/login.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    /**
     * @Route("/payment", name="payment")
     */
    public function payment()
    {
        return $this->render('front/payment.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
    public function mainCategories(){
        $categories=$this->getDoctrine()->getRepository(Category::class)->findBy(['parent'=>Null],['name'=>'ASC']);

        return $this->render('front/main_categories.html.twig',['categories'=>$categories]);
    }
}

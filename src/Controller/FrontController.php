<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\UserType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\AbstractClasses\CategoryTreeFrontPage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

     /**
     * @Route("/video-list/category/{categoryname},{id}/{page}", defaults={"page": "1"}, name="video_list")
     */
    public function videoList($id, $page, CategoryTreeFrontPage $categories,$categoryname)
    {
        $ids = $categories->getChildIds($id);
        array_push($ids, $id);

        $videos = $this->getDoctrine()
        ->getRepository(Video::class)
        ->findByChildIds($ids ,$page);

        $subcatégories=$categories->getCategoryListAndParent($id);
       
        return $this->render('front/video_list.html.twig',[
            'subcategories' => $subcatégories,
            'videos'=>$videos,
            'category'=>$categoryname,
            'id'=>$id
        ]);
    }

    /**
     * @Route("/video-details", name="video_details")
     */
    public function videoDetails()
    {
        return $this->render('front/video_details.html.twig');
    }

    /**
     * @Route("/search-results", methods={"POST"}, name="search_results")
     */
    public function searchResults()
    {
        return $this->render('front/search_results.html.twig');
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing()
    {
        return $this->render('front/pricing.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder,ObjectManager $manager)
    {
        $user =new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ( $form->isSubmitted() &&  $form->isValid() ){
            $password=$encoder->encodePassword($user,$request->request->get('user')['password']['first']);
            $user->setName($request->request->get('user')['name'])
            ->setLastname($request->request->get('user')['lastname'])
            ->setEmail($request->request->get('user')['email'])
            ->setPassword($encoder->encodePassword($user,$request->request->get('user')['password']['first']))
            ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
            $this->loginUserAutomatically($user,$password);

            return $this->redirectToRoute('admin_main_page');
        }

        return $this->render('front/register.html.twig',[
            
            'form'=>$form->createView()
            
            
            ]);
    }
    private function loginUserAutomatically($user, $password)
    {
        $token = new UsernamePasswordToken(
            $user,
            $password,
            'main', // security.yaml
            $user->getRoles()
        );
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main',serialize($token));
    }
    
    /**
     * @Route("/payment", name="payment")
     */
    public function payment()
    {
        return $this->render('front/payment.html.twig');
    }

    public function mainCategories()
    {
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findBy(['parent'=>null], ['name'=>'ASC']);
        return $this->render('front/main_categories.html.twig',[
            'categories'=>$categories
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $helper)
    {

        return $this->render('front/login.html.twig',['error'=>$helper->getLastAuthenticationError()]);
    }

     /**
     * @Route("/logout", name="logout")
     */
    public function logout(AuthenticationUtils $helper)
    {

        throw new \Exception("This should never be reached");
    }

}


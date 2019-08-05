<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\PersistentObject;


class PostController extends Controller
{
    
    /**
     * @Route("/post", name="display_all_post")
     */
    
    public function showAllPostsAction(Request $request)
    {
        // replace this example code with whatever you need
        
        $posts= $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
       
        return $this->render('pages/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'posts' => $posts
        ]);
    }
    
    /**
     * @Route("/create", name="create_all_post")
     */
    
    public function createAllPostsAction(Request $request)
    {
        // replace this example code with whatever you need
        
        $post= new Post;
        $form = $this->createFormBuilder($post)
        ->add('title', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-top:10px')))
        ->add('description', TextareaType::class, array('attr'=>array('class'=>'form-control')))
        ->add('category', TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('save', SubmitType::class, array('label'=>'create post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px')))
        ->getForm();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
            
            $post->setTitle($title);
            $post->setDescription($category);
            $post->setCategory($category);
            
            $em = $this->getDoctrine()->getManager();
            $em->Persist($post);
            $em->flush();
            $this-> addflash('success_message','post created sucessfully');
            return $this->redirectToRoute('display_all_post');
        }
        
        
        return $this->render('pages/create.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form'=>$form->createView()
        ]);
    }
    
    
    
    /**
     * @Route("/edit/{id}", name="edit_all_post")
     */
    
    public function editAllPostsAction(request $request,$id)
    {

 $posts= $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);
 $posts->setTitle($posts->getTitle());
  $posts->setDescription($posts->getDescription());

  $posts->setCategory($posts->getCategory());

   $form = $this->createFormBuilder($posts)
        ->add('title', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-top:10px')))
        ->add('description', TextareaType::class, array('attr'=>array('class'=>'form-control')))
        ->add('category', TextType::class, array('attr'=>array('class'=>'form-control')))
        ->add('save', SubmitType::class, array('label'=>'update post','attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-top:10px')))
        ->getForm();
        $form->handleRequest($request);

 
        if($form->isSubmitted() && $form->isValid())
        {
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
              $em = $this->getDoctrine()->getManager();
            $posts = $em->getRepository('AppBundle:Post')->find($id);
            $posts->setTitle($title);
            $posts->setDescription($description);
            $posts->setCategory($category);
            
           // $em->Persist($post);
            $em->flush();
            $this-> addflash('success_message','post updated sucessfully');
            return $this->redirectToRoute('display_all_post');
        }
        

       
        return $this->render('pages/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
             'form'=>$form->createView()
        ]);
    }
    
    /**
     * @Route("/view/{id}", name="view_all_post")
     */
    
    public function viewAllPostsAction($id)
    {
             $posts= $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);

       
        return $this->render('pages/view.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'posts' => $posts
        ]);
    }
    
    
    /**
     * @Route("/delete/{id}", name="delete_all_post")
     */
    
    public function deleteAllPostsAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->find($id);
        $em->remove($posts);
        $em->flush();
            $this-> addflash('success_message','post Deleted sucessfully');
            return $this->redirectToRoute('display_all_post');
       
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;

class ArticleController extends Controller
{
    /**
     * Matches / exactly
     *
     * @Route("/", name="article")
     */
    public function list()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        return $this->render('article/list.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * Matches /article/add/*
     *
     * @Route("/article/add/", name="article_add")
     */
    public function add(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class,array('required' => true))
            ->add('content', TextareaType::class,array('required' => true))
            ->add('save', SubmitType::class, array('label' => 'Create article'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $article = new Article();
            $article->setTitle($data->getTitle());
            $article->setContent($data->getContent());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($article);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('article');
        }

        return $this->render('article/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Matches /article/*
     *
     * @Route("/article/show/{id}", name="article_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        return $this->render('article/show.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * Matches /article/edit/*
     *
     * @Route("/article/edit/{id}", name="article_edit")
     */
    public function edit($id,Request $request)
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class,array('required' => true))
            ->add('content', TextareaType::class,array('required' => true))
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            // $article = new Article();
            $article->setTitle($data->getTitle());
            $article->setContent($data->getContent());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($article);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('article');
        }

        return $this->render('article/new.html.twig', array(
            'form' => $form->createView(),
        ));

        

    }

    /**
     * Matches /article/delete/*
     *
     * @Route("/article/delete/{id}", name="article_delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('article');
    }
}
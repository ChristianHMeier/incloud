<?php
namespace App\Controller;

use App\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class StoryController extends AbstractController
{
    /**
     * @Route("/", name="listpage")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        //Load the default first load values and calculate the max number of pages
        $stories = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Story s
            ORDER BY s.submitDate DESC'
        )->setMaxResults(5)
        ->getResult();
        $count = $entityManager->createQuery(
            'SELECT COUNT(s.id)
            FROM App\Entity\Story s'
        )->getSingleScalarResult();
        $count = (int)ceil($count/5);

        //pass the data to the Twig template
        return $this->render('story/index.html.twig', [
            'stories' => $stories,
            'count' => $count
        ]);
    }
    /**
     * @Route("/form", name="formpage")
     */
    public function form()
    {
        //Build the form which will send the AJAX requests to save new story data
        $story = new Story();
        
        $form = $this->createFormBuilder($story)
                    ->add('bookTime', TextType::class, 
                            array(
                                    'mapped' => false,
                                    'data' => '0:00:00',
                                )
                        )
                    ->add('description', TextType::class)
                    ->add('storyManual', CheckboxType::class, 
                            array(
                                    'label'    => 'Enter time manually?',
                                    'required' => false,
                                    'mapped'   => false,
                                )
                        )
                    ->add('storyStart', ButtonType::class, 
                            array(
                                    'label' => 'Start timer',
                                )
                        )
                    ->add('storyReset', ButtonType::class, 
                            array(
                                    'label' => 'Reset timer',
                                )
                        )
                    ->add('storySave', ButtonType::class, 
                            array(
                                    'label' => 'Save story',
                                )
                        )
                    ->getForm();

        return $this->render('story/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/add", name="addjson")
     */
    public function add(Request $request)
    {
        $response = array();
        //Ensure the request was made by AJAX
        if ($request->isXmlHttpRequest())
        {
            try
            {
                $entityManager = $this->getDoctrine()->getManager();

                $story = new Story();
                $story->setDescription($request->request->get('description'));
                $story->setBookTime(new \DateTime($request->request->get('time')));
                $story->setSubmitDate(new \DateTime('now'));

                $entityManager->persist($story);
                $entityManager->flush();
                
                if ($story->getId() != null)
                {
                    $response['success'] = 1;
                    $response['feedback'] = 'Story successfully saved.';
                }
                else
                {
                    $response['success'] = 0;
                    $response['feedback'] = 'Could not save story, please try again later.';
                }
            }
            catch (Exception $message)
            {
                $response['success'] = 0;
                $response['feedback'] = 'Database saving error, call the administrator and show this message: ';
                $response['feedback'] .= $message;
            }
        }
        else
        {
            $response['success'] = 0;
            $response['feedback'] = 'Invalid request, please use the proper form.';
        }
        return  $this->json($response);
    }
    
    /**
     * @Route("/fetch", name="fetchjson")
     */
    public function fetch(Request $request)
    {
        $response = array();
        //Ensure the request was made by AJAX
        if ($request->isXmlHttpRequest())
        {
            //placeholders for the dates and the array by which the query will be sanitized
            $from = '';
            $to = '';
            $parameters = array();
            
            //rearrange the dates'values so they are compatible with the database format
            if ($request->request->get('from') != '')
            {
                $fromArray = explode('.', $request->request->get('from'));
                $from .= $fromArray[2].'-'.$fromArray[1].'-'.$fromArray[0].' 00:00:00';
            }
            if ($request->request->get('to') != '')
            {
                $toArray = explode('.', $request->request->get('to'));
                $to .= $toArray[2].'-'.$toArray[1].'-'.$toArray[0].' 23:59:59';
            }
            //get the terms written in the keyword filter and assing them to an array
            $terms = null;
            if ($request->request->get('terms') != '')
            {
                $terms = explode(' ', $request->request->get('terms'));
            }
            
            $entityManager = $this->getDoctrine()->getManager();

            $offset = ((int)($request->request->get('numerator'))-1)*5;
            
            //Start building the query, and add values to the parameters array as they are identified
            $wherePrinted = false;
            $query = 'SELECT s FROM App\Entity\Story s';
            if ($from != '')
            {
                $query .= ' WHERE s.submitDate >= :from';
                $parameters['from'] = $from;
                $wherePrinted = true;
            }
            if ($to != '')
            {
                if (!$wherePrinted)
                {
                    $query .= ' WHERE ';
                    $wherePrinted = true;
                }
                else
                {
                    $query .= ' AND ';
                }
                $query .= 's.submitDate <= :to';
                $parameters['to'] = $to;
            }
            if (!is_null($terms))
            {
                if (!$wherePrinted)
                {
                    $query .= ' WHERE (';
                    $wherePrinted = true;
                }
                else
                {
                    $query .= ' AND (';
                }
                for ($i = 0; $i < count($terms); $i++)
                {
                    $query .= 's.description LIKE :description'.$i;
                    $parameters['description'.$i] = '%'.$terms[$i].'%';
                    if ($i < count($terms)-1)
                    {
                        $query .= ' OR ';
                    }
                }
                $query .= ')';
            }
            $query .= ' ORDER BY s.';
            
            //switch-case, as at this point the validator will not accept values to sanitize
            switch ($request->request->get('order'))
            {
                case 'date':
                    $query .= 'submitDate';
                    break;
                case 'time':
                    $query .= 'bookTime';
                    break;
                case 'description':
                    $query .= 'description';
                    break;
            }
            //add whether the values will be descendant or ascendant
            if ($request->request->get('descasc') == 'DESC')
            {
                $query .= ' DESC';
            }
            elseif ($request->request->get('descasc') == 'ASC')
            {
                $query .= ' ASC';
            }
            
            //Execute the query
            $stories = $entityManager->createQuery($query)
            ->setFirstResult($offset)->setMaxResults(5)->setParameters($parameters)
            ->getResult();
            
            //Date format fix using an array that copies the result above and modifies the date formats
            $storiesArray = array();
            for ($i = 0; $i < count($stories); $i++)
            {
                $storiesArray[$i]['id'] = $stories[$i]->getId();
                $storiesArray[$i]['description'] = $stories[$i]->getDescription();
                $storiesArray[$i]['bookTime'] = $stories[$i]->getBookTime()->format('H:i:s');
                $storiesArray[$i]['submitDate'] = $stories[$i]->getSubmitDate()->format('d.m.Y H:i:s');
            }
            $response['query'] = $query;
            $response['parameters'] = $parameters;
            $response['terms'] = $terms;
            $response['stories'] = $storiesArray;
        }
        else
        {
            $response['success'] = 0;
            $response['feedback'] = 'Invalid request, please use the proper page.';
        }
        return  $this->json($response);
    }
    
    
}
<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Documents;
use App\Entity\User;
use App\Form\Type\DocumentsType;
use App\Form\Type\UserType;
use App\Manager\UserManager;
use App\Model\RoleModel;
use Doctrine\DBAL\Types\DateType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class DocumentsController extends EasyAdminController
{

    private $passwordEncoder;

    private $userManager;

    private $paramBag;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserManager $userManager,ParameterBagInterface $params)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userManager = $userManager;
        $this->paramBag = $params;
    }


    /**
     * @Route("/documents", name="documents")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $All_documents = $em->getRepository(Documents::class)->findAll();
        $form = $this->createForm(DocumentsType::class);
        $categoryData['addInterestViewMatches'] = 'Add an Interest and View Matches';
        $categoryData['editFacultyProfile'] = 'Edit Faculty Profile';
        $categoryData['introductionVideCollaboration'] = 'Create Introduction Video for Collaboration';
        $categoryData['announcementEventRequest'] = 'Submit an Announcement or Event Request';
        $categoryData['instructorCourseIntroduction'] = 'Create Instructor and Course Introduction Videos';
        $categoryData['accessGuides'] = 'Access Guides, Templates, and Best Practices';
        $categoryData['generalPublication'] = 'Author a General Publication';
        $categoryData['academicJournal'] = 'Author an Academic Journal';
        $categoryData['writingProject'] = 'Join a Writing Project';
        $categoryData['createBestPractices'] = 'Create Best Practices';
        $categoryData['academivWritingStyle'] = 'Hone Your Academic Writing Style';
        $categoryData['courseDevelopmentBeginners'] = 'Course Development for Beginners';
        $categoryData['createCoursewithPeers'] = 'Create a Course with Peers';
        $categoryData['createStudyAbroadProgram'] = 'Create a Study Abroad Program';
        $categoryData['becomeProgramLeader'] = 'Become a Study Abroad Program Leader';
        $categoryData['startResearchProject'] = 'Start a Research Project';
        $categoryData['influentialMentor'] = 'Be an Influential Mentor';
        $categoryData['findMentor'] = 'Find a Mentor';
        $categoryData['initiatePeerReview'] = 'Initiate a Peer Review';
        $categoryData['participatePeerReview'] = 'Participate in a Peer Review';
        $categoryData['courseControlDocument'] = 'AHEA Course Control Document';
        $categoryData['syllabus'] = 'AHEA Syllabus';
        $categoryData['courseIntroMgmt'] = 'AHEA Course - Intro Business Mgmt';
        $categoryData['syllabusIntroMgmt'] = 'AHEA Syllabus - Intro Business Mgmt';
        $categoryData['healthForm'] = 'Health Form';
        $categoryData['parentGuide'] = 'Parent Guide';
        $categoryData['programFactSheet'] = 'Program Fact Sheet';
        $categoryData['studyAbroadPackingChecklist'] = 'Study Abroad Packing Checklist';
        $categoryData['studyAbroadPreDepartureChecklist'] = 'Study Abroad Pre-Departure Checklist';

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $category = $request->request->get('category');
                $sub_category = $request->request->get('sub_category');
                $file_url = $request->files->get('file_url');
                if ($file_url) {
                    $fileUrlName = md5(uniqid()) . '.' . $file_url->guessExtension();
                }else{
                    $this->addFlash('error',"Please Fill The Fields"); 
                    return $this->redirect($this->generateUrl('documents',['All_documents'=>$All_documents]));
                }
                $documents_id = $em->getRepository(Documents::class)->findBy(array('sub_category'=>$sub_category));
                if($documents_id){
                    foreach($documents_id as $document_id){

                        if ($document_id && $file_url) {
                            if ($document_id && $document_id->getFileUrl()) {
                                $file_to_delete = $this->get('kernel')->getProjectDir() . '/public/' . $document_id->getFileUrl();

                                if (file_exists($file_to_delete)) {
                                    unlink($file_to_delete);
                                }
                            }
                        } else {
                            if ($document_id && $document_id->getFileUrl()) {
                                $document_id->setFileUrl($document_id->getFileUrl());
                            }
                        }
                        $id=$document_id->getId();
                        if ($file_url) {
                            // Move the file to the directory where your form images are stored
                            try {
                                $file_url->move(
                                    $this->paramBag->get('upload_directory') . "/document/file/",
                                    $fileUrlName
                                );
                                $document_id->setFileUrl("uploads/document/file/" . $fileUrlName);
                            } catch (FileException $e) {
                                //Handle error
                            }
                        }
                        $em->persist($document_id);
                        $em->flush();
                        $this->addFlash(
                            'success',
                            "File Updated Successfully"
                        );
                    }
                }else{
                    if ($file_url) {
                        // Move the file to the directory where your form images are stored
                        try {
                            $file_url->move(
                                $this->paramBag->get('upload_directory') . "/document/file/",
                                $fileUrlName
                            );
                            $Documents = new Documents;
                            $Documents->setFileUrl("uploads/document/file/" . $fileUrlName);
                            $Documents->setCategory($category);
                            $Documents->setSubCategory($sub_category);
                        } catch (FileException $e) {
                            //Handle error
                        }
                    }
                    $em->persist($Documents);
                    $em->flush();
                    $this->addFlash(
                        'success',
                        "File Added Successfully"
                    );
                }
                return $this->redirect($this->generateUrl('documents',['All_documents'=>$All_documents]));
            }else {
               dump($form->getErrors());die;
            }
        }
        foreach ($All_documents as $document){
            $document->setSubCategory($categoryData[$document->getSubCategory()]);
        }
        return $this->render('admin/documents/index.html.twig', [
            'controller_name' => 'DocumentsController',
                'form' => $form->createView(),'All_documents'=>$All_documents
        ]);
    }

    /**
     * @Route("/api/get_documents/{document_category}", name="api-documents")

     */
    public function getDocuments(Request $request,$document_category)
    {

        //$parameterValue = $this->paramBag->get('id');

        $protocal = 'http://';
        if($request->isSecure()){
            $protocal = 'https://';
        }

        $responseData = [];

        $em = $this->getDoctrine()->getManager();

        if($document_category=='gettingStarted' || $document_category=='bestPractices'||$document_category=='templates'){

            $documents = $em->getRepository(Documents::class)->findBy(array('category'=>$document_category));

        }else{

            $documents = $em->getRepository(Documents::class)->findBy(array('sub_category'=>$document_category));

        }

        foreach($documents as $document){
            $responseData[$document->getSubCategory()] = $protocal .$request->server->get('HTTP_HOST') . "/". $document->getFileUrl();
        }


        $response = new JsonResponse();

        $response->setData($responseData);

        return $response;
    }
}

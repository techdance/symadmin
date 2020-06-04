<?php
// src/AppBundle/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Form;
use App\Entity\Group;
use App\Entity\GroupHasEntity;
use App\Entity\User;
use App\Entity\FormValue;
use App\Form\FormType;
use App\Form\Type\UserType;
use App\Model\RoleModel;
use App\Service\FileUploader;
use Doctrine\DBAL\Types\DateType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormBuilderController extends EasyAdminController
{
    /**
     * @Route("/form-builder-list", name="form_builder_list", methods={"GET","HEAD"})
     */
    public function formBuilderList() 
    {
        $em = $this->getDoctrine()->getManager();

        $builders = $em->getRepository('App:Form')->findAll();

        return $this->render('admin/formbuilder/default/builders-list.html.twig', [
            'builders' => $builders,
        ]);
    }

    /**
     * @Route("/form-builder", name="form_builder", methods={"GET","HEAD"})
     */
    public function formBuilderPage() 
    {
        return $this->render('admin/formbuilder/default/builder.html.twig');
        //return $this->render('admin/formbuilder/formbuilder.html.twig');
    }

    

    /**
     * Renders the builder page from a existing builder (edit)
     *
     * @Route("/form-builder/{id}/", name="form_builder_edit")
     */
    public function builderFormAction(Request $request, Form $formEntity)
    {

        return $this->render('admin/formbuilder/default/builder.html.twig', [
            'formEntity' => $formEntity,
        ]);
    }

    /**
     * Lists all related values from a builder
     *
     * @Route("/form-builder/{id}/values", name="form_builder_values")
     */
    public function builderFormValuesAction(Request $request, Form $formEntity)
    {
        $em = $this->getDoctrine()->getManager();

        $values = $em->getRepository('App:FormValue')->findValuesByForm($formEntity);

        return $this->render('admin/formbuilder/default/builder-values.html.twig', [
            'formEntity' => $formEntity,
            'values'     => $values,
        ]);
    }

    /**
     * Renders a new form
     *
     * @Route("/form/{id}", name="get_form")
     */
    public function renderFormAction(Form $formEntity, Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(FormType::class, null, ['formEntity' => $formEntity]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $valueEntity = new FormValue();

            $formData = $this->handleFiles($form->getData(), $fileUploader, false);
            $json = $this->handleDates($formData, false);
           
            $valueEntity->setJson($this->handleDates($formData, false));
            $valueEntity->setForm($formEntity);

            $em->persist($valueEntity);
            $em->flush();

            $this->addFlash(
                'success',
                'Die Eingaben wurden gespeichert'
            );

            return $this->redirect($this->generateUrl('get_value', ['id' => $valueEntity->getId()]));
        }


        return $this->render('admin/formbuilder/default/form.html.twig', array(
            'form'          => $form->createView(),
            'formEntity'    => $formEntity,
        ));
    }

    /**
     * Renders a form with existing form data
     *
     * @Route("/value/{id}", name="get_value")
     */
    public function getValueAction(FormValue $valueEntity, Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();

        $json = $valueEntity->getJson();
        $json = $this->handleFiles($json, $fileUploader);
        $valueEntity->setJson($this->handleDates($json));

        $form = $this->createForm(FormType::class, $valueEntity->getJson(), ['formEntity' => $valueEntity->getForm()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = array_merge($valueEntity->getJson(), array_filter($form->getData()));
            $formData = $this->handleFiles($formData, $fileUploader, false);
            $valueEntity->setJson($this->handleDates($formData, false));

            $em->persist($valueEntity);
            $em->flush();

            $this->addFlash(
                'success',
                'Die Eingaben wurden gespeichert'
            );
        }


        return $this->render('admin/formbuilder/default/form.html.twig', array(
            'form'          => $form->createView(),
            'formEntity'    => $valueEntity->getForm(),
            'valueEntity'   => $valueEntity,
        ));
    }

    /**
     * Delete value
     *
     * @Route("/value/{id}/delete", name="delete_value")
     */
    public function deleteValueAction(FormValue $valueEntity, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $redirect = $this->generateUrl('builderFormValues', ['id' => $valueEntity->getForm()->getId()]);

        $em->remove($valueEntity);
        $em->flush();

        $this->addFlash(
            'success',
            'Die Eingaben wurden gelöscht'
        );

        return $this->redirect($redirect);
    }

    /**
     * Saves a new or existing builder
     *
     * @Route("/ajax/builder/save", name="form_builder_save", methods={"POST"})
     */
    public function builderFormSaveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = $request->request->get('formData');
      
        if ($id = $request->request->get('id')) {
            $form = $em->getRepository('App:Form')->findOneBy(['id' => $id]);
        }

       
        if (empty($request->request->get('formName'))) {
             return new JsonResponse([
                'success'   => false,
                'redirect'  => false,
                'msg'       => 'Form Name is required.',
            ]);
        }
        if (empty(json_decode($json))) {
            return new JsonResponse([
                'success'   => false,
                'redirect'  => false,
                'msg'       => 'Form created successfully',
            ]);
        }

        if (empty($form)) {
            $form = new Form();
        }

        $form->setName($request->request->get('formName'));
        $form->setJson(json_decode($json, true));
        $em->persist($form);
        $em->flush();

        $this->addFlash(
            'success',
            '<strong>'. $form->getName() .'</strong> saved successfully'
        );

        return new JsonResponse([
            'success'   => true,
            // 'redirect'  => $this->generateUrl('form_builder_edit', ['id' => $form->getId()]),
            'redirect'  => $this->generateUrl('form_builder_list'),
        ]);
    }

     /**
     * Deletes a builder
     *
     * @Route("/ajax/builder/delete", name="form_builder_delete", methods={"POST", "GET"})
     */
    public function builderFormDeleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $success = false;
        $redirect = false;

        $form = null;
       
        if ($id = $request->request->get('id')) {
            $form = $em->getRepository('App:Form')->findOneBy(['id' => $id]);
        }
       
        if ($form) {
            $em->remove($form);
            $em->flush();
            $success = true;

            //$redirect = $this->generateUrl('admin');
            $this->addFlash(
                'success',
                '<strong>'. $form->getName() .'</strong> deleted successfully'
            );
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'success'   => $success,
                'redirect'  => $this->generateUrl('form_builder_list'),
            ]);
        }

        return $this->redirectToRoute('form_builder_list'); 
    }

    /**
     * Format date fields for saving or form
     *
     * @param   array   $data
     * @param   bool    $object
     * @return  array
     */
    protected function handleDates(array $data, $object = true)
    {
        $dateTypes = preg_grep('/^date-/', array_keys($data));

        foreach ($dateTypes as $dateType) {
            if ($data[$dateType] && $object) {
                $data[$dateType] = new \DateTime($data[$dateType]);
            } else if ($data[$dateType]) {
                $data[$dateType] = $data[$dateType]->format('Y-m-d');
            }
        }

        return $data;
    }

    /**
     * Format file fields for saving or form
     *
     * @param   array           $data
     * @param   FileUploader    $fileUploader
     * @param   bool            $object
     * @return  array
     */
    protected function handleFiles(array $data, FileUploader $fileUploader, $object = true)
    {
        $fileTypes = preg_grep('/^file-/', array_keys($data));

        foreach ($fileTypes as $fileType) {
            if (!$data[$fileType]) {
                continue;
            }

            if ($object) {
                $data[$fileType] = new File($fileUploader->getTargetDirectory().$data[$fileType]);
            } else if ($data[$fileType] instanceof UploadedFile) {
                $data[$fileType] = $fileUploader->upload($data[$fileType]);
            } else if ($data[$fileType] instanceof File) {
                $data[$fileType] = $data[$fileType]->getFilename();
            }
        }

        return $data;
    }
}

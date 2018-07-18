<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/6/18
 * Time: 5:54 PM
 */

namespace App\Admin;


use App\Entity\Author;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminAuthor extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('fullname', TextType::class,['required' => 'true'])
             ->add('file', FileType::class, ['required' => 'true', 'label' => 'Avatar']);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('fullname');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('fullname');
    }

    public function toString($object)
    {
        return $object instanceof Author
            ? $object->getFullname()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }


    public function prePersist($avatar)
    {
        $this->manageFileUpload($avatar);
    }

    public function preUpdate($avatar)
    {
        $this->manageFileUpload($avatar);
    }

    private function manageFileUpload($avatar)
    {
        if ($avatar->getFile()) {
            $avatar->refreshUpdated();
        }
    }
}
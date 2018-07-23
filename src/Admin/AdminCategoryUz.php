<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/12/18
 * Time: 3:28 PM
 */

namespace App\Admin;

use App\Entity\CategoryUz;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminCategoryUz extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', TextType::class)
            ->add('id', IntegerType::class);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
    }

    public function toString($object)
    {
        return $object instanceof CategoryUz
            ? $object->getName()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}

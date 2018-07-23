<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/5/18
 * Time: 3:24 PM
 */

namespace App\Admin;

use App\Entity\Tag;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminCategory extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', TextType::class)
            ->add('id', IntegerType::class);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('id');
        $list->addIdentifier('name');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
        $filter->add('id');
    }

    public function toString($object)
    {
        return $object instanceof Tag
            ? $object->getName()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}

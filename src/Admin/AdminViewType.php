<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/5/18
 * Time: 3:35 PM
 */

namespace App\Admin;


use App\Entity\ViewType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AdminViewType extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('created_at');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('name');
    }

    public function toString($object)
    {
        return $object instanceof ViewType
            ? $object->getName()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}
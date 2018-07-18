<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/5/18
 * Time: 3:24 PM
 */

namespace App\Admin;


use App\Entity\Post;
use App\Entity\Tag;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminTag extends AbstractAdmin
{
    public $supportsPreviewMode = true;

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name', TextType::class)
            ->add('posts', EntityType::class,[
                'class' => Post::class,
                'multiple' => true,
                'choice_label' => 'title'
            ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('created_at');
    }

    public function toString($object)
    {
        return $object instanceof Tag
            ? $object->getName()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }
}
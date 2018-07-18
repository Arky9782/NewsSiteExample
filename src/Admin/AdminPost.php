<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/4/18
 * Time: 2:06 PM
 */

namespace App\Admin;


use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\ViewType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminPost extends AbstractAdmin
{
    public $supportsPreviewMode = true;

    protected function configureFormFields(FormMapper $form)
    {

        // get the current Image instance
        $post = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => true];
        if ($post && ($webPath = $post->getImage())) {
            $fileFieldOptions = ['required' => false];
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/upload/images/'.$webPath;

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }


        $form->with('Text', ['class' => 'col-md-9'])
            ->add('body', FormatterType::class, [
                'label' => 'text',
                'required' => 'true',
                'source_field'         => 'raw_body',
                'source_field_options' => ['attr' => ['class' => 'span10', 'rows' => 100]],
                'format_field'         => 'body',
                'target_field'         => 'body',
                'ckeditor_context'     => 'default',
                'event_dispatcher' => $form->getFormBuilder()->getEventDispatcher(),
            ])
            ->end()
            ->with('Data', ['class' => 'col-md-3'])
            ->add('title', TextType::class, ['required' => 'true'])
            ->add('subtitle', TextType::class)
            ->add('slug', TextType::class, ['required' => 'true'])
            ->add('file', FileType::class, $fileFieldOptions)
            ->add('draft')
            ->add('main')
            ->end()
            ->with('Tags', ['class' => 'col-md-3'])
            ->add('tags', EntityType::class,[
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->end()
            ->with('Card', ['class' => 'col-md-3'])
            ->add('viewType', EntityType::class, [
                'class' => ViewType::class,
                'choice_label' => 'name',
            ])
            ->end()
            ->with('Author', ['class' => 'col-md-3'])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullname',
            ])
            ->end()
            ->with('Category', ['class' => 'col-md-3'])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->end()
        ;

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('created_at');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title')
            ->add('body')
            ->add('draft')
            ->add('main')
            ->add('tags.name')
        ;
    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }


    public function prePersist($post)
    {
        $this->manageFileUpload($post);
    }

    public function preUpdate($post)
    {
        $this->manageFileUpload($post);
    }

    private function manageFileUpload($post)
    {
        if ($post->getFile()) {
            $post->refreshUpdated();
        }
    }
}
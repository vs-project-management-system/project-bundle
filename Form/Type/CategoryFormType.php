<?php
namespace PMS\Bundle\ProjectBundle\Form\Type;

class CategoryFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(
        \Symfony\Component\Form\FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add('name');
        $builder->add('description');
        $builder->add(
            'parent',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\ProjectBundle\Entity\Category',
               'empty_value' => false
            )
        );
    }

    public function getName()
    {
        return 'category';
    }
}

<?php
namespace PMS\Bundle\ProjectBundle\Form\Type;

class ProjectFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(
        \Symfony\Component\Form\FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add('name');
        $builder->add('short_description');
        $builder->add('description');
        $builder->add('url', 'url');
        
        $builder->add(
            'status',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\ProjectBundle\Entity\Status'
            )
        );
        
        $builder->add(
            'category',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\ProjectBundle\Entity\Category'
            )
        );
        
        $builder->add(
            'client',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\UserBundle\Entity\Client'
            )
        );
        
        $builder->add(
            'developer',
            'entity',
            array(
               'property' =>  'name',
               'class' => 'PMS\UserBundle\Entity\Developer'
            )
        );
    }
    
    public function setDefaultOptions(OptionResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => '\PMS\Bundle\ProjectBundle\Entity\Project')
        );
    }

    public function getName()
    {
        return 'project';
    }
}

<?php
namespace PMS\Bundle\ProjectBundle\Form\Type;

class StatusFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(
        \Symfony\Component\Form\FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add('name');
        $builder->add('description');
    }

    public function getName()
    {
        return 'status';
    }
}

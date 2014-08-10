<?php
namespace PMS\Bundle\ProjectBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Validator\Constraints as Assert;

use \Gedmo\Mapping\Annotation as Gedmo;

use PMS\CoreBundle\Traits\TimestampableTrait;
use PMS\CoreBundle\Traits\SlugableTrait;

/**
 * @ORM\Table(name="status")
 * @ORM\Entity(repositoryClass="\PMS\ProjectBundle\Repository\StatusRepository")
 */
class Status
{
    use TimestampableTrait;
    use SlugableTrait;
    
    /**
     * @inheritdoc
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @inheritdoc
     * @ORM\Column(name="name", type="string", length=150)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @inheritdoc
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * Get Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}

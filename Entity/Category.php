<?php
namespace PMS\Bundle\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;

use PMS\CoreBundle\Traits\TimestampableTrait;
use PMS\CoreBundle\Traits\SlugableTrait;

/**
 * PMS\ProjectBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="PMS\Bundle\ProjectBundle\Repository\CategoryRepository")
 */
class Category
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
     * @inheritdoc
     * @ORM\ManyToOne(targetEntity="\PMS\Bundle\ProjectBundle\Entity\Category", inversedBy="category")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * Get Id
     * @return interger
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

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function setParent(\PMS\Bundle\ProjectBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }
}

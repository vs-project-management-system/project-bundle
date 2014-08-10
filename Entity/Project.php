<?php
namespace PMS\Bundle\ProjectBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Validator\Constraints as Assert;

use \Gedmo\Mapping\Annotation as Gedmo;

use PMS\CoreBundle\Traits\TimestampableTrait;
use PMS\CoreBundle\Traits\SlugableTrait;

/**
 * PMS\ProjectBundle\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="\PMS\Bundle\ProjectBundle\Repository\ProjectRepository")
 */
class Project extends \PMS\Component\Project\Model\Project
{
    use TimestampableTrait;
    use SlugableTrait;
    
    /**
     * @inheritdoc
     *
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
     * @ORM\Column(name="blurb", type="string", length=30)
     */
    protected $blurb;

    /**
     * @inheritdoc
     * @ORM\Column(name="description", type="text")
     */
    protected $description = '';

    /**
     * @inheritdoc
     * @ORM\Column(name="url", type="text")
     * @Assert\Url()
     */
    protected $url;

    /**
     * @inheritdoc
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="project")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $status;

    /**
     * @inheritdoc
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="project")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @inheritdoc
     * @ORM\ManyToOne(targetEntity="PMS\UserBundle\Entity\Client", inversedBy="project")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @inheritdoc
     * @ORM\OneToMany(targetEntity="PMS\UserBundle\Entity\Developer", mappedBy="project")
     */
    protected $developers;

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
    public function getBlurb()
    {
        return $this->blurb;
    }

    /**
     * @inheritdoc
     */
    public function setBlurb($description)
    {
        $this->blurb = $description;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function setStatus(\PMS\Bundle\ProjectBundle\Entity\Status $status)
    {
        $this->status = $status;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @inheritdoc
     */
    public function setCategory(\PMS\Bundle\ProjectBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function setClient(\PMS\Bundle\UserBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addDeveloper(\PMS\Bundle\UserBundle\Entity\Developer $developer)
    {
        $this->developers[] = $developer;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDevelopers()
    {
        return $this->developers;
    }

    /**
     * @inheritdoc
     */
    public function removeDeveloper(\PMS\Bundle\UserBundle\Entity\Developer $developer)
    {
        $this->developers->removeElement($developer);
    }
}

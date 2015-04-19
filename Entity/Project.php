<?php
namespace PMS\Bundle\ProjectBundle\Entity;

use \PMS\Bundle\CoreBundle\Traits\TimestampableTrait;
use \PMS\Bundle\CoreBundle\Traits\SluggableTrait;

class Project
{
    use TimestampableTrait;
    use SluggableTrait;
    
    /**
     * Id
     * @var integer
     */
    protected $id;

    /**
     * Name
     * @var string
     */
    protected $name;

    /**
     * Blurb
     * @var string
     */
    protected $blurb;

    /**
     * Description
     * @var string
     */
    protected $description;

    /**
     * DevUrl
     * @var string
     */
    protected $devUrl;
    
    /**
     * ProdUrl
     * @var string
     */
    protected $prodUrl;
    
    /**
     * Image
     * @var string
     */
    protected $image;

    /**
     * Type
     * @var \PMS\Bundle\ProjectBundle\Entity\Type
     */
    protected $type;
    
    /**
     * Status
     * @var \PMS\Bundle\ProjectBundle\Entity\Status
     */
    protected $status;

    /**
     * Category
     * @var \PMS\Bundle\ProjectBundle\Entity\Category
     */
    protected $category;

    /**
     * Client
     * @var \PMS\Bundle\UserBundle\Entity\Client
     */
    protected $client;

    /**
     * Developers
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $developers;
    
    /**
     * Construct
     */
    public function __construct()
    {
        $this->developers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     * @param string $name
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get blurb
     * @return string
     */
    public function getBlurb()
    {
        return $this->blurb;
    }

    /**
     * Set blurb
     * @param string $blurb
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setBlurb($blurb)
    {
        $this->blurb = $blurb;

        return $this;
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     * @param type $description
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get prod url
     * @return string
     */
    public function getProdUrl()
    {
        return $this->url;
    }

    /**
     * Set prod url
     * @param string $url
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setProdUrl($url)
    {
        $this->url = $url;

        return $this;
    }
    
    /**
     * Get dev url
     * @return string
     */
    public function getDevUrl()
    {
        return $this->url;
    }

    /**
     * Set dev url
     * @param string $url
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setDevUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get status
     * @return \PMS\Bundle\ProjectBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     * @param \PMS\Bundle\ProjectBundle\Entity\Status $status
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setStatus(\PMS\Bundle\ProjectBundle\Entity\Status $status)
    {
        $this->status = $status;
        
        return $this;
    }

    /**
     * Get category
     * @return \PMS\Bundle\ProjectBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     * @param \PMS\Bundle\ProjectBundle\Entity\Category $category
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setCategory(\PMS\Bundle\ProjectBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get client
     * @return \PMS\Bundle\UserBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set client
     * @param \PMS\Bundle\UserBundle\Entity\Client $client
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function setClient(\PMS\Bundle\UserBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Add developer
     * @param \PMS\Bundle\UserBundle\Entity\Developer $developer
     * @return \PMS\Bundle\ProjectBundle\Entity\Project
     */
    public function addDeveloper(\PMS\Bundle\UserBundle\Entity\Developer $developer)
    {
        $this->developers[] = $developer;

        return $this;
    }

    /**
     * Get developers
     * @return \Doctrine\Collections\ArrayCollection
     */
    public function getDevelopers()
    {
        return $this->developers;
    }
    
    /**
     * Get developer
     * @param string $developer
     * @return \PMS\Bundle\UserBundle\Entity\Developer
     */
    public function getDeveloper($developer)
    {
        return $this->developers->get($developer);
    }

    /**
     * Remove developer
     * @param \PMS\Bundle\UserBundle\Entity\Developer $developer
     */
    public function removeDeveloper(\PMS\Bundle\UserBundle\Entity\Developer $developer)
    {
        $this->developers->removeElement($developer);
    }
}

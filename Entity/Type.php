<?php
namespace PMS\Bundle\ProjectBundle\Entity;

use \PMS\Bundle\CoreBundle\Traits\TimestampableTrait;
use \PMS\Bundle\CoreBundle\Traits\SluggableTrait;

class Type
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
     * Description
     * @var string
     */
    protected $description;
    
    /**
     * Parent
     * @var \PMS\Bundle\ProjectBundle\Entity\Type
     */
    protected $parent;
    
    /**
     * Children
     * @var \Doctrine\Common\Collections\ArrayCollection 
     */
    protected $children;

    /**
     * Projects
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $projects;
    
    /**
     * Construct
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get project
     * @param string $project
     */
    public function getProject($project)
    {
        $this->projects->get($project);
    }
    
    /**
     * Add project
     * @param \PMS\Bundle\UserBundle\Entity\Project $project
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function addProject(\PMS\Bundle\UserBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Get projects
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Remove project
     * @param \PMS\Bundle\UserBundle\Entity\Project $project
     */
    public function removeProject(\PMS\Bundle\UserBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }
    
    /**
     * Set projects
     * @param array $projects
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function setProjects(array $projects)
    {
        if (!$projects instanceof \Doctrine\Common\Collections\ArrayCollection) {
            $projects = new \Doctrine\Common\Collections\ArrayCollection($projects);
        }
        
        $this->projects = $projects;
        
        return $this;
    }
    
    /**
     * Get child
     * @param string $child
     */
    public function getChild($child)
    {
        $this->children->get($child);
    }
    
    /**
     * Add child
     * @param \PMS\Bundle\UserBundle\Entity\Project $child
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function addChild(\PMS\Bundle\UserBundle\Entity\Project $child)
    {
        $this->children->add($child);

        return $this;
    }

    /**
     * Get children
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Remove child
     * @param \PMS\Bundle\UserBundle\Entity\Project $child
     */
    public function removeChild(\PMS\Bundle\UserBundle\Entity\Project $child)
    {
        $this->children->removeElement($child);
    }
    
    /**
     * Set children
     * @param array $children
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function setChildren(array $children)
    {
        if (!$children instanceof \Doctrine\Common\Collections\ArrayCollection) {
            $children = new \Doctrine\Common\Collections\ArrayCollection($children);
        }
        
        $this->children = $children;
        
        return $this;
    }
    
    /**
     * Get parent
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Set parent
     * @param \PMS\Bundle\ProjectBundle\Entity\Type $parent
     * @return \PMS\Bundle\ProjectBundle\Entity\Type
     */
    public function setParent(\PMS\Bundle\ProjectBundle\Entity\Type $parent) {
        $this->parent = $parent;
        
        return $this;
    }
}

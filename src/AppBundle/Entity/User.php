<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr",type="string")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean",nullable=true)
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @var string
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", length=255)
     */
    private $roles;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment",mappedBy="from")
     * @var unknown
     */
    private $fromComments;
    /**
     * @ORM\OneToMany(targetEntity="Comment",mappedBy="to")
     * @var unknown
     */
    private $toComments;
    
    public function __construct()
    {
    	$this->isActive = true;
    	// may not be needed, see section on salt below
    	// $this->salt = md5(uniqid(null, true));
    	$this->toComments = new ArrayCollection();
    	$this->fromComments = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
    	if(!$this->id) return 2;
        return $this->id;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail() {
    	return $this->email;
    }
    public function setEmail($email) {
    	$this->email = $email;
    	return $this;
    }
    
    /**
     * Set roles
     *
     * @param string $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles() {
		return explode(',',$this->roles);
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt() {
		// you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;

	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		// TODO: Auto-generated method stub

	}
	
	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
				$this->id,
				$this->username,
				$this->password,
				// see section on salt below
				// $this->salt,
		));
	}
	
	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
				$this->id,
				$this->username,
				$this->password,
				// see section on salt below
				// $this->salt
				) = unserialize($serialized);
	}


	/**
	 * Add toComment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 *
	 * @return Commission
	 */
	public function addToComment(\AppBundle\Entity\Comment $comment)
	{
		$this->toComments[] = $comment;
	
		return $this;
	}
	
	/**
	 * Remove toComment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 */
	public function removeToComment(\AppBundle\Entity\Comment $comment)
	{
		$this->toComments->removeElement($comment);
	}
	
	/**
	 * Get toComments
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getToComments()
	{
		return $this->toComments;
	}

	/**
	 * Add fromComment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 *
	 * @return Commission
	 */
	public function addFromComment(\AppBundle\Entity\Comment $comment)
	{
		$this->fromComments[] = $comment;
	
		return $this;
	}
	
	/**
	 * Remove fromComment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 */
	public function removeFromComment(\AppBundle\Entity\Comment $comment)
	{
		$this->fromComments->removeElement($comment);
	}
	
	/**
	 * Get fromComments
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getFromComments()
	{
		return $this->fromComments;
	}
	
}


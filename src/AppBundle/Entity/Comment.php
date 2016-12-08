<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="fromComments")
     * @ORM\JoinColumn(name="from_user",referencedColumnName="id")
     */
    private $from;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="toComments")
     * @ORM\JoinColumn(name="to_user", referencedColumnName="id")
     */
    private $to;

    /**
     * @ORM\ManyToOne(targetEntity="Order",inversedBy="comments")
     * @ORM\JoinColumn(name="column_order",referencedColumnName="id") //, nullable=true // Here nullable is true by default
     */
    private $order;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set from
     *
     * @param \AppBundle\Entity\User $from
     *
     * @return Comment
     */
    public function setFrom(\AppBundle\Entity\User $from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \AppBundle\Entity\User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param \AppBundle\Entity\User $to
     *
     * @return Comment
     */
    public function setTo(\AppBundle\Entity\User $to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \AppBundle\Entity\User
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Commission $order
     *
     * @return Comment
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Commission
     */
    public function getOrder()
    {
        return $this->order;
    }
}

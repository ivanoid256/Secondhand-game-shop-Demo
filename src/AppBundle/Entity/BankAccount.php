<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankAccount
 *
 * @ORM\Table(name="bank_account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankAccountRepository")
 */
class BankAccount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="accountNumber", type="integer", unique=true)
     */
    private $accountNumber;

    /**
     * @ORM\Column(name="balance",type="integer")
     */
    private $balance;
    
    /**
     * @ORM\Column(name="seller", type="integer")
     */
    private $seller;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accountNumber
     *
     * @param integer $accountNumber
     *
     * @return BankAccount
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return int
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set seller
     *
     * @param integer $seller
     *
     * @return BankAccount
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return int
     */
    public function getSeller()
    {
        return $this->seller;
    }
	public function getBalance() {
		return $this->balance;
	}
	public function setBalance($balance) {
		$this->balance = $balance;
		return $this;
	}
	
}


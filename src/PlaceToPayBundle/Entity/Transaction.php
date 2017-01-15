<?php

namespace PlaceToPayBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ptp_transaction")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $bankCurrency;

	/**
     * @ORM\Column(type="string", length=3)
     */
	private $bankFactor;
	
	/**
     * @ORM\Column(type="string")
     */
	private $bankURL;

	/**
     * @ORM\Column(type="string", length=50)
     */
	private $responseCode;

	/**
     * @ORM\Column(type="string", length=60)
     */
	private $responseReasonCode;

	/**
     * @ORM\Column(type="string", length=60)
     */
	private $responseReasonText;

	/**
     * @ORM\Column(type="string", length=100)
     */
	private $returnCode;

	/**
     * @ORM\Column(type="string", length=20)
     */
	private $sessionID;

	/**
     * @ORM\Column(type="string", length=20)
     */
	private $transactionCycle;

	/**
     * @ORM\Column(type="string", length=20)
     */
	private $transactionID;

	/**
     * @ORM\Column(type="string", length=30)
     */
	private $trazabilityCode;

    /**
     * Retorna un array con los datos de la transaction
     * @return Array
     */
    public function toArray(){
        $transaction = array();

        $transaction["id"] = $this->getId();
        $transaction["bankCurrency"] = $this->getBankCurrency();
        $transaction["bankFactor"] = $this->getBankFactor();
        $transaction["bankURL"] = $this->getBankURL();
        $transaction["responseCode"] = $this->getResponseCode();
        $transaction["responseReasonCode"] = $this->getResponseReasonCode();
        $transaction["responseReasonText"] = $this->getResponseReasonText();
        $transaction["returnCode"] = $this->getReturnCode();
        $transaction["sessionID"] = $this->getSessionID();
        $transaction["transactionCycle"] = $this->getTransactionCycle();
        $transaction["transactionID"] = $this->getTransactionID();
        $transaction["trazabilityCode"] = $this->getTrazabilityCode();
        return $transaction;
    }

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
     * Set bankCurrency
     *
     * @param string $bankCurrency
     *
     * @return Transaction
     */
    public function setBankCurrency($bankCurrency)
    {
        $this->bankCurrency = $bankCurrency;

        return $this;
    }

    /**
     * Get bankCurrency
     *
     * @return string
     */
    public function getBankCurrency()
    {
        return $this->bankCurrency;
    }

    /**
     * Set bankFactor
     *
     * @param string $bankFactor
     *
     * @return Transaction
     */
    public function setBankFactor($bankFactor)
    {
        $this->bankFactor = $bankFactor;

        return $this;
    }

    /**
     * Get bankFactor
     *
     * @return string
     */
    public function getBankFactor()
    {
        return $this->bankFactor;
    }

    /**
     * Set bankURL
     *
     * @param string $bankURL
     *
     * @return Transaction
     */
    public function setBankURL($bankURL)
    {
        $this->bankURL = $bankURL;

        return $this;
    }

    /**
     * Get bankURL
     *
     * @return string
     */
    public function getBankURL()
    {
        return $this->bankURL;
    }

    /**
     * Set responseCode
     *
     * @param string $responseCode
     *
     * @return Transaction
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * Get responseCode
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set responseReasonCode
     *
     * @param string $responseReasonCode
     *
     * @return Transaction
     */
    public function setResponseReasonCode($responseReasonCode)
    {
        $this->responseReasonCode = $responseReasonCode;

        return $this;
    }

    /**
     * Get responseReasonCode
     *
     * @return string
     */
    public function getResponseReasonCode()
    {
        return $this->responseReasonCode;
    }

    /**
     * Set responseReasonText
     *
     * @param string $responseReasonText
     *
     * @return Transaction
     */
    public function setResponseReasonText($responseReasonText)
    {
        $this->responseReasonText = $responseReasonText;

        return $this;
    }

    /**
     * Get responseReasonText
     *
     * @return string
     */
    public function getResponseReasonText()
    {
        return $this->responseReasonText;
    }

    /**
     * Set returnCode
     *
     * @param string $returnCode
     *
     * @return Transaction
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * Get returnCode
     *
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Set sessionID
     *
     * @param string $sessionID
     *
     * @return Transaction
     */
    public function setSessionID($sessionID)
    {
        $this->sessionID = $sessionID;

        return $this;
    }

    /**
     * Get sessionID
     *
     * @return string
     */
    public function getSessionID()
    {
        return $this->sessionID;
    }

    /**
     * Set transactionCycle
     *
     * @param string $transactionCycle
     *
     * @return Transaction
     */
    public function setTransactionCycle($transactionCycle)
    {
        $this->transactionCycle = $transactionCycle;

        return $this;
    }

    /**
     * Get transactionCycle
     *
     * @return string
     */
    public function getTransactionCycle()
    {
        return $this->transactionCycle;
    }

    /**
     * Set transactionID
     *
     * @param string $transactionID
     *
     * @return Transaction
     */
    public function setTransactionID($transactionID)
    {
        $this->transactionID = $transactionID;

        return $this;
    }

    /**
     * Get transactionID
     *
     * @return string
     */
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * Set trazabilityCode
     *
     * @param string $trazabilityCode
     *
     * @return Transaction
     */
    public function setTrazabilityCode($trazabilityCode)
    {
        $this->trazabilityCode = $trazabilityCode;

        return $this;
    }

    /**
     * Get trazabilityCode
     *
     * @return string
     */
    public function getTrazabilityCode()
    {
        return $this->trazabilityCode;
    }
}

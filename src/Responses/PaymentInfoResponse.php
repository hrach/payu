<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Responses;

use DateTime;


class PaymentInfoResponse extends Response
{
	const STATUS_NEW = 1;
	const STATUS_CANCELLED = 2;
	const STATUS_REJECTED = 3;
	const STATUS_STARTED = 4;
	const STATUS_AWAITING_COLLECTION = 5;
	const STATUS_REJECT_DONE = 7;
	const STATUS_ENDED = 99;
	const STATUS_UNKNOWN = 888;


	/** @var int */
	protected $id;

	/** @var string */
	protected $orderId;

	/** @var number */
	protected $amount;

	/** @var string */
	protected $status;

	/** @var string */
	protected $payType;

	/** @var string */
	protected $payGwName;

	/** @var string */
	protected $desc;

	/** @var string */
	protected $desc2;

	/** @var DateTime */
	protected $create;

	/** @var DateTime */
	protected $init;

	/** @var DateTime */
	protected $sent;

	/** @var DateTime */
	protected $recv;

	/** @var DateTime */
	protected $cancel;

	/** @var string */
	protected $authFraud;


	/** @return number */
	public function getAmount()
	{
		return $this->amount;
	}


	/** @return string */
	public function getAuthFraud()
	{
		return $this->authFraud;
	}


	/** @return DateTime */
	public function getCancel()
	{
		return $this->cancel;
	}


	/** @return DateTime */
	public function getCreate()
	{
		return $this->create;
	}


	/** @return string */
	public function getDesc()
	{
		return $this->desc;
	}


	/** @return string */
	public function getDesc2()
	{
		return $this->desc2;
	}


	/** @return int */
	public function getId()
	{
		return $this->id;
	}


	/** @return DateTime */
	public function getInit()
	{
		return $this->init;
	}


	/** @return string */
	public function getOrderId()
	{
		return $this->orderId;
	}


	/** @return string */
	public function getPayGwName()
	{
		return $this->payGwName;
	}


	/** @return string */
	public function getPayType()
	{
		return $this->payType;
	}


	/** @return DateTime */
	public function getRecv()
	{
		return $this->recv;
	}


	/** @return DateTime */
	public function getSent()
	{
		return $this->sent;
	}


	/** @return int */
	public function getStatus()
	{
		return (int) $this->status;
	}


	/** @inheritdoc */
	public function isSigValid($key2)
	{
		return ($this->getSig() == md5($this->getPosId() . $this->getSessionId() . $this->getOrderId() . $this->getStatus() . $this->getAmount() . $this->getDesc() . $this->getTs() . $key2));
	}


	public function toArray()
	{
		return array(
			'id' => $this->getId(), 'orderId' => $this->getOrderId(), 'amount' => $this->getAmount(),
			'status' => $this->getStatus(), 'payType' => $this->getPayType(), 'payGwName' => $this->getPayGwName(),
			'desc' => $this->getDesc(), 'desc2' => $this->getDesc2(), 'create' => $this->getCreate(),
			'init' => $this->getInit(), 'sent' => $this->getSent(), 'recv' => $this->getRecv(),
			'cancel' => $this->getCancel(), 'authFraud' => $this->getAuthFraud(),
		);
	}

}

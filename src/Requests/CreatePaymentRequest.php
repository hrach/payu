<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;


use Nextras\PayU\Config;


class CreatePaymentRequest extends Request
{
	/** @var string */
	private $payType;

	/** @var number */
	private $amount;

	/** @var string */
	private $desc;

	/** @var string */
	private $orderId;

	/** @var string */
	private $desc2;

	/** @var string */
	private $firstName;

	/** @var string */
	private $lastName;

	/** @var string */
	private $street;

	/** @var string */
	private $streetHn;

	/** @var string */
	private $streetAn;

	/** @var string */
	private $city;

	/** @var string */
	private $postCode;

	/** @var string */
	private $country;

	/** @var string*/
	private $email;

	/** @var string */
	private $phone;

	/** @var string */
	private $language;

	/** @var string */
	private $clientIp;

	/** @var bool */
	private $js;


	/**
	 * @return string
	 */
	public function getPayType()
	{
		return $this->payType;
	}


	/**
	 * @param  string $payType
	 * @return void
	 */
	public function setPayType($payType)
	{
		$this->payType = (string) $payType;
	}


	/**
	 * @return number
	 */
	public function getAmount()
	{
		$this->amount || $this->throwRequired('amount');
		return $this->amount;
	}


	/**
	 * @param  int $amount
	 * @return void
	 */
	public function setAmount($amount)
	{
		$this->amount = (int) $amount;
	}


	/**
	 * @return string
	 */
	public function getDesc()
	{
		$this->desc || $this->throwRequired('desc');
		return $this->desc;
	}


	/**
	 * @param  string $desc
	 * @return void
	 */
	public function setDesc($desc)
	{
		$this->desc = (string) $desc;
	}


	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}


	/**
	 * @param  string $orderId
	 * @return void
	 */
	public function setOrderId($orderId)
	{
		$this->orderId = (string) $orderId;
	}


	/**
	 * @return string
	 */
	public function getDesc2()
	{
		return $this->desc2;
	}


	/**
	 * @param  string $desc2
	 * @return void
	 */
	public function setDesc2($desc2)
	{
		$this->desc2 = (string) $desc2;
	}


	/**
	 * @return string
	 */
	public function getFirstName()
	{
		$this->firstName || $this->throwRequired('firstName');
		return $this->firstName;
	}


	/**
	 * @param  string $firstName
	 * @return void
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = (string) $firstName;
	}


	/**
	 * @return string
	 */
	public function getLastName()
	{
		$this->lastName || $this->throwRequired('lastName');
		return $this->lastName;
	}


	/**
	 * @param  string $lastName
	 * @return void
	 */
	public function setLastName($lastName)
	{
		$this->lastName = (string) $lastName;
	}


	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}


	/**
	 * @param  string $street
	 * @return void
	 */
	public function setStreet($street)
	{
		$this->street = (string) $street;
	}


	/**
	 * @return string
	 */
	public function getStreetHn()
	{
		return $this->streetHn;
	}


	/**
	 * @param  string $streetHn
	 * @return void
	 */
	public function setStreetHn($streetHn)
	{
		$this->streetHn = (string) $streetHn;
	}


	/**
	 * @return string
	 */
	public function getStreetAn()
	{
		return $this->streetAn;
	}


	/**
	 * @param  string $streetAn
	 * @return void
	 */
	public function setStreetAn($streetAn)
	{
		$this->streetAn = (string) $streetAn;
	}


	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}


	/**
	 * @param  string $city
	 * @return void
	 */
	public function setCity($city)
	{
		$this->city = (string) $city;
	}


	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}


	/**
	 * @param  string $postCode
	 * @return void
	 */
	public function setPostCode($postCode)
	{
		$this->postCode = (string) $postCode;
	}


	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * Country code (2 letters) according to ISO-3166 http://www.chemie.fu-berlin.de/diverse/doc/ISO_3166.html
	 * @param  string $country
	 * @return void
	 */
	public function setCountry($country)
	{
		$this->country = (string) $country;
	}


	/**
	 * @return string
	 */
	public function getEmail()
	{
		$this->email || $this->throwRequired('email');
		return $this->email;
	}


	/**
	 * @param  string $email
	 * @return void
	 */
	public function setEmail($email)
	{
		$this->email = (string) $email;
	}


	/**
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}


	/**
	 * @param  string $phone
	 * @return void
	 */
	public function setPhone($phone)
	{
		$this->phone = (string) $phone;
	}


	/**
	 * @return string
	 */
	public function getLanguage()
	{
		$this->language || $this->throwRequired('language');
		return $this->language;
	}


	/**
	 * Language code according to ISO-639 http://www.ics.uci.edu/pub/ietf/http/related/iso639.txt
	 * @param  string $language
	 * @return void
	 */
	public function setLanguage($language)
	{
		$this->language = (string) $language;
	}


	/**
	 * @return string
	 */
	public function getClientIp()
	{
		$this->clientIp || $this->throwRequired('clientIp');
		return $this->clientIp;
	}


	/**
	 * @param  string $clientIp
	 * @return void
	 */
	public function setClientIp($clientIp)
	{
		$this->clientIp = (string) $clientIp;
	}


	/**
	 * @return boolean
	 */
	public function isJs()
	{
		return $this->js;
	}


	/**
	 * @param  bool $js
	 * @return void
	 */
	public function setJs($js)
	{
		$this->js = (bool) $js;
	}


	public function getType()
	{
		return Request::CREATE_PAYMENT;
	}


	public function getSig(Config $config)
	{
		return md5(
			dump($config->getPosId() .
			$this->getPayType() .
			$this->getSessionId() .
			$config->getPosAuthKey() .
			$this->getAmount() .
			$this->getDesc() .
			$this->getDesc2() .
			$this->getOrderId() .
			$this->getFirstName() .
			$this->getLastName() .
			$this->getStreet() .
			$this->getStreetHn() .
			$this->getStreetAn() .
			$this->getCity() .
			$this->getPostCode() .
			$this->getCountry() .
			$this->getEmail() .
			$this->getPhone() .
			$this->getLanguage() .
			$this->getClientIp() .
			$this->getTs() .
			$config->getKey1())
		);
	}


	public function getParameters()
	{
		$parameters = parent::getParameters();
		$parameters = $parameters + [
			'pay_type' => $this->getPayType(),
			'amount' => $this->getAmount(),
			'desc' => $this->getDesc(),
			'desc2' => $this->getDesc2(),
			'order_id' => $this->getOrderId(),
			'first_name' => $this->getFirstName(),
			'last_name' => $this->getLastName(),
			'street' => $this->getStreet(),
			'street_hn' => $this->getStreetHn(),
			'street_an' => $this->getStreetAn(),
			'city' => $this->getCity(),
			'post_code' => $this->getPostCode(),
			'country' => $this->getCountry(),
			'email' => $this->getEmail(),
			'phone' => $this->getPhone(),
			'language' => $this->getLanguage(),
			'client_ip' => $this->getClientIp(),
		];
		return $parameters;
	}

}

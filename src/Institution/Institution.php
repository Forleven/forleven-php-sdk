<?php

namespace Forleven\Institution;

use Forleven\Core\Http\Client\Client as HttpClient;

class Institution extends HttpClient
{
	public $exist = false;
	public $id_institution;
	public $id_owner;
	public $id_agency;
	public $name;
	public $address;
	public $number;
	public $complement;
	public $zipcode;
	public $neighborhood;
	public $city;
	public $website;
	public $type;
	public $image;
	public $description;
	public $print_image;
	public $page_link;

	function __construct()
	{
		parent::__construct();
		$this->getInstitution();
	}

	public function getInstitution()
	{
		$endpoint = '/institution/';
		$request = $this->get($endpoint);
		$request = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $request))
		{
			return null;
		}

		$this->exist = true;
		$this->setFields($request);

		return $request;
	}
}
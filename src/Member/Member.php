<?php

namespace Forleven\Member;

use Forleven\Core\Pagination\Pagination as Pagination;
use Forleven\Core\Http\Client\Client as HttpClient;

class Member extends HttpClient
{

	// From classroom
	public $number = null;

	public $id_user;
	public $id_occupation;
	public $name;
	public $lastname;
	public $registration_institution;
	public $image;
	public $minister_lesson;
	public $registration_date;
	public $exit_date;

	function __construct($id_user = null)
	{
		parent::__construct();
		$this->pagination = new Pagination();

		if($id_user)
		{
			$this->getMember($id_user);
		}
	}

	public function getMember($id_user)
	{
		$endpoint = '/member/' . $id_user;
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		$this->setFields($response);

		return $response;
	}

	public function getMembers()
	{
		$endpoint = '/member/';
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		return $response['data'];
	}
}
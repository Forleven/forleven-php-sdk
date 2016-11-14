<?php

namespace Forleven\Course;

use Forleven\Core\Http\Client\Client as HttpClient;

class Course extends HttpClient
{
	public $exist = false;

	public $id_course;
	public $id_institution;
	public $id_user_create;
	public $name;
	public $order;
	public $type;
	public $pre_registration;
	public $serie_total;
	public $serie_division_total;
	public $serie_duration;
	public $name_division;

	function __construct($id_course = null)
	{
		parent::__construct();

		if($id_course)
		{
			$this->getCourse($id_course);
		}
	}

	public function getCourse($id_course)
	{
		$endpoint = '/course/' . $id_course;
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		$this->exist = true;
		/**
		 * @see \Forleven\Core\Http\Client\Client
		 */
		$this->setFields($response);

		return $response;		
	}

	public function getCourses()
	{
		$endpoint = '/course/';
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		return $response['data'];		
	}
}
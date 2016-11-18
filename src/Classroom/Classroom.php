<?php

namespace Forleven\Classroom;

use Forleven\Core\Http\Client\Client as HttpClient;

class Classroom extends HttpClient
{
	public $exist = false;

	public $id_classroom;
	public $id_course;
	public $name;
	public $number_vacancy;
	public $room;
	public $school_stage;
	public $date_begin;
	public $nomenclature;
	public $type_serie;
	public $total_student_active;
	public $total_student;
	public $date_end_expect;
	public $date_end;
	public $pre_registration;

	function __construct($id_classroom = null)
	{
		parent::__construct();

		if($id_classroom)
		{
			$this->getClassroom($id_classroom);
		}
	}

	public function getClassroom($id_classroom)
	{
		$endpoint = '/classroom/' . $id_classroom;
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

	public function getClassrooms()
	{
		$endpoint = '/classroom/';
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		return $response['data'];		
	}
}
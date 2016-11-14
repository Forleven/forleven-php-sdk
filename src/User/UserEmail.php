<?php

namespace Forleven\User;

use Forleven\Core\Http\Client\Client as HttpClient;

class UserEmail extends HttpClient
{
	public $id_institution;
	public $name;
	public $relationship;
	public $occupation;
	public $civil_status;
	public $finance;
	public $authorized_leave;
	public $live_student;
	public $status;

	public function getEmails($id_user)
	{
		$endpoint = '/user/email/' . $id_user;
		$request = $this->get($endpoint);
		$request = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $request))
		{
			return $request['error'];
		}

		$data = $request['data'];

		return $data;
	}
}
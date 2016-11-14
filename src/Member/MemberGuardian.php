<?php

namespace Forleven\Member;

use Forleven\Core\Http\Client\Client as HttpClient;

class MemberGuardian extends HttpClient
{
	public function getGuardians($id_user)
	{
		$endpoint = '/member/guardian/' . $id_user;
		$request = $this->get($endpoint);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		$data = $response['data'];

		return $data;
	}
}
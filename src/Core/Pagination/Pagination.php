<?php

namespace Forleven\Core\Pagination;

class Pagination
{
	public $perPage = 20;
	public $numPage = 0;
	public $lastPage = null;

	public function next()
	{
		$this->numPage++;
	}

	public function previous()
	{
		if($this->numPage > 0)
		{
			$this->numPage--;
		}
	}

}
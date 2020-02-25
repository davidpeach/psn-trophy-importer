<?php

namespace App\Trophies;

use App\Trophies\Auth;

class TrophiesConnection
{
	public function __construct(Auth $auth)
	{
		$this->auth = $auth;

		$this->auth->reconnect();
	}

	public function import()
	{
		$psn = $this->auth->getConnection();
		//
	}
}
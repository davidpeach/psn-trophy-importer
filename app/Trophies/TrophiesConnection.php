<?php

namespace App\Trophies;

use App\Trophies\Auth;

class TrophiesConnection
{
	private $psn;

	public function __construct(Auth $auth)
	{
		$this->psn = $auth->reconnect()->getConnection();
	}

	public function import()
	{
		$games = $this->psn->user()->games();

		foreach ($games as $game) {
			// Up to importing game trophies
		}

	}
}
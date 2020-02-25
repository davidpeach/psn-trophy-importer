<?php

namespace App\Trophies;

use App\AccessToken;
use PlayStation\Client;

class Auth
{
	public function __construct()
	{
		$this->client = new Client;
	}

	public function firstLogin(string $accessCode)
	{
		try {
			$this->client->loginWithNpsso($accessCode);
			$this->generateRefreshToken();
			return true;
		} catch (\Exception $e) {
			\Log::error($e->getMessage());
			throw $e;
		}
	}

	public function reconnect()
	{
		$this->client->login(
			AccessToken::firstOrFail()->refresh_token
		);

		$this->generateRefreshToken();

		return $this;
	}

	public function getConnection()
	{
		return $this->client;
	}

	private function generateRefreshToken()
	{
		$refreshToken = $this->client->refreshToken();

		$access = AccessToken::first();

		if (is_null($access)) {
			$access = AccessToken::create([
				'refresh_token' => $refreshToken,
			]);
		} else {
			$access->update([
				'refresh_token' => $refreshToken,
			]);
		}
	}
}
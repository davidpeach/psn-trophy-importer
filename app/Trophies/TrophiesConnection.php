<?php

namespace App\Trophies;

use App\Game;
use App\Trophies\Auth;
use App\Trophy;
use App\TrophyGroup;

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
			if ( ! $game->hasTrophies()) {
				continue;
			}

			$gameModel = Game::where('psn_title_id', $game->titleId())->first();

			// Save the game
			if (is_null($gameModel)) {
				$gameModel = new Game;
				$gameModel->psn_title_id = $game->titleId();
				$gameModel->psn_communication_id = $game->communicationId();
				$gameModel->psn_name = $game->name();
				$gameModel->save();
			}

			foreach ($game->trophyGroups() as $trophyGroup) {

				$trophyGroupModel = TrophyGroup::where('psn_trophy_group_name', $trophyGroup->name())->first();

				if (is_null($trophyGroupModel)) {
					$trophyGroupModel = new TrophyGroup;
					$trophyGroupModel->psn_trophy_group_name = $trophyGroup->name();
					$trophyGroupModel->game_id = $gameModel->id;
					$trophyGroupModel->save();
				}

				foreach ($trophyGroup->trophies('en') as $trophy) {
					$trophyModel = Trophy::where('psn_trophy_id', $trophy->id())
						->where('trophy_group_id', $trophyGroupModel->id)
						->where('game_id', $gameModel->id)
						->first();

					if (is_null($trophyModel)) {
						$trophyModel = new Trophy;
						$trophyModel->psn_trophy_id = $trophy->id();
						$trophyModel->trophy_group_id = $trophyGroupModel->id;
						$trophyModel->game_id = $gameModel->id;
						$trophyModel->name = $trophy->name();
						$trophyModel->type = strtolower($trophy->type());
						$trophyModel->description = $trophy->detail();
						$trophyModel->earned = $trophy->earned();
						$trophyModel->earned_date = $trophy->earnedDate();
						$trophyModel->icon_url = $trophy->iconUrl();
						$trophyModel->save();
					}
				}
			}
		}

	}
}
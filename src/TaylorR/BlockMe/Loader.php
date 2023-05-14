<?php

declare(strict_types=1);

namespace TaylorR\BlockMe;

use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener {
	protected function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvent(
			PlayerMoveEvent::class,
			function (PlayerMoveEvent $event) : void {
				$player = $event->getPlayer();
				$viewers = $player->getViewers();
				if ($player->isSpectator()) {
					return;
				}
				foreach ($viewers as $viewer) {
					$p_pos = $player->getPosition();
					$v_pos = $viewer->getPosition();
					$distance = 0.5;
					if ($p_pos->distance($v_pos) <= $distance) {
						$player->knockBack(
							$p_pos->getX() - $v_pos->getX(),
							$p_pos->getZ() - $v_pos->getZ(),
							0.1
						);
					}
				}
			}, EventPriority::NORMAL, $this
		);
	}
}
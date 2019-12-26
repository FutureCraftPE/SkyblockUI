<?php

declare(strict_types=1);

namespace Yassin\SkyblockHubTp;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\Player;


class Main extends PluginBase implements Listener {

	private $config;

	public function onEnable() : void{
		$this->getLogger()->info(C::GREEN . "Plugin Loaded");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$Vars =[
			"Item"=> 117,
			"close-Text" => "je hebt de SkyblockUI geslooten"
		];
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML,$Vars);

	}
	public function onDisable() : void{
		$this->getLogger()->info(C::RED . "Plugin disabled");
	}


	public function onTouch(PlayerInteractEvent $e)
	{
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if ($api === null || $api->isDisabled()) {
			return true;
		}
		$form = $api->createSimpleForm(function (Player $player, $result) {

			if ($result === null) { // Closed form without submitting
				$player->sendMessage(C::RED . $this->config->get("close-Text"));
				return false;
			}
			switch ($result) {
				case 0:
					$this->getServer()->dispatchCommand($player, "is go");

					return true;
				case 1:
					$this->Sure($player);

					return true;
				case 2:
					$this->getServer()->dispatchCommand($player, "is create");

					return true;
			}
		});
		$player = $e->getPlayer();
		if ($e->getBlock()->getID() === $this->config->get("Item")) {
			$form->setTitle("Island UI");
			$form->setContent("\n               Island commands  \n    ");
			$form->addButton("Go to your Island");
			$form->addButton("Delete your Island");
			$form->addButton("Create Your Skyblock");
			$form->sendToPlayer($player);
			return true;
		}
	}


		public function Sure(Player $player){

			$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
			if ($api === null || $api->isDisabled()) {
				return true;
			}
			$form = $api->createSimpleForm(function (Player $player, $result) {

				if ($result === null) { // Closed form without submitting
					$player->sendMessage(C::RED . $this->config->get("close-Text"));
					return false;
				}
				switch ($result) {
					case 0:
						$this->getServer()->dispatchCommand($player, "is disband");

						return true;
				}
			});
				$form->setTitle("Island UI");
				$form->setContent("\n               Delete your island  \n    ");
				$form->addButton("Delete your Island");
				$form->addButton("Discard");
				$form->sendToPlayer($player);
				return true;
		}






}

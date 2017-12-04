<?php

namespace DonorUI;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase implements Listener {
	
    public function onEnable() {
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getServer()->getPluginManager()->disablePlugin($this);			
		}
    }
	
    public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args) : bool {
		switch($cmd->getName()){
			case "donor":
				if($sender instanceof Player) {
					$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, array $data){
					$result = $data[0];
					
					if($result === null){
						return true;
					}
						switch($result){
							case 0:
								$command = "feed";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
							break;
              
                                                        case 1:
								$command = "fly";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
							break;
								
							case 2:
								$command = "effect {player} strength 100000 0";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
							break;
						}
					});
					$form->setTitle("RebirthPE DonorUI Screen");
					$form->setContent("Please choose your command.");
					$form->addButton(TextFormat::BOLD . "Feed");	
                                        $form->addButton(TextFormat::BOLD . "Fly");	
					$form->addButton(TextFormat::BOLD . "Strength 1");	
					$form->sendToPlayer($sender);
				}
				else{
					$sender->sendMessage(TextFormat::RED . "Use this Command in-game.");
					return true;
				}
			break;
		}
		return true;
    }
}

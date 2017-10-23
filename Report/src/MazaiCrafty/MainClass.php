<?php

/*
 *
 * ___  ___               _ _____            __ _         
 * |  \/  |              (_)  __ \          / _| |        
 * | .  . | __ _ ______ _ _| /  \/_ __ __ _| |_| |_ _   _ 
 * | |\/| |/ _` |_  / _` | | |   | '__/ _` |  _| __| | | |
 * | |  | | (_| |/ / (_| | | \__/\ | | (_| | | | |_| |_| |
 * \_|  |_/\__,_/___\__,_|_|\____/_|  \__,_|_|  \__|\__, |
 *                                                   __/ |
 *                                                  |___/
 * Copyright (C) 2017 @MazaiCrafty (https://twitter.com/MazaiCrafty)
 *
 * This program is free software
 * Plugin for Pocketmine-MP
 *
 * Description:
 * It's a plugin with report.
 *
 *
 */

namespace MazaiCrafty;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;

use pocketmine\utils\Config;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\scheduler\PluginTask;

class MainClass extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!file_exists($this->getDataFolder())) {
            mkdir($this->getDataFolder(), 0744, true);
        }
        $this->report = new Config($this->getDataFolder() . "report.yml", Config::YAML);
        if (!$this->report->exists("report")) {
            $this->report->set("report", "通報");
            $this->report->save();
        }
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args)
    {
        switch (strtolower($command->getName())) {
            case 'report':
                if (!isset($args[0]))
                    return false;
                $username = $sender->getName();
                $this->report->set($args[0], $username);
                $this->report->save();
                $sender->sendMessage("送信しました");
                return true;
                break;

            case 'report.admin':
                $data    = $this->report->getAll(true);
                $dataall = implode("\n", $data);
                $sender->sendMessage("" . $dataall . "");
                return true;
                break;
        }
    }
}

<?php

namespace xRookieFight;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\utils\TextFormat;
use ReflectionClass;

class ChatEmojis extends PluginBase implements Listener
{

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("ChatEmojis.mcpack", true);

        $manager = $this->getServer()->getResourcePackManager();
        $pack = new ZippedResourcePack($this->getDataFolder() . "ChatEmojis.mcpack");

        $reflection = new ReflectionClass($manager);

        $property = $reflection->getProperty("resourcePacks");
        $property->setAccessible(true);

        $currentResourcePacks = $property->getValue($manager);
        $currentResourcePacks[] = $pack;
        $property->setValue($manager, $currentResourcePacks);

        $property = $reflection->getProperty("uuidList");
        $property->setAccessible(true);
        $currentUUIDPacks = $property->getValue($manager);
        $currentUUIDPacks[strtolower($pack->getPackId())] = $pack;
        $property->setValue($manager, $currentUUIDPacks);

        $property = $reflection->getProperty("serverForceResources");
        $property->setAccessible(true);
        $property->setValue($manager, true);
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
       if ($command->getName() == "emojilist") {
           $sender->sendMessage("Emoji List\n:kissing_heart: -> \n:nerd: -> \n:weary: -> \n:relieved: -> \n:pensive: -> \n:sob: -> \n:flushed: -> \n:joy: -> \n:sunglasses: -> \n:hot_face: -> \n:raised_eyebrow: -> \n:heart_eyes: -> \n:smirk: -> \n:slight_smile: -> \n:yum: -> \n:kekw: -> \n:clown: -> \n:bruh: -> \n:w: -> \n:gg: -> ");
       }
        return true;
    }

    public function onChat(PlayerChatEvent $event)
    {
        if ($event->getPlayer()->hasPermission("chatemojis.use")){
            switch ($event->getMessage()){
                case ":kissing_heart:":
                    $event->setMessage("");
                    break;
                case ":nerd:":
                    $event->setMessage("");
                    break;
                case ":weary:":
                    $event->setMessage("");
                    break;
                case ":pensive:":
                    $event->setMessage("");
                    break;
                case ":relieved:":
                    $event->setMessage("");
                    break;
                case ":sob:":
                    $event->setMessage("");
                    break;
                case ":flushed:":
                    $event->setMessage("");
                    break;
                case ":joy:":
                    $event->setMessage("");
                    break;
                case ":sunglasses:":
                    $event->setMessage("");
                    break;
                case ":hot_face:":
                    $event->setMessage("");
                    break;
                case ":raised_eyebrow:":
                    $event->setMessage("");
                    break;
                case ":heart_eyes:":
                    $event->setMessage("");
                    break;
                case ":smirk:":
                    $event->setMessage("");
                    break;
                case ":slight_smile:":
                    $event->setMessage("");
                    break;
                case ":yum:":
                    $event->setMessage("");
                    break;
                case ":kekw:":
                    $event->setMessage("");
                    break;
                case ":clown:":
                    $event->setMessage("");
                    break;
                case ":bruh:":
                    $event->setMessage("");
                    break;
                case ":w:":
                    $event->setMessage("");
                    break;
                case ":gg:":
                    $event->setMessage("");
                    break;
            }
        }else{
            $event->getPlayer()->sendMessage(TextFormat::RED . "You dont have permission to use chat emojis.");
            $event->cancel();
        }
    }
}
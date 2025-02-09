<?php

/*      |  __ \           | |  (_)    |  ____(_)     | |   | |
   __  _| |__) |___   ___ | | ___  ___| |__   _  __ _| |__ | |_
   \ \/ /  _  // _ \ / _ \| |/ / |/ _ \  __| | |/ _` | '_ \| __|
        | | \ \ (_) | (_) |   <| |  __/ |    | | (_| | | | | |_
   /_/\_\_|  \_\___/ \___/|_|\_\_|\___|_|    |_|\__, |_| |_|\__|
                                                 __/ |
                                                |___/

    Be yourself; everyone else is already taken.
            github.com/xRookieFight
*/

namespace xRookieFight\ChatEmojis;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack as Pack;
use pocketmine\utils\TextFormat as TF;
use ReflectionClass;
use ReflectionException;

class Main extends PluginBase implements Listener
{

    public static array $emojis = [
        ":kissing_heart:" => "",
        ":nerd:" => "",
        ":weary:" => "",
        ":pensive:" => "",
        ":relieved:" => "",
        ":sob:" => "",
        ":flushed:" => "",
        ":joy:" => "",
        ":sunglasses:" => "",
        ":hot_face:" => "",
        ":raised_eyebrow:" => "",
        ":heart_eyes:" => "",
        ":smirk:" => "",
        ":slight_smile:" => "",
        ":yum:" => "",
        ":kekw:" => "",
        ":clown:" => "",
        ":bruh:" => "",
    ];

    /**
     * @throws ReflectionException
     */

    public function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("ChatEmojis.mcpack", true);
        $manager = $this->getServer()->getResourcePackManager();
        $pack = new Pack($this->getDataFolder() . "ChatEmojis.mcpack");
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
           $sender->sendMessage(TF::AQUA."ChatEmojis Emoji List\n".TF::YELLOW."Made by xRookieFight");
           foreach (self::$emojis as $emojis => $unicode) {
               $sender->sendMessage($emojis . " -> " . $unicode."\n");
           }
           }
        return true;
    }

    public function onChat(PlayerChatEvent $event)
    {
        if ($event->getPlayer()->hasPermission("chatemojis.use")){
            $event->setMessage(
                str_replace(array_keys(self::$emojis),
                    array_values(self::$emojis),
                    $event->getMessage())
            );
        }else{
            $event->getPlayer()->sendMessage(TF::RED . "You don't have permission to use chat emojis.");
            $event->cancel();
        }
    }
}
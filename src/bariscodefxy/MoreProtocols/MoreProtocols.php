<?php

/**
 * Copyright (c) 2022 bariscodefx
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace bariscodefxy\MoreProtocols;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

/**
 * MoreProtocols plugin
 *
 * @author bariscodefx
 * @version 0.0.1
 */
class MoreProtocols extends PluginBase implements Listener {

    /**
     * @var Config $config
     */
    private Config $config;

    /**
     * @var array $allowed_protocols
     */
    private array $allowed_protocols = [];

    /**
     * Runs on when plugin enabled
     *
     * @return void
     */
    public function onEnable() : void {
        $this->getServer()->getLogger()->info("[MoreProtocols] Plugin activated.");
        $this->config = new Config($this->getDataFolder() . "Config.yml", Config::YAML, [
            "allowed-protocols" => [
                ProtocolInfo::CURRENT_PROTOCOL
            ],
        ],);
        $this->allowed_protocols = $this->config->get('allowed-protocols');
    }

    /**
     * Runs on when plugin disabled
     *
     * @return void
     */
    public function onDisable() : void {
        $this->getServer()->getLogger()->info("[MoreProtocols] Plugin de-activated.");
    }

    /**
     * @param DataPacket $packet
     * @return void
     */
    public function DataPacketReceiveEvent(DataPacket $packet){
        $pk = $packet->getPacket(); // getting packet
        if(!($pk instanceof LoginPacket)) return; // if not a LoginPacket
        if(in_array($pk->protocol, $this->allowed_protocols)) $pk->protocol = ProtocolInfo::CURRENT_PROTOCOL; // allow join to server
    }

}

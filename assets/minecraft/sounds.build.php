<?php
/*
 *  Starving is a open source bukkit/spigot mmo game.
 *  Copyright (C) 2014-2015 Matej Kormuth
 *  This file is a part of Starving. <http://www.starving.eu>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
error_reporting(-1);
ini_set('display_errors', 'On');

echo "[SCRIPT] Building sounds.json...\n";
$SOUNDS = dirname(__DIR__) . "/minecraft/sounds";

$jsonobj = new stdClass();

// Firearms
$firearms = array_diff(scandir($SOUNDS . "/firearms/"), array('.', '..', '.gitkeep'));
foreach($firearms as $firearm) {
	echo "[SCRIPT] $firearm\n";
	// Fire
	$obj = new stdClass();
	$files = array_diff(scandir($SOUNDS . "/firearms/" . $firearm . "/"), array('.', '..', '.gitkeep'));
	foreach($files as $file) {
		if(strpos($file,'fire') !== false) {
			$sound = "/firearms/" . $firearm . "/" . str_replace('.ogg', '', $file);
			$obj->sounds[] = $sound;
			echo "[SCRIPT]  - " . $sound . "\n";
		}
	}
	$jsonobj->{"$firearm" . "_fire"} = $obj;
	
	// Reload
	$obj = new stdClass();
	$files = array_diff(scandir($SOUNDS . "/firearms/" . $firearm . "/"), array('.', '..', '.gitkeep'));
	foreach($files as $file) {
		if(strpos($file,'reload') !== false) {
			$sound = "/firearms/" . $firearm . "/" . str_replace('.ogg', '', $file);
			$obj->sounds[] = $sound;
			echo "[SCRIPT]  - " . $sound . "\n";
		}
	}
	$jsonobj->{"$firearm" . "_reload"} = $obj;
}
// Back up old sounds.json
echo "[SCRIPT] Backing up old sounds.json...\n";
copy(dirname(__DIR__) . "/minecraft/sounds.json", dirname(__DIR__) . "/minecraft/sounds.json.bak");
// Write new.
file_put_contents(dirname(__DIR__) . "/minecraft/sounds.json", json_encode($jsonobj, JSON_PRETTY_PRINT));
echo "[SCRIPT] File sounds.json was successfully built!\n";
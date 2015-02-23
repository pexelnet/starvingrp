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

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
}

function invokedir($dir) {
	echo "[BUILD] Scanning directory " . basename($dir) . "...\n";
	$files = array_diff(scandir($dir), array('.', '..', '.gitkeep'));
	foreach($files as $file) {
		if(is_file($dir . "/" . $file)) {
			if(strpos($file,'build') !== false) {
				echo "[BUILD] Executing build script $file...\n";
				echo "[BUILD] ========================================\n";
				require_once $dir . "/" . $file;
				echo "[BUILD] ========================================\n";
			}
		} 
		
		if(is_dir($dir . "/" . $file)) {
			invokedir($dir . "/" . $file);
		}
	}
}
echo "[BUILD] ========================================\n";
echo "[BUILD] Starving build of Starving 2.0 Resource Pack...\n";
echo "[BUILD] Started at " . date("d.M.Y H:m") . "\n";
echo "[BUILD] ========================================\n";
// Start!
invokedir(dirname(__FILE__) . "/assets/");
echo "[BUILD] Build finished!\n";
echo "[BUILD] Build finished!\n";
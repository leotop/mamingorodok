<?php
/**
 * Autoloader.php - memod
 * Initial version by: BeforyDeath
 * Initial version created on: 30.12.13 12:31
 * Taken from here {@link http://habrahabr.ru/post/132736/}
 */

namespace classes;

class Autoloader
{
	const debug = 0;
	const path = '/memod';

	public function __construct() {
	}

	public static function autoload($file) {
		$file = str_replace('\\', '/', $file);
		$path = $_SERVER['DOCUMENT_ROOT'] . Autoloader::path;
		$filepath = $_SERVER['DOCUMENT_ROOT'] . Autoloader::path . '/' . $file . '.php';

		if (file_exists($filepath)) {
			Autoloader::StPutFile(('подключили ' . $filepath));
			require_once($filepath);
		} else {
			$flag = true;
			Autoloader::StPutFile(('начинаем рекурсивный поиск ' . $file));
			Autoloader::recursive_autoload($file, $path, $flag);
		}
	}

	public static function recursive_autoload($file, $path, $flag) {
		if (false !== ($handle = opendir($path)) && $flag) {
			while (false !== ($dir = readdir($handle)) && $flag) {
				if (strpos($dir, '.') === false) {
					$path2 = $path . '/' . $dir;
					$filepath = $path2 . '/' . $file . '.php';
					Autoloader::StPutFile(('ищем файл <b>' . $file . '</b> in ' . $filepath));
					if (file_exists($filepath)) {
						Autoloader::StPutFile(('подключили ' . $filepath));
						$flag = false;
						require_once($filepath);
						break;
					}
					Autoloader::recursive_autoload($file, $path2, $flag);
				}
			}
			closedir($handle);
		}
	}

	private static function StPutFile($data) {
		if (Autoloader::debug) {
			$dir = $_SERVER['DOCUMENT_ROOT'] . '/runtime/autoloader_log.html';
			$file = fopen($dir, 'a');
			flock($file, LOCK_EX);
			fwrite($file, (date('d.m.Y H:i:s') . ' : ' . $_SERVER['REMOTE_ADDR'] . ' : ' . $data . '<br/>' . PHP_EOL));
			flock($file, LOCK_UN);
			fclose($file);
		}
	}
}

\spl_autoload_register('classes\Autoloader::autoload');
<?php

namespace Vesninandrey\Casperjs;

use Exception;
use \Intervention\Image\ImageManager;

/**
 * Class Casperjs
 * @package Vesninandrey\Casperjs
 */

class Casperjs {

	private $casperjs_bin;

	public function __construct(){
		$this->casperjs_bin = \Config::get('casperjs::main.casperjs_bin');
	}

	public function exec( $instructions ) {
		$tempJsFileHandle = tmpfile();

		array_unshift($instructions, 'var casper = require(\'casper\').create({verbose: true, logLevel: "debug", waitTimeout : 5000});');
		$instructions[] = 'casper.run();';

		fwrite($tempJsFileHandle, implode(' ', $instructions));
        $tempFileName = stream_get_meta_data($tempJsFileHandle)['uri'];
		$cmd          = escapeshellcmd( "{$this->casperjs_bin} " . $tempFileName );
		$stdout       = shell_exec( $cmd );
		fclose( $tempJsFileHandle );

		return $stdout;

	}

	public function __toString(){
		return var_export($this, true);
	}
}
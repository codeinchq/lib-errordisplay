<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE - CONFIDENTIAL                                |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     15/12/2017
// Time:     13:07
// Project:  lib-exceptiondisplay
//
namespace CodeInc\ExceptionDisplay\RenderingEngines;


/**
 * Class AbstractRenderingEngine
 *
 * @package CodeInc\ExceptionDisplay\RenderingEngines
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
abstract class AbstractRenderingEngine implements RenderingEngineInterface {
	/**
	 * @var \Exception
	 */
	private $exception;

	/**
	 * @var bool
	 */
	private $verboseMode;

	/**
	 * CLIExceptionDisplay constructor.
	 *
	 * @param \Exception $exception
	 * @param bool $verboseMode
	 */
	public function __construct(\Exception $exception, bool $verboseMode = null) {
		$this->exception = $exception;
		$this->verboseMode = $verboseMode ?? false;
	}

	/**
	 * Sets the parent exception.
	 *
	 * @param \Exception $exception
	 */
	protected function setException(\Exception $exception) {
		$this->exception = $exception;
	}

	/**
	 * Returns the exception to be rendered.
	 *
	 * @return \Exception
	 */
	public function getException():\Exception {
		return $this->exception;
	}

	/**
	 * Verifies if the verbose mode is enabled.
	 *
	 * @return bool
	 */
	public function isVerboseModeEnabled():bool {
		return $this->verboseMode;
	}

	/**
	 * Sets the verbose mode.
	 *
	 * @param bool $verboseMode
	 */
	protected function setVerboseMode(bool $verboseMode) {
		$this->verboseMode = $verboseMode;
	}

	/**
	 * Returns the view's HTML source code
	 *
	 * @return string
	 */
	public function get():string {
		ob_start();
		$this->render();
		return ob_get_clean();
	}

	/**
	 * Alias of get()
	 *
	 * @see AbstractRenderingEngine::get()
	 * @return string
	 */
	public function __toString():string {
		try {
			return $this->get();
		}
		catch (\Exception $exception) {
			return "Error: ".$exception->getMessage();
		}
	}
}
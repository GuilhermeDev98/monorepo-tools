<?php

namespace SS6\CoreBundle\Model\Product\Exception;

use Exception;

class ProductNotFoundException extends Exception implements ProductException {
	
	public function __construct($criteria) {
		parent::__construct('Transport not found by criteria ' . var_export($criteria, true), 0, null);
	}
	
}

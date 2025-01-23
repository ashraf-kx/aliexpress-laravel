<?php

namespace Shacz\AliExpressSDK;

use Exception;

class IopRequest
{
	private string $apiName;
	private array $headerParams = array();
	private array $udfParams = array();
	private array $fileParams = array();
	private string $httpMethod = 'POST';
    private string $simplify = 'false';
    private string $format = 'json';

	public function getApiName() : string
	{
		return $this->apiName;
	}

	public function getHeaderParams() : array
	{
		return $this->headerParams;
	}

	public function getUdfParams() : array
	{
		return $this->udfParams;
	}

	public function getFileParams() : array
	{
		return $this->fileParams;
	}

	public function getHttpMethod() : string
	{
		return $this->httpMethod;
	}

	public function getSimplify() : string
	{
		return $this->simplify;
	}

	public function getFormat() : string
	{
		return $this->format;
	}

	public function __construct($apiName, $httpMethod = 'POST')
	{
		$this->apiName = $apiName;
		$this->httpMethod = $httpMethod;		

		if($this->startWith($apiName,"//"))
		{
			throw new Exception("api name is invalid. It should be start with /");			
		}
	}

	function addApiParam($key,$value)
	{

		if(!is_string($key))
		{
			throw new Exception("api param key should be string");
		}

		if(is_object($value))
		{
			$this->udfParams[$key] = json_decode($value);
		}
		else
		{
			$this->udfParams[$key] = $value;
		}
	}

	function addFileParam($key,$content,$mimeType = 'application/octet-stream')
	{
		if(!is_string($key))
		{
			throw new Exception("api file param key should be string");
		}

		$file = array(
            'type' => $mimeType,
            'content' => $content,
            'name' => $key
        );
		$this->fileParams[$key] = $file;
	}

	function addHttpHeaderParam($key,$value)
	{
		if(!is_string($key))
		{
			throw new Exception("http header param key should be string");
		}

		if(!is_string($value))
		{
			throw new Exception("http header param value should be string");
		}

		$this->headerParams[$key] = $value;
	}

	function startWith($str, $needle) {
	    return strpos($str, $needle) === 0;
	}
}
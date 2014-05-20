<?php

namespace PhrestAPI\Responses;

use Phalcon\DI;

class Response
{

  /** @var ResponseMeta */
  private $meta;

  /** @var ResponseMessage[] */
  private $messages;

  /** @var bool Is a head request */
  protected $isHEAD = false;

  public function __construct()
  {
    $this->meta = new ResponseMeta();
  }

  /**
   * Called by Phalcon, todo see if can get rid of it
   */
  protected function isSent(){}

  /**
   * @return ResponseMessage[]
   */
  public function getMessages()
  {
    return $this->messages;
  }

  /**
   * @return ResponseMeta
   */
  public function getMeta()
  {
    return $this->meta;
  }

  /**
   * @param ResponseMeta $meta
   *
   * @return $this
   */
  public function setMeta(ResponseMeta $meta)
  {
    $this->meta = $meta;

    return $this;
  }

  /**
   * @param $count
   */
  public function setMetaCount($count)
  {
    $this->meta->count = $count;
  }

  /**
   * Set the status code
   *
   * @param int    $code
   * @param string $message
   *
   * @return \Phalcon\Http\ResponseInterface
   */
  public function setStatusCode($code, $message)
  {
    $this->meta->statusCode = $code;
    $this->meta->statusMessage = $message;

    return parent::setStatusCode($code, $message);
  }

  /**
   * Add a message to the response object
   *
   * @param        $text
   * @param string $type
   *
   * @return $this
   */
  public function addMessage($text, $type = ResponseMessage::TYPE_SUCCESS)
  {
    $this->messages[] = new ResponseMessage(
      $text,
      $type
    );

    return $this;
  }

  /**
   * @param \Exception $exception
   *
   * @throws \Exception
   */
  public function sendException(\Exception $exception)
  {
    throw $exception;
  }

  /**
   * Get the object data (public properties)
   *
   * @return mixed
   */
  public function getData()
  {
    // todo return json_decode(json_encode($this)); may be quicker

    return call_user_func('get_object_vars', $this);
  }
}

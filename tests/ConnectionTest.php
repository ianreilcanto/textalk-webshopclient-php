<?php

use Textalk\ApiClient\Connection;

class ConnectionTest extends PHPUnit_Framework_TestCase {
  public function testGetDefaultInstance() {
    $connection = Connection::getDefault();
    $this->assertInstanceOf('Textalk\ApiClient\Connection', $connection);

    $connection2 = Connection::getDefault();
    $this->assertSame($connection, $connection2);
  }

  public function testSimpleCall() {
    $connection = Connection::getDefault(array('webshop' => 22222));

    $article_uids = $connection->call('Assortment.getArticleUids', array(1347898));

    $this->assertInternalType('array', $article_uids);
  }

  public function testMethodNotFound() {
    try {
      $connection = Connection::getDefault(array('webshop' => 22222));
      $dummy = $connection->call('Foo.bar', array());
    }
    catch (Textalk\ApiClient\Exception\MethodNotFound $e) {
      $request_json = $e->getRequestJson();
      $this->assertInternalType('string', $request_json);

      $request = json_decode($request_json);

      // $request should be the jsonrpc
      $this->assertInternalType('object', $request);
      $this->assertObjectHasAttribute('id',      $request);
      $this->assertObjectHasAttribute('jsonrpc', $request);
      $this->assertEquals('Foo.bar', $request->method);

      $this->assertEquals('wss://shop.textalk.se/backend/jsonrpc/v1/?webshop=22222',
                          $e->getRequestUri());
    }

    $this->assertNotNull($e, 'A Textalk\ApiClient\Exception\MethodNotFound should be thrown.');
  }

  // testChangeContext

  // testExceptionDebugInfo (containing URI and full request)
}
<?php 
require_once '../../server/api/sbooker/config.php';
require_once '../../server/api/sbooker/Library/Controller.php';
require_once '../../server/api/sbooker/Library/DbConnection.php';
require_once '../../server/api/sbooker/Library/Model.php';
require_once '../../server/api/sbooker/Model/RoomModel.php';
require_once '../../server/api/sbooker/Controller/Room.php';
require_once 'DbHelper.php';

class RoomTest extends PHPUnit_Framework_TestCase
{
    protected $objRoomController;
    
    protected $helper;

    protected function setUp()
    {
        $this->objRoomController = new Room();
        $this->helper = new DbHelper();
    }

    protected function tearDown()
    {
        $this->objRoomController = NULL;
        $this->helper = NULL;
    }

    public function testgetAllRoom()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();
        $res = $this->objRoomController->getAllRoom();
        $this->assertInternalType('array', $res);
        $this->assertTrue(count($res['data'])>0);
        //var_dump($res);
        //$this->assertTrue(count($res));
      //  $this->assertInternalType('array', $res['data']);
      //  $this->assertTrue(count($res['data']));
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
    }

    public function testgetItemRoom()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();
        $res = $this->objRoomController->getItemRoom([roomId]);
        $this->assertInternalType('array', $res);
        $this->assertArrayHasKey('data', $res);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
    }
}


<?php 
require_once '../../server/api/sbooker/config.php';
require_once '../../server/api/sbooker/Library/Controller.php';
require_once '../../server/api/sbooker/Library/DbConnection.php';
require_once '../../server/api/sbooker/Library/Model.php';
require_once '../../server/api/sbooker/Model/EventModel.php';
require_once '../../server/api/sbooker/Controller/Event.php';
require_once 'DbHelper.php';

class EventTest extends PHPUnit_Framework_TestCase
{
    protected $objEventController;
    
    protected $helper;

    protected function setUp()
    {
        $this->objEventController = new Event();
        $this->helper = new DbHelper();
    }

    protected function tearDown()
    {
        $this->objEventController = NULL;
        $this->helper = NULL;
    }

    public function testgetItemEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $start = (new DateTime())->modify('+6 monthes')->setTime(8,0)->getTimestamp();
        $startDate = (new DateTime())->setTimestamp($start);
        $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
        $startFormat = $start->format('d.m.y H:i:s');
        $endFormat = $end->format('d.m.y H:i:s');
        
        $this->helper->executeQuery('INSERT INTO eventBooker 
         ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
         `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
         ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 0)');
        $eventId = $this->helper->getPdo()->lastInsertId();

        $res = $this->objEventController->getItemEvent();
        $this->assertInternalType('array', $res);
        $this->assertInternalType('array', $res['data']);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        $this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$eventId);
    }

    /*
    public function testgetDataEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $mod = ['-1 day', '+0 day','+1 day'];
        $insId = [];
        for($i =0; $i<3; $i++){
            $start = (new DateTime())->modify($mod[$i])->setTime(8,0)->getTimestamp();
            $startDate = (new DateTime())->setTimestamp($start);
            $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
            $startFormat = $start->format('d.m.y H:i:s');
            $endFormat = $end->format('d.m.y H:i:s');
            
            $this->helper->executeQuery('INSERT INTO eventBooker 
            ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
            `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
            ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 0)');
            $insId[] =  $this->helper->getPdo()->lastInsertId(); 
        }
        $y = (new DateTime())->format('y');
        $m = (new DateTime())->format('m');
        $curMonth = (new DateTime())->setDate($y, $m, 1);
        $dayCurMonth = date("t");

        $res = $this->objEventController->getDataEvent([$roomId, curMonth, dayCurMonth]);
        $this->assertInternalType('array', $res);
        $this->assertTrue(count($res['data'])>0);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        for($i = 0; $i<3; $i++)
            $this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$insId[$i]);
    }
    */

    /*
    public function testdeleteEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $start = (new DateTime())->modify('+6 monthes')->setTime(8,0)->getTimestamp();
        $startDate = (new DateTime())->setTimestamp($start);
        $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
        $startFormat = $start->format('d.m.y H:i:s');
        $endFormat = $end->format('d.m.y H:i:s');
        
        $this->helper->executeQuery('INSERT INTO eventBooker 
         ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
         `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
         ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 0)');
        $eventId = $this->helper->getPdo()->lastInsertId();

        $res = $this->objEventController->deleteEvent([$eventId, 0]);
        $this->assertInternalType('array', $res);
        $this->assertEquals($res['data']==1);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        //$this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$eventId);
    }
    */

    /*
    public function testdeleteEventRec()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $mod = ['-1 day', '+0 day','+1 day'];
        $insId = [];
        for($i =0; $i<3; $i++){
            $start = (new DateTime())->modify($mod[$i])->setTime(8,0)->getTimestamp();
            $startDate = (new DateTime())->setTimestamp($start);
            $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
            $startFormat = $start->format('d.m.y H:i:s');
            $endFormat = $end->format('d.m.y H:i:s');
            
            if($i == 0){
                $this->helper->executeQuery('INSERT INTO eventBooker 
                ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
                `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
                ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 1)');
                $insId[] =  $this->helper->getPdo()->lastInsertId(); 
            }else{
                $this->helper->executeQuery('INSERT INTO eventBooker 
                ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
                `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
                ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', '. $insId[0].', 0)');
                $insId[] =  $this->helper->getPdo()->lastInsertId(); 
            }
        }

        $res = $this->objEventController->deleteEvent([$eventId, 1]);
        $this->assertInternalType('array', $res);
        $this->assertEquals($res['data']>0);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
    }
    */

    /*
    public function testpostEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $start = (new DateTime())->modify('+6 monthes')->setTime(8,0)->getTimestamp();
        $startDate = (new DateTime())->setTimestamp($start);
        $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();

        $res = $this->objEventController->postEvent([
           'user_id'=>$userId,
           'room_id'=>$roomId,
           'description'=>"test event",
           'start_event'=>$start,
           'end_event'=>$end,
           'day_event'=>$startDate,
           'is_repeate'=>false,
           'recur_period'=>NULL,
           'duration'=>NULL
            ]);

        $eventId = $this->helper->getPdo()->lastInsertId();   

        $this->assertInternalType('array', $res);  
        $this->assertEquals($res['data']['count']==1);  


        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        $this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$eventId);
    }
    */


    /*
    public function testcheckEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $start = (new DateTime())->modify('+6 monthes')->setTime(8,0)->getTimestamp();
        $startDate = (new DateTime())->setTimestamp($start);
        $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
        $startFormat = $start->format('d.m.y H:i:s');
        $endFormat = $end->format('d.m.y H:i:s');
        
        $this->helper->executeQuery('INSERT INTO eventBooker 
         ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
         `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
         ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 0)');
        $eventId = $this->helper->getPdo()->lastInsertId();

        $res = $this->objEventController->checkEvent(
            ['start_event'=>$start,
            'end_event'=>$end,
            'day_event'=>$startDate,
            'room_id'=>$roomId
           ]
        );
        $this->assertFalse($res);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        $this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$eventId);
    }
    */

    /*
    public function testupdateItemEvent()
    {
        $this->helper->executeQuery('INSERT INTO roomBooker (name) VALUES ("testRoom")');
        $roomId = $this->helper->getPdo()->lastInsertId();

        $password = 'sampas';
        $pass = md5($password);
        $str= 'passsolt';
        $str = md5($str);
        $passwordDb =  md5($password.$str);
        $randStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $rand = '';
        for($i=0; $i<5; $i++) 
        {
            $key = rand(0, strlen($randStr)-1);
            $rand .= $randStr[$key];
        }
        $status =  md5($rand);
        $timeLife =  time()+LIFE_ACTIVE_LOGIN;

        $this->helper->executeQuery('INSERT INTO userBooker '.
        '( `fullname`, `login`, `password`, `email`, `role_id`, `status`, `time_life`) VALUES '.
        '("sam", "samlog", '.$passwordDb.', "sam@gmail.com", 1, '.$status.', '.$timeLifesa.')');
        $userId = $this->helper->getPdo()->lastInsertId();

        $start = (new DateTime())->modify('+6 monthes')->setTime(8,0)->getTimestamp();
        $startDate = (new DateTime())->setTimestamp($start);
        $end = (new DateTime())->setTimestamp($start)->setTime(8,30)->getTimestamp();
        
        $this->helper->executeQuery('INSERT INTO eventBooker 
         ( `user_id`, `room_id`, `description`, `start_event`, `start_event_format`, 
         `end_event`, `end_event_format`, `data_create`, `parent_event_id`, `is_repeat`) VALUES
         ('.$userId.', '.$roomId.', "testing event", '.$start.', '.$startFormat.', '.$end.', '.$endFormat.', '. $startDate.', NULL, 0)');
        $eventId = $this->helper->getPdo()->lastInsertId();

        $res = $this->objEventController->updateItemEvent(
            $eventId, $start, $end, $startDate, $roomId, 'new description', $userId
        );
        $this->assertInternalType('array', $res);
        $this->assertEquals($res['data']['count']==1);
   
        $this->helper->executeQuery('DELETE FROM userBooker WHERE id = '.$userId);
        $this->helper->executeQuery('DELETE FROM roomBooker WHERE id = '.$roomId);
        $this->helper->executeQuery('DELETE FROM eventBooker WHERE id = '.$eventId);
    }
    */

}


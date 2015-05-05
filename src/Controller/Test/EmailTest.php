<?

namespace Cleanify\Controller\Test;

use Cleanify\Controller as Controller;

include '../../../vendor/autoload.php';

class EmailTest extends \PHPUnit_Framework_TestCase
{
//    protected $myEmail = 'thanh.pham@yahoo.com';

    public function setUp(){
        $this->email = new Controller\Email();

    }

    /**
     * @test
     */
    public function testSendEmailWithArray()
    {
          $this->assertNotEmpty($this->email->sendEmail(array($this->myEmail, 'asdf')));

    }
}
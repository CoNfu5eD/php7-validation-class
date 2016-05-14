<?php

require_once "Validate.php";

/**
 * User: Marcel 'CoNfu5eD Naeve <confu5ed@serious-pro.de>
 * Date: 14.05.2016
 * Time: 11:25
 */
class ValidateTest extends PHPUnit_Framework_TestCase
{
    /*
     * Validate::email(); Tests
     */
    public function testEmail_myEmail_level1()
    {
        $result = Validate::email("confu5ed@serious-pro.de");
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level2()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 2);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level1_whitelisted()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 1,["whitelist"=>["confu5ed@serious-pro.de"]]);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level1_not_in_whitelist()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 1,["whitelist"=>["confu5ed@serious-pro.eu"]]);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level1_blacklisted()
    {
        $result = Validate::email("confu5ed@serious-pro.de",1,["blacklist"=>["confu5ed@serious-pro.de"]]);
        $this->assertFalse($result);
    }
    public function testEmail_myEmail_level1_not_in_blacklist()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 1,["blacklist"=>["confu5ed@serious-pro.eu"]]);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level2_whitelisted()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 2,["whitelist"=>["confu5ed@serious-pro.de"]]);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level2_not_in_whitelist()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 2,["whitelist"=>["confu5ed@serious-pro.eu"]]);
        $this->assertTrue($result);
    }
    public function testEmail_myEmail_level2_blacklisted()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 2,["blacklist"=>["confu5ed@serious-pro.de"]]);
        $this->assertFalse($result);
    }
    public function testEmail_myEmail_level2_not_in_blacklist()
    {
        $result = Validate::email("confu5ed@serious-pro.de", 2,["blacklist"=>["confu5ed@serious-pro.eu"]]);
        $this->assertTrue($result);
    }

    public function testEmail_random1_level1()
    {
        $result = Validate::email("tempus.lorem.fringilla@vitae.co.uk");
        $this->assertTrue($result);
    }
    public function testEmail_random2_level1()
    {
        $result = Validate::email("Etiam.ligula@et.com");
        $this->assertTrue($result);
    }
    public function testEmail_random3_level1()
    {
        $result = Validate::email("orci.tincidunt.adipiscing@famesacturpis.edu");
        $this->assertTrue($result);
    }
    public function testEmail_random4_level1()
    {
        $result = Validate::email("_______@example.com");
        $this->assertTrue($result);
    }
    public function testEmail_random5_level1()
    {
        $result = Validate::email("nonummy.Fusce.fermentum@ut.org");
        $this->assertTrue($result);
    }
    public function testEmail_random6_level1()
    {
        $result = Validate::email('"email"@example.com');
        $this->assertTrue($result);
    }
    public function testEmail_random7_level1()
    {
        $result = Validate::email('much."more\ unusual"@example.com');
        $this->assertTrue($result);
    }
    public function testEmail_random8_level1()
    {
        $result = Validate::email('very.unusual."@".unusual.com@example.com');
        $this->assertTrue($result);
    }
    public function testEmail_random9_level1()
    {
        $result = Validate::email('very."(),:;<>[]".VERY."very@\\"very".unusual@strange.example.com');
        $this->assertTrue($result);
    }
    public function testEmail_random10_level2()
    {
        $result = Validate::email('very."(),:;<>[]".VERY."very@\\"very".unusual@serious-pro.de', 2);
        $this->assertTrue($result);
    }

    public function testEmail_invalid1_level1()
    {
        $result = Validate::email("me@me@serious-pro.de");
        $this->assertFalse($result);
    }
    public function testEmail_invalid2_level1()
    {
        $result = Validate::email("me me@serious-pro.de");
        $this->assertFalse($result);
    }
    public function testEmail_invalid3_level1()
    {
        $result = Validate::email("me@serious pro.de");
        $this->assertFalse($result);
    }



}

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

    /*
     * Validate::ipv4(); Tests
     */
    public function testIPv4_v4_localhost()
    {
        $this->assertTrue( Validate::ipv4("127.0.0.1") );
    }
    public function testIPv4_v4_network()
    {
        $this->assertTrue( Validate::ipv4("192.168.178.1") );
    }
    public function testIPv4_v4_googledns1()
    {
        $this->assertTrue( Validate::ipv4("8.8.8.8") );
    }
    public function testIPv4_v4_googledns2()
    {
        $this->assertTrue( Validate::ipv4("8.8.4.4") );
    }
    public function testIPv4_v4_mask()
    {
        $this->assertTrue( Validate::ipv4("255.255.255.255") );
    }
    public function testIPv4_v4_zero()
    {
        $this->assertTrue( Validate::ipv4("0.0.0.0") );
    }
    public function testIPv4_v4_tomuch()
    {
        $this->assertFalse( Validate::ipv4("256.255.255.255") );
    }
    public function testIPv4_domain()
    {
        $this->assertFalse( Validate::ipv4("serious-pro.de") );
    }
    public function testIPv4_v6_localhost()
    {
        $this->assertFalse( Validate::ipv4("::1") );
    }
    public function testIPv4_v6_googledns1()
    {
        $this->assertFalse( Validate::ipv4("2001:4860:4860::8888") );
    }
    public function testIPv4_v6_googledns2()
    {
        $this->assertFalse( Validate::ipv4("2001:4860:4860::8844") );
    }

    /*
     * Validate::ipv6(); Tests
     */
    public function testIPv6_v4_localhost()
    {
        $this->assertFalse( Validate::ipv6("127.0.0.1") );
    }
    public function testIPv6_v4_network()
    {
        $this->assertFalse( Validate::ipv6("192.168.178.1") );
    }
    public function testIPv6_v4_googledns1()
    {
        $this->assertFalse( Validate::ipv6("8.8.8.8") );
    }
    public function testIPv6_v4_googledns2()
    {
        $this->assertFalse( Validate::ipv6("8.8.4.4") );
    }
    public function testIPv6_v4_mask()
    {
        $this->assertFalse( Validate::ipv6("255.255.255.255") );
    }
    public function testIPv6_v4_zero()
    {
        $this->assertFalse( Validate::ipv6("0.0.0.0") );
    }
    public function testIPv6_v4_tomuch()
    {
        $this->assertFalse( Validate::ipv6("256.255.255.255") );
    }
    public function testIPv6_domain()
    {
        $this->assertFalse( Validate::ipv6("serious-pro.de") );
    }
    public function testIPv6_v6_localhost()
    {
        $this->assertTrue( Validate::ipv6("::1") );
    }
    public function testIPv6_v6_googledns1()
    {
        $this->assertTrue( Validate::ipv6("2001:4860:4860::8888") );
    }
    public function testIPv6_v6_googledns2()
    {
        $this->assertTrue( Validate::ipv6("2001:4860:4860::8844") );
    }

    /*
     * Validate::ip(); Tests
     */
    public function testIP_v4_localhost()
    {
        $this->assertTrue( Validate::ip("127.0.0.1") );
    }
    public function testIP_v4_network()
    {
        $this->assertTrue( Validate::ip("192.168.178.1") );
    }
    public function testIP_v4_googledns1()
    {
        $this->assertTrue( Validate::ip("8.8.8.8") );
    }
    public function testIP_v4_googledns2()
    {
        $this->assertTrue( Validate::ip("8.8.4.4") );
    }
    public function testIP_v4_mask()
    {
        $this->assertTrue( Validate::ip("255.255.255.255") );
    }
    public function testIP_v4_zero()
    {
        $this->assertTrue( Validate::ip("0.0.0.0") );
    }
    public function testIP_v4_tomuch()
    {
        $this->assertFalse( Validate::ip("256.255.255.255") );
    }
    public function testIP_domain()
    {
        $this->assertFalse( Validate::ip("serious-pro.de") );
    }
    public function testIP_v6_localhost()
    {
        $this->assertTrue( Validate::ip("::1") );
    }
    public function testIP_v6_googledns1()
    {
        $this->assertTrue( Validate::ip("2001:4860:4860::8888") );
    }
    public function testIP_v6_googledns2()
    {
        $this->assertTrue( Validate::ip("2001:4860:4860::8844") );
    }
    public function testIP_empty()
    {
        $this->assertFalse( Validate::ip("") );
    }
    public function testIP_trash1()
    {
        $this->assertFalse( Validate::ip("%") );
    }
    public function testIP_trash2()
    {
        $this->assertFalse( Validate::ip("~") );
    }
    public function testIP_trash3()
    {
        $this->assertFalse( Validate::ip("@") );
    }

}

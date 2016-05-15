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

    /*
     * Validate::mac(); Tests
     */
    public function testMac_random_valid11()
    {
        $this->assertTrue( Validate::mac("ce:bb:ac:22:9e:72") );
    }
    public function testMac_random_valid12()
    {
        $this->assertTrue( Validate::mac("ce-bb-ac-22-9e-72") );
    }
    public function testMac_random_valid13()
    {
        $this->assertTrue( Validate::mac("cebb.ac22.9e72") );
    }
    public function testMac_random_valid21()
    {
        $this->assertTrue( Validate::mac("77:a8:7a:bf:45:6f") );
    }
    public function testMac_random_valid22()
    {
        $this->assertTrue( Validate::mac("77-a8-7a-bf-45-6f") );
    }
    public function testMac_random_valid23()
    {
        $this->assertTrue( Validate::mac("77a8.7abf.456f") );
    }
    public function testMac_invalid1()
    {
        $this->assertFalse( Validate::mac("58-E4-C8-C3-5G-23") );
    }
    public function testMac_invalid2()
    {
        $this->assertFalse( Validate::mac("58-E4-C8-C3-5-23") );
    }
    public function testMac_invalid3()
    {
        $this->assertFalse( Validate::mac("58-E4-C8-C3-23") );
    }
    public function testMac_invalid4()
    {
        $this->assertFalse( Validate::mac("58-E4-C8-23") );
    }
    public function testMac_empty()
    {
        $this->assertFalse( Validate::mac("") );
    }
    public function testMac_trash1()
    {
        $this->assertFalse( Validate::mac("%") );
    }
    public function testMac_trash2()
    {
        $this->assertFalse( Validate::mac("-") );
    }
    public function testMac_trash3()
    {
        $this->assertFalse( Validate::mac(".") );
    }
    public function testMac_trash4()
    {
        $this->assertFalse( Validate::mac(":") );
    }

    /*
     * Validate::range(); Tests
     */
    public function testRange_int1() {
        $this->assertTrue( Validate::range(23, 20, 25) );
    }
    public function testRange_int2() {
        $this->assertTrue( Validate::range(0, -1, 3) );
    }
    public function testRange_int3() {
        $this->assertFalse( Validate::range(-50, -1, 3) );
    }
    public function testRange_float1() {
        $this->assertTrue( Validate::range(2.3, 2.0, 2.5) );
    }
    public function testRange_float2() {
        $this->assertTrue( Validate::range(0.0, -0.1, 0.3) );
    }
    public function testRange_float3() {
        $this->assertFalse( Validate::range(-5.0, -0.1, 0.3) );
    }
    public function testRange_int_in_float1() {
        $this->assertTrue( Validate::range(2, 1.9, 2.1) );
    }
    public function testRange_int_in_float2() {
        $this->assertTrue( Validate::range(0, -0.1, 0.3) );
    }
    public function testRange_int_in_float3() {
        $this->assertFalse( Validate::range(5, -0.1, 0.3) );
    }
    public function testRange_float_in_int1() {
        $this->assertTrue( Validate::range(2.1, 2, 3) );
    }
    public function testRange_float_in_int2() {
        $this->assertTrue( Validate::range(0.1, 0, 1) );
    }
    public function testRange_float_in_int3() {
        $this->assertFalse( Validate::range(-5.5, -5, 0) );
    }

    /*
     * Validate::iban(); Tests
     */


    /*
     * Validate::swift(); Tests
     */


}

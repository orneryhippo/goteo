<?php

namespace Goteo\Library\Tests;

use Goteo\Model\Template;
use Goteo\Library\Mail;

class MailTest extends \PHPUnit_Framework_TestCase {
    /**
     * Ensures has the correct instances
     */
    public function testInstance() {
        $mail = new Mail();
        $this->assertInstanceOf('\Goteo\Library\Mail', $mail);
        $this->assertInstanceOf('\PHPMailer', $mail->mail);
        return $mail;
    }

    /**
     * Test validate function
     * @depends testInstance
     */
    public function testValidate($mail) {

        $mail->subject = "A test subject";
        $mail->content = "A test content";
        $mail->to = 'non-valid-email';
        $this->assertFalse($mail->validate());

        $mail->to = 'test@goteo.org';
        $this->assertTrue($mail->validate($errors), implode("\n", $errors));

        return $mail;
    }

    /**
     * @depends testValidate
     */
    public function testMessage($mail) {
        $mailer = $mail->buildMessage();
        $this->assertInstanceOf('\PHPMailer', $mailer);

        $this->assertEquals('test@goteo.org', $mailer->getToAddresses()[0][0]);

        $this->assertContains('<img src="' . SITE_URL . '/goteo_logo.png" alt="Logo" />', $mailer->Body);
        $this->assertContains('<title>Goteo Mailer</title>', $mailer->Body);
    }

    /**
     * @depends testValidate
     */
    public function testNewsletterMessage($mail) {
        $mail->template = Template::NEWSLETTER;
        $mailer = $mail->buildMessage();
        // este test no funciona si no hay base de datos
        $this->assertContains('/user/unsubscribe', $mailer->Body);
        $this->assertContains('<img src="' . SITE_URL . '/goteo_logo.png" alt="Logo" />', $mailer->Body);
        $this->assertContains('<title>Goteo Newsletter</title>', $mailer->Body);
    }

    public function testToken($mail) {
        $mail = new Mail();
        $mail->to = 'test@goteo.org';
        $mail->id = 12345;
        $token = $mail->getToken();
        $decoded = Mail::decodeToken($token);
        $this->assertEquals('test@goteo.org', $decoded[1]);
        $this->assertEquals(12345, $decoded[2]);

        $this->assertTrue(empty(Mail::decodeToken('invalid¬token')));
    }

    public function testCreateText() {
        $mail = Mail::createFromText('test@goteo.org', 'Test', 'Subject', "Body\nsecond line");
        $mailer = $mail->buildMessage();
        $this->assertInstanceOf('\PHPMailer', $mailer);
        $this->assertEquals('test@goteo.org', $mailer->getToAddresses()[0][0]);
        $this->assertEquals('Test', $mailer->getToAddresses()[0][1]);
        $this->assertEquals('Subject', $mailer->Subject);
        $this->assertEmpty($mailer->isHTML());
        $this->assertContains("Body\nsecond line", $mailer->Body);
        $this->assertContains($mail->getToken(), $mailer->Body);
    }

    public function testCreateHtml() {
        $mail = Mail::createFromHtml('test@goteo.org', 'Test', 'Subject', "Body<br>second line");
        $mailer = $mail->buildMessage();
        $this->assertInstanceOf('\PHPMailer', $mailer);
        $this->assertEquals('test@goteo.org', $mailer->getToAddresses()[0][0]);
        $this->assertEquals('Test', $mailer->getToAddresses()[0][1]);
        $this->assertEquals('Subject', $mailer->Subject);
        $this->assertEmpty($mailer->isHTML());
        $this->assertContains("Body<br>second line", $mailer->Body);
        $this->assertContains("Body\nsecond line", $mailer->AltBody);
        $this->assertContains($mail->getToken(), $mailer->Body);
    }

    public function testCreateTemplate() {
        $tpl = Template::get(Template::NEWSLETTER);
        $mail = Mail::createFromTemplate('test@goteo.org', 'Test', Template::NEWSLETTER);
        $mailer = $mail->buildMessage();
        $this->assertInstanceOf('\PHPMailer', $mailer);
        $this->assertEquals('test@goteo.org', $mailer->getToAddresses()[0][0]);
        $this->assertEquals('Test', $mailer->getToAddresses()[0][1]);
        $this->assertEquals($tpl->title, $mailer->Subject);
        $this->assertEmpty($mailer->isHTML());
        $this->assertContains($tpl->text, $mailer->Body);
        $this->assertContains(preg_replace("/[\n]{2,}/", "\n\n" ,strip_tags(str_ireplace(['<br', '<p'], ["\n<br", "\n<p"], $tpl->text))), $mailer->AltBody);
        $this->assertContains($mail->getToken(), $mailer->Body);
    }

}

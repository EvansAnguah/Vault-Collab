<?php
namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mailer - PHPMailer Wrapper
 * Handles all email sending operations
 */
class Mailer {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        // SMTP Configuration
        $this->mailer->isSMTP();
        $this->mailer->Host       = SMTP_HOST;
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = SMTP_USERNAME;
        $this->mailer->Password   = SMTP_PASSWORD;
        $this->mailer->SMTPSecure = SMTP_ENCRYPTION;
        $this->mailer->Port       = SMTP_PORT;

        // Default From
        $this->mailer->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';
    }

    /**
     * Send a generic email
     */
    public function send($to, $subject, $body, $altBody = '') {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $this->wrapInTemplate($subject, $body);
            $this->mailer->AltBody = $altBody ?: strip_tags($body);

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    /**
     * Send email verification link
     */
    public function sendVerificationEmail($to, $name, $token) {
        $verifyUrl = APP_URL . '/verify-email?token=' . $token;
        
        $body = "
            <h2>Welcome to " . APP_NAME . ", {$name}!</h2>
            <p>Thank you for registering. Please verify your email address to activate your account.</p>
            <div style='text-align:center; margin: 30px 0;'>
                <a href='{$verifyUrl}' style='background: linear-gradient(135deg, #0ea5e9, #14b8a6); color: white; padding: 14px 32px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; display: inline-block;'>
                    Verify Email Address
                </a>
            </div>
            <p style='color: #64748b; font-size: 14px;'>If the button doesn't work, copy and paste this link into your browser:</p>
            <p style='color: #0ea5e9; word-break: break-all; font-size: 14px;'>{$verifyUrl}</p>
            <p style='color: #94a3b8; font-size: 13px; margin-top: 20px;'>This link expires in 24 hours.</p>
        ";

        return $this->send($to, 'Verify Your Email - ' . APP_NAME, $body);
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($to, $name, $token) {
        $resetUrl = APP_URL . '/reset-password?token=' . $token;
        
        $body = "
            <h2>Password Reset Request</h2>
            <p>Hello {$name},</p>
            <p>We received a request to reset your password. Click the button below to create a new password.</p>
            <div style='text-align:center; margin: 30px 0;'>
                <a href='{$resetUrl}' style='background: linear-gradient(135deg, #0ea5e9, #14b8a6); color: white; padding: 14px 32px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; display: inline-block;'>
                    Reset Password
                </a>
            </div>
            <p style='color: #64748b; font-size: 14px;'>If you didn't request this, you can safely ignore this email.</p>
            <p style='color: #94a3b8; font-size: 13px; margin-top: 20px;'>This link expires in 1 hour.</p>
        ";

        return $this->send($to, 'Reset Your Password - ' . APP_NAME, $body);
    }

    /**
     * Send notification email
     */
    public function sendNotification($to, $name, $title, $message, $actionUrl = null, $actionText = 'View Details') {
        $actionButton = '';
        if ($actionUrl) {
            $actionButton = "
                <div style='text-align:center; margin: 30px 0;'>
                    <a href='{$actionUrl}' style='background: linear-gradient(135deg, #0ea5e9, #14b8a6); color: white; padding: 12px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;'>
                        {$actionText}
                    </a>
                </div>
            ";
        }

        $body = "
            <h2>{$title}</h2>
            <p>Hello {$name},</p>
            <p>{$message}</p>
            {$actionButton}
        ";

        return $this->send($to, $title . ' - ' . APP_NAME, $body);
    }

    /**
     * Wrap email body in a branded HTML template
     */
    private function wrapInTemplate($subject, $body) {
        $appName = APP_NAME;
        $universityName = UNIVERSITY_NAME;
        $year = date('Y');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$subject}</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #0f172a; font-family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='min-height: 100vh;'>
                <tr>
                    <td align='center' style='padding: 40px 20px;'>
                        <!-- Header -->
                        <table width='600' cellspacing='0' cellpadding='0' style='max-width: 600px;'>
                            <tr>
                                <td style='text-align: center; padding-bottom: 30px;'>
                                    <div style='display: inline-block; background: linear-gradient(135deg, #0ea5e9, #14b8a6); padding: 12px 24px; border-radius: 12px;'>
                                        <span style='color: white; font-size: 20px; font-weight: 700; letter-spacing: -0.5px;'>⚓ {$appName}</span>
                                    </div>
                                </td>
                            </tr>
                            <!-- Content Card -->
                            <tr>
                                <td style='background: #1e293b; border-radius: 16px; padding: 40px; border: 1px solid #334155;'>
                                    <div style='color: #e2e8f0; font-size: 16px; line-height: 1.6;'>
                                        {$body}
                                    </div>
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td style='text-align: center; padding-top: 30px;'>
                                    <p style='color: #64748b; font-size: 13px; margin: 0;'>{$universityName}</p>
                                    <p style='color: #475569; font-size: 12px; margin: 5px 0 0;'>© {$year} {$appName}. All rights reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";
    }
}

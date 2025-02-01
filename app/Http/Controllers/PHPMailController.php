<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

class PHPMailController extends Controller
{

    static function  sendMail(Request $request)
    {
        $mail = new PHPMailer(true);

        $settings = Setting::where('key', 'like', 'notification.%')
            ->get()
            ->pluck('value', 'key');

        if ($settings['notification.email_notifications_enabled'] != 1) {
            return false;
        }

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = $settings['notification.email_smtp_server'];
            $mail->SMTPAuth = true;
            $mail->Username = $settings['notification.email_smtp_username'];
            $mail->Password = $settings['notification.email_smtp_password'];
            $mail->SMTPSecure = $settings['notification.email_encryption'];
            $mail->Port = $settings['notification.email_smtp_port'];

            $mail->setFrom($settings['notification.email_sender_address'], $settings['notification.email_sender_name']);

            $mail->isHTML(true);

            if (isset($request->admin_subject) && isset($request->admin_body)) {
                $mail->addAddress($settings['notification.email_sender_address']);
                $mail->Subject = $request->admin_subject;
                $mail->Body = $request->admin_body;

                if (!$mail->send()) {
                    Log::info('Mailer Error: ' . $mail->ErrorInfo);
                    return false;
                }
            }

            if (isset($request->client_subject) && isset($request->client_body)) {
                $mail->clearAllRecipients();
                $mail->addAddress($request->email);
                $mail->Subject = $request->client_subject;
                $mail->Body = $request->client_body;

                if (isset($request->client_attachment) && !empty($request->client_attachment) && file_exists($request->client_attachment)) {
                    $mail->addAttachment($request->client_attachment);
                }

                if (!$mail->send()) {
                    Log::info('Mailer Error: ' . $mail->ErrorInfo);
                    return false;
                }
            }
        } catch (Exception $e) {
            Log::info('Mailer Errorpp: ' . $e->getMessage());
            return false;
        }

        return true;
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // System settings
        DB::table('settings')->insert([
            ['key' => 'website.site_name', 'value' => 'My Website'],
            ['key' => 'website.site_light_logo', 'value' => 'logo_light.png'],
            ['key' => 'website.site_dark_logo', 'value' => 'logo_dark.png'],
            ['key' => 'website.site_favicon', 'value' => 'favicon.ico'],

            ['key' => 'website.meta_title', 'value' => 'My Website'],
            ['key' => 'website.meta_description', 'value' => 'Welcome to My Website, the best place for digital content.'],
            ['key' => 'website.meta_keywords', 'value' => 'digital content, online resources, best website, web platform'],
            ['key' => 'website.meta_author', 'value' => 'Nadun Pramodya'],

            ['key' => 'website.google_analytics_code', 'value' => 'UA-12345678-1'],
        ]);

        // Payment settings
        DB::table('settings')->insert([
            ['key' => 'payment.payment_gateway', 'value' => 'payhere'],

            // PayHere API credentials
            ['key' => 'payment.payhere_merchant_id', 'value' => 'your_payhere_merchant_id'],
            ['key' => 'payment.payhere_secret_key', 'value' => 'your_payhere_secret_key'],
            ['key' => 'payment.payhere_url', 'value' => 'https://www.payhere.lk/checkout'],

            ['key' => 'payment.currency', 'value' => 'LKR'],
            ['key' => 'payment.tax_rate', 'value' => '0.10'],
            ['key' => 'payment.refund_policy', 'value' => 'No refunds after 30 days'],
            ['key' => 'payment.bank_name', 'value' => 'Bank 01'],
            ['key' => 'payment.bank_info', 'value' => 'XXXXXXXXX'],
            ['key' => 'payment.delivery_fee', 'value' => '800'],
        ]);

        // Notification settings
        DB::table('settings')->insert([
            // Email settings
            ['key' => 'notification.email_notifications_enabled', 'value' => '1'],
            ['key' => 'notification.email_sender_name', 'value' => 'Your Website Name'],
            ['key' => 'notification.email_sender_address', 'value' => 'no-reply@mywebsite.com'],
            ['key' => 'notification.email_smtp_server', 'value' => 'smtp.yourwebmailserver.com'],
            ['key' => 'notification.email_smtp_port', 'value' => '587'],
            ['key' => 'notification.email_smtp_username', 'value' => 'your_email_username'],
            ['key' => 'notification.email_smtp_password', 'value' => 'your_email_password'],
            ['key' => 'notification.email_encryption', 'value' => 'tls'],

            // SMS settings
            ['key' => 'notification.sms_notifications_enabled', 'value' => '1'],
            ['key' => 'notification.sms_provider', 'value' => 'dialog_sms'],
            ['key' => 'notification.sms_sender_id', 'value' => 'YourSenderID'],
            ['key' => 'notification.sms_api_key', 'value' => 'your_dialog_sms_api_key'],
            ['key' => 'notification.sms_api_url', 'value' => 'https://e-sms.dialog.lk/api/v1/message-via-url/create/url-campaign'],

            // ['key' => 'notification.sms_template_login_otp_verify', 'value' => 'Dear {student_first_name},
            //     Your OTP for login to {institute_name} is {otp_code}. Please use this code to access your account.
            //     This code is valid for 5 minutes.
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_register_otp_verify', 'value' => 'Dear {student_first_name},
            //     Your OTP for registration on {institute_name} is {otp_code}. Please enter this code to complete your signup process.
            //     This code is valid for 10 minutes.
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_welcome', 'value' => 'Dear {student_first_name},
            //     Welcome to {institute_name}! We are excited to have you on board. Start exploring your courses and learning journey today.
            //     Visit: {website_link}
            //     For support, contact us at {contact_number}.
            //     Thank you,
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_offline_payment', 'value' => 'Dear {student_first_name},
            //     Your offline payment of {amount} for {class_name} has been successfully confirmed. You are now enrolled in the course.
            //     Thank you for choosing {institute_name}.
            //     For details, visit: {website_link}
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_offline_payment_reject', 'value' => 'Dear {student_first_name},
            //     Your offline payment of {amount} for {class_name} could not be confirmed. Please verify your payment details or contact support for assistance.
            //     Contact: {contact_number}
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_online_payment', 'value' => 'Dear {student_first_name},
            //     Your online payment of {amount} for {class_name} has been successfully received. Your enrollment is now active.
            //     Start learning: {website_link}
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_class_renew_reminder', 'value' => 'Dear {student_first_name},
            //     Your subscription for {class_name} is expiring soon. Renew now to continue accessing your classes for the next month.
            //     For support, contact us at {contact_number}.
            //     Renew here: {renewal_link}
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_start_meeting', 'value' => 'Dear {student_first_name},
            //     Your class {class_name} is starting now on Zoom.
            //     Join here: {meeting_link}
            //     Meeting ID: {meeting_id}
            //     Passcode: {meeting_password}
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_class_approval', 'value' => 'Dear {instructor_name},
            //     Your edit request for the class {class_name} has been approved by the admin. The changes are now updated in the system.
            //     Thank you for your contribution to {institute_name}.
            //     Team {institute_name}'],
            // ['key' => 'notification.sms_template_class_rejected', 'value' => 'Dear {instructor_name},
            //     Your edit request for the class {class_name} has been approved by the admin. The changes are now updated in the system.
            //     For support, contact us at {contact_number}.
            //     Thank you for your contribution to {institute_name}.
            //     Team {institute_name}'],
        ]);
    }
}

<?php

return [

    'MailName' => env("MAIL_FROM_NAME", "University of Kragujevac - ERASMUS+ Application Portal"),
    'MailSenderAddress' => env("MAIL_FROM_ADDRESS", "applicationportal12@gmail.com"),
    'VerificationLinkExpiryMinutes' => env("VERIFICATION_LINK_EXPIRY_MINUTES", 5),
    'VerifyEmailLink' => env("CLIENT_URL", "http://localhost:4200/").'verify/',
    'ResetPasswordLink' => env("CLIENT_URL", "http://localhost:4200/").'reset-password/',
    'VerifyEmailHTMLTemplate' => 'emails.verify_email',
    'VerifyEmailTextTemplate' => 'emails.verify_email_plain',
    'ResetPasswordHTMLTemplate' => 'emails.reset_password',
    'ResetPasswordTextTemplate' => 'emails.reset_password_plain',
    'FileFormatsDelimiter' => '|',
    'ImageFormats' => 'jpg|jpeg|png',
    'DocumentFormats' => 'pdf',
    'VideoFormats' => 'mp4|mov|wmv|asf|avi|flv|mkv',
    'FileSize' => 10,
    'VideoSize' => 200,
    'ResizeRate' => 3,
    'ImageCompressionQuality' => 40,
    'ResizePixelsLimit' => 5000,
    'FormsInfo' => [
        'personal-details' =>'personal_details',
        'home-institution' => 'home_institution',
        'proposed-host-universities' => 'proposed_host_universities',
        'motivation-and-added-value' => 'motivation_and_added_value',
        'documents-upload' => 'documents_upload'
    ]
];

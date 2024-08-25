<?php

return [

    'MailName' => env("MAIL_FROM_NAME", "University of Kragujevac - ERASMUS+ Application Portal"),
    'MailSenderAddress' => env("MAIL_FROM_ADDRESS", "applicationportal12@gmail.com"),
    'VerificationLinkExpiryMinutes' => env("VERIFICATION_LINK_EXPIRY_MINUTES", 5),
    'ApplicationLink' => env("CLIENT_URL", "http://localhost:4200/") . 'application-data/',
    'VerifyEmailLink' => env("CLIENT_URL", "http://localhost:4200/").'verify/',
    'ResetPasswordLink' => env("CLIENT_URL", "http://localhost:4200/").'reset-password/',
    'VerifyEmailHTMLTemplate' => 'emails.verify_email',
    'VerifyEmailTextTemplate' => 'emails.verify_email_plain',
    'ResetPasswordHTMLTemplate' => 'emails.reset_password',
    'ResetPasswordTextTemplate' => 'emails.reset_password_plain',
    'PendingApplicationHTMLTemplate' => 'emails.pending_application',
    'PendingApplicationTextTemplate' => 'emails.pending_application_plain',
    'CompletedApplicationHTMLTemplate' => 'emails.completed_application',
    'CompletedApplicationTextTemplate' => 'emails.completed_application_plain',
    'RejectedApplicationHTMLTemplate' => 'emails.rejected_application',
    'RejectedApplicationTextTemplate' => 'emails.rejected_application_plain',
    'DocumentsRequiredApplicationHTMLTemplate' => 'emails.documents_required_application',
    'DocumentsRequiredApplicationTextTemplate' => 'emails.documents_required_application_plain',
    'FileFormatsDelimiter' => '|',
    'ImageFormats' => 'jpg|jpeg|png',
    'DocumentFormats' => 'pdf',
    'VideoFormats' => 'mp4|mov|wmv|asf|avi|flv|mkv',
    'VideoDocument' => 'video',
    'FileSize' => 30,
    'VideoSize' => 200,
    'ResizeRate' => 3,
    'ImageCompressionQuality' => 40,
    'ResizePixelsLimit' => 5000,
    'FormsInfo' => [
        'personal-details' => 'personal_details',
        'home-institution' => 'home_institution',
        'proposed-host-universities' => 'proposed_host_universities',
        'motivation-and-added-value' => 'motivation_and_added_value',
        'documents-upload' => 'documents_upload'
    ]
];

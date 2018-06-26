<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAx4Od9wA:APA91bF36DOGHdkgh9yvhSBUa1ZNK7DU9HeGXByQg8tz9SKTvGh4Vy6_MnR8VZstYIkXdpx7bmXmjZvu7WqNeZDAvoOQ-zzC5o-CbJ2hbPN5ZMMz77dONjoXqS8KI71iG90kstyiB0c-1p0LdKBGqfQEcrlU9JE8Rw'),
        'sender_id' => env('FCM_SENDER_ID', '856906659584'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];

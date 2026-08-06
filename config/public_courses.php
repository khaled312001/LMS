<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Publicly accessible courses (no login required)
    |--------------------------------------------------------------------------
    |
    | Course IDs listed here can be watched by visitors without signing in or
    | enrolling. Everything else keeps the normal auth + enrollment rules.
    | Progress tracking, forum and certificates stay logged-in only.
    |
    */

    'ids' => [
        27, // تعلم البرمجة من الصفر (free preparatory course)
    ],

    /*
    | Legacy slugs that must 301 to the course's current slug, so already
    | indexed URLs keep working after a slug is renamed.
    */
    'legacy_slugs' => [
        'تعلم-البرمجة-من-الصفر' => 27,
    ],

];

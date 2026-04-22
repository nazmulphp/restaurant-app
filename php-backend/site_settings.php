<?php
require_once __DIR__ . '/helpers.php';

$defaults = [
    'site_name' => 'Cosmic Burger',
    'site_tagline' => 'Flipping the script on fast food.',
    'contact_phone' => '+1 (555) COSMIC 1',
    'contact_email' => 'hello@cosmicburger.space',
    'contact_address' => '123 Orbit Avenue, Star City',
    'hero_title' => 'Taste the Multiverse',
    'hero_text' => 'Fresh burgers, fast checkout, and a smooth online order flow powered by your own database.',
    'hero_button_text' => 'Order Now',
    'promo_code' => 'COSMIC20',
    'currency_symbol' => '$',
    'footer_text' => 'Flipping the script on fast food since 2024. Join the revolution and taste the multiverse.',
    'instagram_url' => '#',
    'facebook_url' => '#',
    'twitter_url' => '#',
    'business_hours' => 'Daily 10:00 AM to 11:00 PM'
];

$settings = [];
foreach ($defaults as $key => $value) {
    $settings[$key] = get_setting($key, $value);
}

json_response(['success' => true, 'settings' => $settings]);

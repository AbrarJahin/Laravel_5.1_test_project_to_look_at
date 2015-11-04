<?php

use App\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaults = [
            [
                'subject' => 'Reminder 3 hours',
                'content' => 'Reminder 3h',
                'user_id' => 0
            ],
            [
                'subject' => 'Reminder 6 hours',
                'content' => 'Reminder 6h',
                'user_id' => 0
            ],
            [
                'subject' => 'Reminder 1 day',
                'content' => 'Reminder 1d',
                'user_id' => 0
            ],
            [
                'subject' => 'Custom',
                'content' => '',
                'user_id' => 0
            ]

        ];

		foreach ($defaults as $default) {
			NotificationTemplate::create($default);
		}

	}
}

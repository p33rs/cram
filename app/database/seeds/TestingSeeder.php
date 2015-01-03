<?php

use Faker\Factory as Faker;

class TestingSeeder extends Seeder {

    const NUM_USERS = 10;
    const PASSWORD = '12345678a';

    // per user
    const MIN_PHOTOS = 0;
    const MAX_PHOTOS = 3;

    // per user; follows, not followers
    const MIN_FOLLOWS = 0;
    const MAX_FOLLOWS = 8;

    // per photo; random user, random text
    const MIN_COMMENTS = 0;
    const MAX_COMMENTS = 10;

    // per photo; random user
    const MIN_LIKES = 0;
    const MAX_LIKES = 20;

    // set bounds for X/Y dims of images
    const IMG_MIN = 200;
    const IMG_MAX = 1200;
    // the X will usually be within this % of the Y, except
    const IMG_STD_DEV = 20;
    // for this amount of time.
    const IMG_OUTLIER_CHANCE = 5;

    private $faker;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        if (!$this->faker) {
            $this->faker = Faker::create();
        }

        ($this
            ->seedUsers()
            ->seedPhotos()
            ->seedComments()
            ->seedFollows()
            ->seedLikes()
        );
        $this->command->info('Testing seed complete.');
	}

    private function seedUsers()
    {
        DB::table('users')->delete();
        for ($i = 1; $i <= self::NUM_USERS; $i++) {
            User::create([
                'id' => $i,
                'username' => $this->faker->username,
                'firstname' => $this->faker->firstName,
                'lastname' => $this->faker->lastName,
                'email' => $this->faker->safeEmail,
                'password' => Hash::make(self::PASSWORD)
            ]);
        }
        return $this;
    }

    private function seedPhotos()
    {
        DB::table('photos')->delete();
        File::deleteDirectory(Photo::uploadPath(), true);
        $users = User::all();
        foreach($users as $user) {
            $limit = mt_rand(self::MIN_PHOTOS, self::MAX_PHOTOS);
            for ($i = 0; $i < $limit; $i++) {
                $x = mt_rand(self::IMG_MIN, self::IMG_MAX);
                $y = mt_rand(0, 100) > self::IMG_OUTLIER_CHANCE
                    ? mt_rand($x - $x * self::IMG_STD_DEV / 100, $x + $x * self::IMG_STD_DEV / 100)
                    : mt_rand(self::IMG_MIN, self::IMG_MAX);
                $filename = basename($this->faker->image(
                    Photo::uploadPath(),
                    $x,
                    $y
                ));
                $user->photos()->save(new Photo([
                    'filename' => $filename,
                    'title' => $this->faker->sentence(mt_rand(1,5)),
                    'caption' => $this->faker->paragraph(mt_rand(0,6)),
                ]));
            }
        }
        return $this;
    }

    private function seedComments()
    {
        DB::table('comments')->delete();
        $photos = Photo::all();
        $users = User::all();
        foreach ($photos as $photo) {
            $limit = mt_rand(self::MIN_COMMENTS, self::MAX_COMMENTS);
            for ($i = 0; $i < $limit; $i++) {
                $user = $users->random();
                $photo->comments()->save(new Comment([
                    'text' => $this->faker->paragraph(mt_rand(1,8)),
                    'user_id' => $user->getKey()
                ]));
            }
        }
        return $this;
    }

    private function seedFollows()
    {
        DB::table('follows')->delete();
        $users = User::all();
        foreach ($users as $follower) {
            $limit = mt_rand(self::MIN_FOLLOWS, self::MAX_FOLLOWS);
            if (!$limit) {
                continue;
            } elseif ($limit > $users->count()) {
                $limit = $users->count();
            }
            $followees = $users->random($limit);
            if (!is_array($followees)) {
                $followees = [$followees];
            }
            foreach ($followees as $followee) {
                // skip self-follow
                if ($follower->getKey() == $followee->getKey()) {
                    continue;
                }
                // use sync instead of attach to prevent dupes
                $follower->following()->sync([$followee->getKey()], false);
            }
        }
        return $this;
    }

    private function seedLikes()
    {
        DB::table('likes')->delete();
        $photos = Photo::all();
        $users = User::all();
        foreach ($photos as $photo) {
            $limit = mt_rand(self::MIN_LIKES, self::MAX_LIKES);
            if (!$limit) {
                continue;
            } elseif ($limit > $users->count()) {
                $limit = $users->count();
            }
            $likers = $users->random($limit);
            if (!is_array($likers)) {
                $likers = [$likers];
            }
            foreach ($likers as $liker) {
                // skip self-like
                if ($liker->getKey() == $photo->user->getKey()) {
                    continue;
                }
                // use sync instead of attach to prevent dupes
                $photo->likers()->sync([$liker->getKey()], false);
            }
        }
        return $this;
    }

}

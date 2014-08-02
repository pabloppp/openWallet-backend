<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
        $this->call('OAuth_ClientTableSeeder');
        $this->call('CategoryTableSeeder');

	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('badge_tag')->delete();
        DB::table('tags')->delete();
        DB::table('accounts')->delete();
        DB::table('account_types')->delete();
        DB::table('user_badge')->delete();
        DB::table('users')->delete();
        DB::table('badges')->delete();
        DB::table('issuers')->delete();

        $pass = Hash::make('aaa');

        $newUser = User::create(array('username' => 'pablo', 'password' => $pass, 'email' => "pablo@pernias.com"));
        $newUser2 = User::create(array('username' => 'roxanne', 'password' => $pass, 'email' => "roxannelopez6@hormail.com"));

        $mozillaAccount = AccountType::create(array('id' => 'mozilla', 'name' => 'Mozilla OpenBadges'));
        $addedAccount = new Account(array('name'=>'aaa','secret'=>'ccc'));
        $addedAccount->withUserAndType($newUser,$mozillaAccount)->push();

        $firstBadge = new Badge(array(
            'version' =>'1.0',
            'name' =>'OpenWallet Noob',
            'description' =>'You just registered! Yay! Thanks...',
            'criteria' =>'http://openwallet.io/show/badge/',
            'image_remote' =>'http://sm.ingenieriamultimedia.org/lib/exe/fetch.php?cache=&media=criteria:novato.png'
        ));

        $WalletIssuer = Issuer::create(array(
            'origin' => 'http://openwallet.io', 'name' => 'OpenWallet Team', 'contact' => 'contact@openwallet.io'
        ));

        $WalletIssuer->badges()->save($firstBadge);
        $firstBadge->criteria .= $firstBadge->id;
        $firstBadge->save();


        $newUser->badges()->attach($firstBadge, array(
            'issued_on' => date('Y-m-d H:i:s', time()),
            'added_on' => date('Y-m-d H:i:s', time())
        ));

        $newTag = new Tag(array(
          'tag' => 'myTag'
        ));
        $newTag->by($newUser)->save();
        $newTag2 = new Tag(array(
            'tag' => 'myTag'
        ));
        $newTag2->by($newUser2)->save();


        //$newUser->tags()->save($newTag);

        //$newTag->tagBadge($firstBadge);
        //$newTag2->tagBadge($firstBadge);
        //$firstBadge->addTag($newTag);
        //$firstBadge->addTag($newTag2);

        echo "\n\n".$newTag->badges."\n\n";


    }

}

class OAuth_ClientTableSeeder extends Seeder {

    public function run()
    {
        DB::table('oauth_client_grants')->delete();
        DB::table('oauth_client_scopes')->delete();
        DB::table('oauth_clients')->delete();
        DB::table('oauth_grants')->delete();
        DB::table('oauth_scopes')->delete();

        $firstGrant = OAuthGrant::create(array(
            'grant' => 'authorization_code',
        ));

        $secondGrant = OAuthGrant::create(array(
            'grant' => 'password'
        ));

        $thirdGrant = OAuthGrant::create(array(
            'grant' => 'client_credentials'
        ));

        $fourthGrant = OAuthGrant::create(array(
            'grant' => 'refresh_token'
        ));

        $basicScope = OAuthScope::create(array(
            'scope' => 'basic',
            'name'  => 'basic',
            'description' => 'Basic Scope'
        ));

        $appScope = OAuthScope::create(array(
            'scope' => 'app',
            'name'  => 'appScope',
            'description' => 'Scope for the OpenWallet App'
        ));


        $firstClient = OAuthClient::create(array(
            'id' => str_random(40),
            'secret' => str_random(40),
            'name' => "mainClient"
        ));

        $secondClient = OAuthClient::create(array(
            'id' => str_random(40),
            'secret' => str_random(40),
            'name' => "appClient"
        ));

        $firstClient->grants()->attach($thirdGrant);
        $firstClient->scopes()->attach($basicScope);

        $secondClient->grants()->attach($secondGrant);
        $secondClient->scopes()->attach($appScope);



    }

}

class CategoryTableSeeder extends Seeder {

    public function run()
    {

        DB::table('categories')->delete();

        Category::create(array('id' => 'education', 'regular_expressions' => ''));
    }

}
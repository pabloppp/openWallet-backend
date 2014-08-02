<?php
/**
 * Created by PhpStorm.
 * User: pablopernias
 * Date: 01/08/14
 * Time: 19:36
 */

class Mozilla {

    public static function importBadges($email, $user)
    {
        $url = 'http://backpack.openbadges.org/displayer/convert/email';
        $field = ["email" => $email];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $field);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $jsonData = json_decode($result);
        $mozillaUserId = $jsonData->userId;

        try{
            $addedAccount = new Account();
            $addedAccount->name = $jsonData->email;
            $addedAccount->secret = "";
            $addedAccount->account_type = "mozilla";
            $user->accounts()->save($addedAccount);
        }catch(Exception $e){
            $addedAccount = Account::where("user_id",$user->id)
                ->where("name",$jsonData->email)
                ->where("account_type","mozilla")
                ->firstOrFail();
        }

        $collectionResult = json_decode(file_get_contents("http://backpack.openbadges.org/displayer/$mozillaUserId/groups.json"), false);
        $collections = $collectionResult->groups;
        $tagCount = 0;
        $badgeCount = 0;
        foreach($collections as $collection ){

            $groupId = $collection->groupId;
            $tagName = $collection->name;

            try{
                $newTag = new Tag();
                $newTag->tag = $tagName;
                $newTag->account()->associate($addedAccount);
                $user->tags()->save($newTag);
                $tagCount++;
            } catch(Exception $e){
                $newTag = $user->tags()->where("tag", $tagName)->firstOrFail();
                $newTag->account()->associate($addedAccount);
                $newTag->save();
            }


            $badgesResult = json_decode(file_get_contents("http://backpack.openbadges.org/displayer/$mozillaUserId/group/$groupId.json"), false);

            $badges = $badgesResult->badges;

            foreach($badges as $badge){

                try{
                    $addedIssuer = new Issuer((array)$badge->assertion->badge->issuer);
                    $addedIssuer->save();
                    //echo "\n".$addedIssuer->id;
                }catch(Exception $e){
                    $addedIssuer = Issuer::where("origin",$badge->assertion->badge->issuer->origin)
                    ->where("name",$badge->assertion->badge->issuer->name)
                    ->where("contact",$badge->assertion->badge->issuer->contact)->firstOrFail();
                    //echo "\n".$addedIssuer->id;
                }

                try{
                    $addedBadge = new Badge();
                    $addedBadge->version = $badge->assertion->badge->version;
                    $addedBadge->name = $badge->assertion->badge->name;
                    $addedBadge->description = $badge->assertion->badge->description;
                    $addedBadge->criteria = $badge->assertion->badge->criteria;
                    $addedBadge->image_remote = $badge->assertion->badge->image;
                    $addedBadge->issuer_id = $addedIssuer->id;
                    $addedBadge->save();
                }catch(Exception $e){
                    $addedBadge = Badge::where("version", $badge->assertion->badge->version)
                        ->where("name", $badge->assertion->badge->name)
                        ->where("description", $badge->assertion->badge->description)
                        ->where("criteria", $badge->assertion->badge->criteria)
                        ->where("image_remote", $badge->assertion->badge->image)
                        ->where("issuer_id", $addedIssuer->id)->firstOrFail();
                }

                try{
                    $user->badges()->attach($addedBadge, array(
                        'issued_on' => date('Y-m-d H:i:s', strtotime($badge->assertion->issued_on)),
                        'added_on' => date('Y-m-d H:i:s', time()),
                        'recipient' => $badge->assertion->recipient,
                        'salt' => $badge->assertion->salt,
                        'accepted' => true
                    ));
                    $badgeCount++;

                }catch(Exception $e){

                }

                try{
                    $addedBadge->tags()->attach($newTag, ["tagged_on"=>date('Y-m-d H:i:s', time())]);
                }catch(Exception $e){

                }
               //echo $badge->assertion->badge->name;
            }

            //var_dump($badgesResult);
        }

        return Response::json(["sucess"=>["message"=>"Added $tagCount tags and $badgeCount badges","code"=>200]], 200);
    }

} 
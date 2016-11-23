<?php


namespace HJK\Discussions;

class HjkDiscussionsWatchModel extends \Model {
 
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_hjk_discussions_watch';
 
 
 
    public static function findByPost ( $post ) {
        $database = \Database::getInstance ();
        
        $query = $database->prepare ( 
            "select * from ". static::$strTable 
            . " where discussion_group = ? or ( parent_type = ? and discussion_id = ?)"
        );
        $result = $query->execute ( $post->pid, $post->parent_type, $post->discussion_id );
        
        return \Model\Collection::createFromDbResult($result, static::$strTable );
    }
 
 
    public static function triggerWatches ( HjkDiscussionsPostModel $post) {
        if ( ! $GLOBALS['TL_CONFIG']['hjk_discussions_notification_enabled'] ) {
            return;
        }
        
       // get watches for this post
        $watches = self::findByPost ( $post );
        
        $currentUser = \FrontendUser::getInstance();
        foreach ( $watches as $watch ) {
            if ( $currentUser->id == $watch->member ) {
                // do not notify the member posting the comment!
                continue;
            }
            
            $email = new \Email();

            $subject = $GLOBALS['TL_CONFIG']['hjk_discussions_notification_subject'];
            $content = $GLOBALS['TL_CONFIG']['hjk_discussions_notification_mail_template'];
            
            $email->subject  = self::_replacePlaceholders ( $subject, $post, $watch );
            $email->text = str_replace ('\n', "\n", self::_replacePlaceholders ( $content, $post, $watch ));
            
            if ( $sender_email = $GLOBALS['TL_CONFIG']['hjk_discussions_notification_sender_email'] ) {
                $email->from = $sender_email;
            }
            if ( $sender_name = $GLOBALS['TL_CONFIG']['hjk_discussions_notification_sender_name'] ) {
                $email->fromName = $sender_name;
            }
            
            if ( $member = $watch->getRelated ('member')) {
                $address = $member->email;
            } else {
                $address = $watch->getRelated ('user')->email;
            }
            
            try
            {
                $email->sendTo( $address );
            }
            catch (\Exception $e)
            {
                \System::log( 'error sending discussion post mail to ' . $address. ': ' . $e->getMessage(), __METHOD__, TL_ERROR);
            }
        }
    }
    
    
    protected static function _replacePlaceholders ( $content, $post, $watch ) {
        $environment = \Environment::getInstance();

        if ( $member = $watch->getRelated ( "member")) {
            $name = $member->firstname;
            $user = $member->username;
        } else {
            $name = $watch->getRelated ('user')->name;
            $user = $watch->getRelated ('user')->username;
        }

        $patterns = array (
            "/##subject##/i",
            "/##content##/i",
            "/##domain##/i",
            "/##link##/i",
            "/##author_firstname##/i",
            "/##author_lastname##/i",
            "/##author_username##/i",
            "/##rec_name##/i",
            "/##rec_username##/i",
        );
        $replacements = array (
            $post->subject,
            $post->content,
            $environment->httpHost,
            $environment->url.$environment->requestUri,
            $post->getRelated("member")->firstname,
            $post->getRelated("member")->lastname,
            $post->getRelated("member")->username,
            $name,
            $user,
        );
        
        return preg_replace ( $patterns, $replacements, $content );
    }
    
    
    
}
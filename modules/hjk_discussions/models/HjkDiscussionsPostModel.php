<?php


namespace HJK\Discussions;

class HjkDiscussionsPostModel extends \Model {
 
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_hjk_discussions_post';
 
 
 
    public function sendAdminMail () {
        $this->Environment = \Environment::getInstance();
        
        $address = $GLOBALS['TL_CONFIG']['hjk_discussions_admin_email'];
        if ( ! $address ) 
            return;
        
        $member = $this->getRelated ('member');
        $email = new \Email();

        $text = "Hallo,\n\nauf der Webseite gibt es einen neuen Kommentar unter <".$this->Environment->url.$this->Environment->requestUri.">:\n\n"
            . "Absender: " . $member->firstname . " " . $member->lastname . " (" . $member->username . ")\n"
            . "Betreff: " . $this->subject . "\n"
            . "\n"
            . $this->content
            . "\n\n\n"
            . "/Dein Contao-System/\n"
            . "-- \n"
            . "Diese Mail wurde automatisch erstellt\n";
            
        $email->text = $text;
        $email->subject  = "[".$this->Environment->httpHost."] Neuer Kommentar: " . $this->subject;
        
        // Send the e-mail
        try
        {
            $email->sendTo( $address );
        }
        catch (\Exception $e)
        {
            $this->log( 'error sending discussion post mail to ' . $address. ': ' . $e->getMessage(), __METHOD__, TL_ERROR);
        }
    }
 
 
 
    public static function findByThread ( $pid, $type, $threadId, $bSortDesc = true ) {
        $sort = "date_posted";
        if ( $bSortDesc ) 
            $sort .= " desc";
        
        return self::findBy (
            array ( "pid=?", "parent_type=?", "discussion_id=?", "published=?"),
            array ( $pid, $type, $threadId, true ),
            array ("order" => $sort)
        );
    }
 
}
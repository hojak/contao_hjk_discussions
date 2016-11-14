<?php


namespace HJK\Discussions;

class HjkDiscussionsPostModel extends \Model {
 
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_hjk_discussions_post';
 
 
 
 
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
<?php


namespace HJK\Discussions;


class HjkDiscussionsGroupModel extends \Model {
    
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_hjk_discussions_group';
    
 
    
    /**
     * @brief 
     * @param <unknown> $type 
     * @param <unknown> $id 
     * @param <unknown> $replyTree 
     * @return  
     */
    public function getPublicPosts ( $type, $id, $replyTree ) {
        
        if ( $replyTree )
            return $this->getPublicPostsTree ( $type, $id );
        else    
            return $this->getPublicPostsFlat( $type, $id );
    }
    
    
    public function getPublicPostsFLat ( $type, $id ) {
        return HjkDiscussionsPostModel::findByThread ( $this->id, $type, $id );
    }
   
   
    public function getPublicPostsTree ( $type, $id ) {
        $posts = HjkDiscussionsPostModel::findByThread ( $this->id, $type, $id, false );
        
        $rootPosts = array ();
        $id2post = array ();

        if ( $posts ) {
            foreach ( $posts as &$post ) {
                $id2post [ $post->id ] = &$post;

                if ( $post -> reply_to ) {
                    $answers = $id2post[$post->reply_to]->replies;
                    if ( ! $answers )
                        $answers = array ();
                    array_unshift ( $answers, "temp" );
                    $answers[0] = &$post;
                    $id2post[$post->reply_to]->replies = $answers;
                } else {
                    array_unshift ( $rootPosts, "temp" );
                    $rootPosts[0] = &$post;
                }
            }
        } else
            return array ();


        return $rootPosts;
    }
}

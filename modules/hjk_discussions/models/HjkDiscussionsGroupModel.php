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
        return HjkDiscussionPostModel::findByThread ( $this->id, $type, $id );
    }
   
   
    public function getPublicPostsTree ( $type, $id ) {
        $posts = HjkDiscussionsPostModel::findByThread ( $this->id, $type, $id, false );
        
        $rootPosts = array ();
        $id2post = array ();
        
        foreach ( $posts as $post ) {
            $id2post [ $post->id ] = &$post;
            if ( ! $posts -> reply_to ) {
                array_unshift ( $rootPosts, $post );
            } else {
                $answers = $id2post[$post->reply_to];
                array_unshift ( $answers, $post );
                $id2post[$post->reply_to]->replies = $answers;
            }
        }
        
        return $rootPosts;
    }
}
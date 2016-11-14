<?php


namespace HJK\Discussions;



class FEDiscussion extends \Module {
    
    protected $strTemplate = 'mod_hjk_discussion';
    
    protected static $defaultPostTemplate = 'mod_hjk_discussion_post';
    
    
    public function generate () {
        return parent::generate();
    }

    protected function compile() {
        if (TL_MODE == 'BE') {
            return $this->compileBackend();
        } else {
            return $this->compileFrontend();
        }
    }
    
    private function compileBackend () {
        $this->strTemplate          = 'be_wildcard';
        $this->Template             = new \BackendTemplate($this->strTemplate);
        $this->Template->title      = $this->headline;
        $this->Template->wildcard   = "### (HJK) Diskussion) ###";
    }
    
    
    private function compileFrontend () {
        $this->import ( "FrontendUser", "User");  

        $this->initialize();
                
        $this->handleFormSubmit ();
        
        $this->posts = $this->discussionGroup->getPublicPosts( $this->hjk_discussion_parent_type, $this->currentDiscussionId, $this->hjk_discussion_reply );
        
        $renderedPosts = array ();
        foreach ( $this->posts as $post )
            $renderedPosts[] = $this->renderPost($post);
        
        $this->Template->user = $this->User;
        $this->Template->discussionGroup = $this->discussionGroup;
        $this->Template->posts = $this->posts;
        $this->Template->renderedPosts = $renderedPosts;
    }
    
    
    
    private function renderPost ( $post ) {
        $result = "";
        
        $templateFile = static::$defaultPostTemplate;
        if ( $this->hjk_discussion_post_template )
            $templateFile = $this->hjk_dicussion_post_template;
        
        $template = new \Contao\Template( $templateFile );
        
        $template->module = $this;
        $template->group = $this->discussionGroup;
        
        if ( $replies = $post->replies ) {
            $renderedReplies = array ();
            foreach ( $replies as $reply  ) {
                $renderedReplies[] = $this->renderPost ( $reply );
            }
            $template->replies = $renderedReplies;
        }
            
        return $template->parse();
    }
    
    
    
    private function handleFormSubmit () {
        // TODO
    }
    
    
    private function initialize () {
        $this->discussionGroup = HjkDiscussionsGroupModel::findById ($this->hjk_discussion_group);
        
        switch ( $this->hjk_discussion_parent_type) {
            case 'page':
                $this->currentDiscussionId = "a page";
                break;
            case 'url':
                $this->currentDiscussionId = "an url";
                break;
            case 'module':
            default;
                $this->currentDiscussionId = "the module!";
        }
        $this->currentDiscussionId = "hallo";

   }
    
}
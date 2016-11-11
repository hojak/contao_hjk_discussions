<?php


namespace HJK\Discussions;



class FEDiscussion extends \Module {
    
    protected $strTemplate = 'mod_hjk_discussion';
    
    
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
        
        $this->Template->user = $this->User;
        
        $this->Template->discussionGroup = HjkDiscussionsGroupModel::findById ($this->hjk_discussion_group);
        
        $this->Template->posts = $this->Template->discussionGroup->getPublicPosts( $this->hjk_discussion_reply );
        
    }
    
}
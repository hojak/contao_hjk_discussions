<?php


namespace HJK\Discussions;



class FEDiscussion extends \Module {
    
    protected $strTemplate = 'mod_hjk_discussion';
    
    protected static $defaultPostTemplate = 'mod_hjk_post';

    protected static $postFormName = 'hjk_send_post';
    
    
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
        $this->Template->formName = static::$postFormName;
        $this->Template->open = $this->hjk_discussion_open;

        $this->Template->replies = $this->hjk_discussion_reply;
        $this->Template->module_id = $this->id;

        if ( $this->Session->get('hjk_discussion_confirm')) {
            $this->Template->confirm = 1;
            $this->Session->remove('hjk_discussion_confirm');
        }

        if ( $error = $this->Session->get('hjk_discussion_error')) {
            $this->Template->error = $error;
            $this->Session->remove('hjk_discussion_error');
        }

        if ($this->hjk_discussion_reply ) {
            $GLOBALS['TL_JAVASCRIPT'][] = '/system/modules/hjk_discussions/assets/js/reply.js';
        }
    }
    
    
    
    private function renderPost ( $post, $level = 1 ) {
        $result = "";
        
        $templateFile = static::$defaultPostTemplate;
        if ( $this->hjk_discussion_postTpl )
            $templateFile = $this->hjk_discussion_postTpl;
        
        $template = new \Contao\FrontendTemplate( $templateFile );
        
        $template->module = $this;
        $template->group = $this->discussionGroup;
        $template->level = $level;
        $template->subject = $post->subject;
        $template->content = $post->content;
        $template->member_id = $post->member;
        $template->reply = $this->hjk_discussion_reply;
        $template->post_id = $post->id;
        $template->module_id = $this->id;
        $template->date_posted = $post->date_posted;

        
        if ( $replies = $post->replies ) {
            $renderedReplies = array ();
            foreach ( $replies as $reply  ) {
                $renderedReplies[] = $this->renderPost ( $reply, $level+1 );
            }
            $template->renderedReplies = $renderedReplies;
        }
            
        return $template->parse();
    }
    
    
    
    private function handleFormSubmit () {
        if ( ($form = \Input::post('FORM_SUBMIT') ) && ( $form == static::$postFormName) ) {

            if ( ! FE_USER_LOGGED_IN ) {
                $this->Session->set('hjk_discussion_error', "noLogin");
                return \Controller::redirect ( $this->addToUrl ("") );
            }

            if ( ! \Input::post('subject')) {
                $this->Session->set('hjk_discussion_error', "noSubject" );
                return \Controller::redirect ( $this->addToUrl ("") );
            } elseif ( ! \Input::post('content')) {
                $this->Session->set('hjk_discussion_error', "noContent" );
                return \Controller::redirect ( $this->addToUrl ("") );
            } else {
                $post = new HjkDiscussionsPostModel ();
                $post -> subject =  \Input::post('subject');
                $post -> content =  \Input::post('content');
                $post -> pid = $this->hjk_discussion_group;
                $post -> parent_type = $this->hjk_discussion_parent_type;
                $post -> discussion_id = $this->currentDiscussionId;
                $post -> member = $this->User->id;
                $post -> date_posted = time();
                $post -> published = 1;
                $post -> page_url = $this->addToUrl();

                $replyTo = null;
                if ($replyId = \Input::post("reply_to")) {
                    $replyTo = HjkDiscussionsPostModel::findById ( $replyId );
                    if ( $replyTo && ($replyTo->discussion_id == $this->currentDiscussionId) && ( $replyTo->pid == $this->hjk_discussion_group ) ) {
                        $post->reply_to = $replyTo->id;
                    }
                }

                $post->save();

                $group = HjkDiscussionsGroupModel::findById ( $this->hjk_discussion_group);
                $group ->date_last_post = time();
                $group->save();

                $this->Session->set('hjk_discussion_confirm', 1);
                return \Controller::redirect ( $this->addToUrl ("") );
            }
        }
    }


    private function extractCurrentUrl () {
        $rq = $this->Environment->request;
        if ( ($pos = strpos($rq, "?")) !== false )
            $rq = substr ( $rq, 0, $pos );

        return $rq;
    }
    
    
    private function initialize () {
        $this->import ( "FrontendUser", "User");
        $this->import ("Environment");
        $this->import ("Session");


        $this->discussionGroup = HjkDiscussionsGroupModel::findById ($this->hjk_discussion_group);

        global $objPage;

        // TODO
        switch ( $this->hjk_discussion_parent_type) {
            case 'page':
                $this->currentDiscussionId = $objPage->id;
                break;
            case 'url':
                $this->currentDiscussionId = $this->extractCurrentUrl();
                break;
            case 'globalObj':
                global $hjkDiskussionBase;
                if ( $hjkDiskussionBase ) {
                    $this->currentDiscussionId = get_class($hjkDiskussionBase) . "/" . $hjkDiskussionBase->id;
                } else {
                    $rq = $this->Environment->request;
                    if ( ($pos = strpos($rq, "?")) !== false )
                        $rq = substr ( $rq, 0, $pos );

                    $this->currentDiscussionId = $this->extractCurrentUrl();
                }
                break;
            case 'module':
            default;
                $this->currentDiscussionId = $this->id;
        }
   }
    
}

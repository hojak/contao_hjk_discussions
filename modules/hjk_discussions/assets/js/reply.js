function hjk_discussion_reply_click ( moduleId, postId ) {
    var form = $('hjk_discussion_' + moduleId);

    form['subject'].value = "RE: " + $$('#post_' + moduleId + "_" + postId + " .hjk_post_subject")[0].innerHTML;
    form['content'].value = ">> " + $$('#post_' + moduleId + "_" + postId + " .hjk_post_content")[0].innerHTML.replace (/&gt;/g, ">").replace (/\n/g, "\n>> " );
    form['reply_to'].value = postId ;

    form['content'].focus();
}

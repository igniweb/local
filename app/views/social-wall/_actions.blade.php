<p class="item-actions">
    @if ($item->type == 'twitter')
        <a class="btn btn-primary" href="https://www.twitter.com/intent/tweet?in_reply_to={{ $item->type_id }}" target="_blank">{{ trans('social-wall.reply-to') }}</a>
        <a class="btn btn-primary" href="https://www.twitter.com/intent/retweet?tweet_id={{ $item->type_id }}" target="_blank">{{ trans('social-wall.retweet') }}</a>
    @endif
    @if ($item->type == 'facebook')
        <a class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u={{ $item->url }}" target="_blank">{{ trans('social-wall.share') }}</a>
    @endif
    <a class="btn btn-primary" href="{{ $item->url }}" target="_blank">{{ trans('social-wall.details') }}</a>
</p>
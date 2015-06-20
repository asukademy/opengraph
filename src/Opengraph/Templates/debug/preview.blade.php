<style>
    .preview-box {
        border: 1px solid #e9eaed;
        width: 471px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }
    .preview-img {
        width: 470px;
        height: 246px;
        background-size: cover;
    }
    .preview-text-box-inner {
        margin-bottom: 10px;
        margin-left: 12px;
        margin-right: 12px;
        margin-top: 10px;
    }
    .preview-title {
        color: #141823;
        text-decoration: none;
        -webkit-transition: color .1s ease-in-out;
        cursor: pointer;
        font-family: Georgia, 'lucida grande',tahoma,verdana,arial,sans-serif;
        font-size: 19px;
        font-weight: 500;
        line-height: 22px;
        word-wrap: break-word;
        margin-bottom: 5px;
        max-height: 110px;
    }
    .preview-title a {
        color: #141823;
        text-decoration: none;
        -webkit-transition: color .1s ease-in-out;
        cursor: pointer;
    }
    .preview-box-link {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        height: 400px;
        width: 100%;
        z-index: 500;
    }
    .preview-desc {
        color: rgb(78, 86, 101);
        font-size: 13px;
        line-height: 16px;
        max-height: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .preview-host {
        -webkit-font-smoothing: antialiased;
        color: rgb(78, 86, 101);
        text-transform: uppercase;
        display: block;
        font-size: 13px;
        line-height: 18px;
        padding-top: 9px;
        position: relative;
        text-align: left;
        word-wrap: break-word;
    }
</style>
<script>
    var Preview = {
        imgs: [
            <?php
            $imgs = \Windwalker\Utilities\ArrayHelper::getColumn((array) $fb->image, 'url');
            $imgs = array_map(function($v)
            {
                return \Windwalker\String\StringHelper::quote($v, '"');
            }, $imgs);
            echo implode(", \n", $imgs);
            ?>
        ],
        current: -1,
        init: function()
        {
            this.previewImg = jQuery('.preview-img');

            this.next();
        },
        next: function()
        {
            this.switchTo(this.current + 1, 0);
        },
        previous: function()
        {
            this.switchTo(this.current - 1, this.imgs.length - 1);
        },
        switchTo: function(num, defaultNum)
        {
            var img = '';

            if (typeof this.imgs[num] === 'undefined')
            {
                num = defaultNum;

                img = this.imgs[defaultNum];
            }
            else
            {
                img = this.imgs[num];
            }

            this.previewImg.css('background-image', 'url(' + img + ')');

            this.current = num;
        }
    };

    jQuery(document).ready(function()
    {
        Preview.init();
    });
</script>

<div class="preview-box">
    <div class="preview-img">

    </div>
    <div class="preview-text-box">
        <div class="preview-text-box-inner">
            <a class="preview-box-link" href="{{{ $q }}}" rel="nofollow" target="_blank"></a>
            <div class="preview-title">
                <a href="{{{ $q }}}" rel="nofollow" target="_blank">
                    {{{ $fb->title }}}
                </a>
            </div>
            <div class="preview-desc">
                {{{ $fb->description }}}
            </div>
            <div class="preview-host">
                <div class="text-muted">{{{ $preview_uri->getHost() }}}</div>
            </div>
        </div>
    </div>
</div>
<br />
<div class="text-center">
    <div class="btn-group">
        <button type="button" class="btn btn-default" onclick="Preview.previous();"><span class="glyphicon glyphicon-chevron-left"></span></button>
        <button type="button" class="btn btn-default" onclick="Preview.next();"><span class="glyphicon glyphicon-chevron-right"></span></button>
    </div>
</div>
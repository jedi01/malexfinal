<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h5 class="page-title"><?php echo $page_title;?></h5>
<hr />
<div class="timeline-centered col-md-12">
    <?php foreach ($activities as $key => $activity): ?>
    <article class="timeline-entry <?php echo (($key==count($activities)-1)?"begin":"") ?>">
        <div class="timeline-entry-inner">
            <time class="timeline-time" datetime="<?php echo $activity->date; ?>">
                <?php if ( date("H:i", strtotime($activity->date)) != "00:00" ): ?>
                    <span><?php echo date("H:i", strtotime($activity->date)) ?></span>
                <?php endif ?>
                <span><?php echo date(PHP_DATE, strtotime($activity->date)) ?></span>
            </time>
            <div class="timeline-icon <?php echo $activity->bg; ?>">
                <i class="fa fa-<?php echo $activity->icon; ?>"></i>
            </div>
            <div class="timeline-label">
                <h2><a><?php echo $activity->username; ?></a></h2>
                 <p><?php echo $activity->content; ?></p>
            </div>
        </div>
    </article>
    <?php endforeach ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>

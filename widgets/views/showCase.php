<div class="row">
    <div class="col-sm-12">
        <input class="form-control" type="text" name="name" value="" placeholder="быстрый поиск товара">
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <a>крошки</a><span> / </span><a>крошки</a><span> / </span><a>крошки</a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="showcase">
            <?php foreach ($categories as $key => $category) { ?>
                <?php if (!is_null($category->parent_id)) { ?>
                <div class="showcase-item">
                    <div class="title text-center">
                        <?= $category->name ?>
                    </div>
                    <div class="image text-center">

                    </div>
                </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

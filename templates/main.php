<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach($categories as $category): ?>
                <li class="promo__item promo__item--<?= htmlspecialchars($category["code"]); ?>">
                    <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category["title"]); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach($open_lots as $open_lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($open_lot["img_url"]); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($open_lot["category"]); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= htmlspecialchars($open_lot['id'])?>"><?= htmlspecialchars($open_lot["title"]); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= number_format(htmlspecialchars($open_lot["price"]), 0, ","," "); ?><b class="rub">р</b></span>
                            </div>
                            <div class="lot__timer timer  <?php if (get_dt_range($open_lot["date_end"])[0] < 1) echo "timer--finishing"; ?>">
                                <?=sprintf('%02d:%02d:%02d', get_dt_range($open_lot["date_end"])[0], get_dt_range($open_lot["date_end"])[1], get_dt_range($open_lot["date_end"])[2]);?>

                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
